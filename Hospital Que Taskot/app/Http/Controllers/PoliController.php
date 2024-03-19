<?php

namespace App\Http\Controllers;

use App\Models\PatientQueue;
use App\Models\PatientQueueDetail;
use App\Models\User;
use App\Models\Poli;
use App\Models\PoliSchedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class PoliController extends Controller
{
    
    public function index()
    {
        $polis = Poli::where([
            'is_active' => 1,
            'is_deleted' => 0
        ])->get();
        return view('poli.index', [
            'polis'=> $polis
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'poliName' => 'required', 
        ]);

        $poli = new Poli();
        $poli->name = $request->poliName;
        $poli->quota = 0;
        $poli->note = "-";
        $poli->is_active = true;
        $poli->save();   
        return response()->json(['success' => 'Poli berhasil ditambahkan.']);  
        // return redirect('form')->with('status', 'Poli berhasil ditambahkan');
    }

    public function showDetail(string $id)
    {
        if(request()->ajax()) {
            return datatables()->of(PoliSchedule::select('*')->where([
                'fk_poli_id' => $id
            ]))
                ->addColumn('action', 'poliSchedule.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            
        }
        $ids = Auth::id();
        $user = User::where('id',$ids)->first();
        $poli = Poli::findOrFail($id);
        return view('poli.form', [
        'poli'=> $poli,
        'poliId' => $id,
        'user' =>$user
        ]);

    }

    public function save(Request $request)
    {
        $request->validate([
            'poliName' => 'required', 
            'quota' => 'required',
            'note' => 'required',
        ]);

        $poli = Poli::findOrFail($request->poliId);
        $poli->name = $request->poliName;
        $poli->quota = $request->quota;
        $poli->note = $request->note;
        $poli->save();   

        if (auth()->user()->name == "Admin"){
            return redirect(route('poli'));
        } else {
            return redirect()->back();
        }

    }

    public function deleteSchedule(Request $request)
    {
        $com = PoliSchedule::where('id',$request->id)->delete();
        return Response()->json($com);
    }

    public function addSchedule(Request $request)
    {
        $request->validate([
            'scheduleDay' => ['required', "in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu"],
            'scheduleStart' => 'required',
            'scheduleEnd' => 'required',
        ]);

        $poliSchedule = new PoliSchedule();
        $poliSchedule->fk_poli_id = $request->poliId;
        $poliSchedule->day = $request->scheduleDay;
        $poliSchedule->start_time = $request->scheduleStart;
        $poliSchedule->end_time = $request->scheduleEnd;
        $poliSchedule->is_active = true;
        $poliSchedule->is_deleted = false;
        $poliSchedule->save();   
        return response()->json(['success' => 'Jadwal berhasil ditambahkan.']);  
    }

    public function getSchedule(Request $request)
    {
        $ps = PoliSchedule::where([
            'fk_poli_id' => $request->poliId,
            'is_active' => 1,
            'is_deleted' => 0
            ])->get();
        return Response()->json($ps);
    }

    public function getPoliNote($poliId)
    {
        $poli = Poli::find($poliId);

        if (!$poli) {
            return response()->json(['note' => 'Poli not found'], 404);
        }

        return response()->json(['note' => $poli->note]);
    }
    protected function adminPoliRegister(Request $data)
    {

        $rules = array(
            'Email' => 'required|email|unique:users',
            'name' => 'required|string|max:255|unique:users',
            'poliId' => 'required|not_in:Pilih',
            'Password' => 'required'
        );
        $validator = Validator::make($data->all(), $rules);

        if($validator->fails()){
            return Redirect::to('/adminPoliRegister')->withInput()->withErrors($validator);
        }else{
            $admin = new User();
            $admin->name = $data->input('name');
            $admin->email = $data->input('Email');
            $admin->password = bcrypt($data->input('Password'));
            $admin->fk_poli_id = $data->input('poliId');
            $admin->save();
            $admin->assignRole('adminPoli');  

        return redirect()->back()->with('success', 'Berhasil mendaftarkan admin poli!');
        }

    }

    // public function destroy(Request $request, $id){
    //      // Find the resource by ID
    //      $Poli = Poli::findOrFail($id);
    //     //  start
    //     $jadwal = PoliSchedule::where('fk_poli_id', $id)->count();
    //     if($jadwal > 0) {
    //         return redirect()->back()->with('error', 'Silahkan hapus jadwal poli terlebih dahulu, pastikan juga laporan antrian untuk  sudah di cetak');
    //     }

    //     // end
    //      $selectedPatientQueue = PatientQueue::where('fk_poli_id', $id)->first();
    //      PoliSchedule::where('fk_poli_id', $id)->delete();
    //      if($selectedPatientQueue != null){
    //         $PatientQueueId = $selectedPatientQueue->id;
    //         PatientQueueDetail::where('fk_patient_queue_id', $PatientQueueId)->delete();
    //      }
         
    //      PatientQueue::where('fk_poli_id', $id)->delete();
    //      $Poli->delete();
    //      // Redirect to the index page with a success message
    //      return redirect()->route('poli')->with('success', 'Poli deleted successfully');
    // }
    public function destroy(Request $request, $id)
{
    // Temukan data poli berdasarkan ID
    $poli = Poli::findOrFail($id);

    // Periksa apakah ada jadwal terkait
    $jadwal = PoliSchedule::where('fk_poli_id', $id)->count();
    if ($jadwal > 0) {
        // Jika ada jadwal terkait, kirim pesan kesalahan dengan nama poli
        return redirect()->back()->with('error', 'Silahkan hapus jadwal poli terlebih dahulu, dan pastikan juga laporan antrian untuk ' . $poli->name . ' sudah di cetak');
    }

    // Cari dan hapus antrian yang terkait dengan poli
    $selectedPatientQueue = PatientQueue::where('fk_poli_id', $id)->first();
    PoliSchedule::where('fk_poli_id', $id)->delete();
    if ($selectedPatientQueue != null) {
        $PatientQueueId = $selectedPatientQueue->id;
        PatientQueueDetail::where('fk_patient_queue_id', $PatientQueueId)->delete();
    }
    
    // Hapus poli
    PatientQueue::where('fk_poli_id', $id)->delete();
    $poli->delete();

    // Redirect kembali ke halaman poli dengan pesan sukses
    return redirect()->route('poli')->with('success', 'Poli deleted successfully');
}

    public function adminPoliRegisterPage(){
        $polis = Poli::where([
            'is_active' => '1',
            'is_deleted' => '0',
        ])->get();

        $data = [
            'polis' => $polis,
            'redirectUrl' => '#'
        ];
        $users = User::whereNotNull('fk_poli_id')
        ->join('polis', 'users.fk_poli_id', '=', 'polis.id')
        ->select('users.*' , 'polis.name as poliName')
        ->get();
        return view('adminPoliDashboard.index', compact('users'),$data);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'Email' => 'required|email|unique:users,email,' . $id,
        'Password' => 'required',
        'poliId' => 'required|not_in:Pilih',
       
    ]);

    $user = User::find($id);
    $user->name = $request->input('name');
    $user->email = $request->input('Email');
    $user->password = $request->input('Password');
    $user->fk_poli_id = $request->input('poliId');
    

    $user->save();

    return redirect()->route('adminPoli.Register.Page')->with('status', 'Data berhasil diperbarui.');
}

public function delete($id)
{
    
    $user = User::find($id);
    $user->delete();

    return redirect()->route('adminPoli.Register.Page')->with('status', 'Data berhasil dihapus');
}
    
    // search
    public function search(Request $request)
    {
        // Ambil input pencarian dari request
        $search = $request->input('search');
    
        // Query untuk mencari data berdasarkan input pencarian
        $users = User::where('name', '=', $search)
                     ->orWhere('email', '=', $search)
                     ->orWhereHas('poli', function($query) use ($search) {
                         $query->where('name', 'like', '%' . $search . '%');
                     })
                     ->with('poli') // Memuat relasi poli
                     ->get();
    
        // Kirim data yang telah disaring ke view
        return view('adminPoliDashboard.index', compact('users'));
    }
    













    // // kuota
    // public function getQuotaInfo(Request $request)
    // {
    //     $poliId = $request->poliId;
    //     $date = $request->date;
    
    //     // Mendapatkan jumlah kuota poli
    //     $quota = Poli::where('id', $poliId)->value('quota');
    
    //     // Mendapatkan jumlah kuota terisi pada tanggal tertentu
    //     $filledQuota = PoliSchedule::where('fk_poli_id', $poliId)
    //         ->whereDate('start_time', '<=', $date)
    //         ->whereDate('end_time', '>=', $date)
    //         ->where('is_active', true)
    //         ->where('is_deleted', false)
    //         ->count();
    
    //     // Menghitung sisa kuota
    //     $availableQuota = $quota - $filledQuota;
    
    //     return response()->json([
    //         'quota' => $quota,
    //         'filledQuota' => $filledQuota,
    //         'availableQuota' => $availableQuota,
    //     ]);
    // }
}

