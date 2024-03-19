<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientQueueDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use PDF;

class PatientController extends Controller
{
    public function index()
    {
        // $join = PatientQueueDetail::join('patients', 'patient_queue_details.fk_patient_id', '=', 'patients.id')
        //     ->join('patient_queues', 'patient_queue_details.fk_patient_queue_id', '=', 'patient_queues.id')
        //     ->select('patients.*', 'patient_queue_details.*','patient_queues.*')
        //     ->get();
        //     // where([
        //     //     'patient_queues.is_active' => 1,
        //     //     'patient_queues.is_deleted' => 0
        //     // ]);
        //     dd($join);
        return view('patient.index');
    }
    public function showAdd() 
    {
        return view('patient.form', [
            'formName' => 'Form Tambah Pasien',
            'formUrl' => route('patient.store'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Tambah Pasien'
        ]);
    }

    public function showPrint() 
    {
        return view('patient.registerDownload', [
            'formName' => 'Form Tambah Pasien',
            'formUrl' => route('patient.downloadRegisterPatient'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Tambah Pasien'
        ]);
    }
    
    

    public function showData()
    {
        if(request()->ajax()) {
            return datatables()->of(Patient::select('*')->where([
                'is_active' => 1,
                'is_deleted' => 0
            ]))
                ->addColumn('action', 'patient.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            
        }
        return null;

    }

    public function showDetail(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.form', [
            'patient' => $patient,
            'formName' => 'Form Edit Pasien',
            'formUrl' => route('patient.save'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Edit Pasien'
        ]);

    }


    public function downloadRegisterPatient(Request $request)
    {

        $patient = Patient::all();
        $print = $request->input('print', 0); // Ambil nilai parameter 'print'
    
        if ($print) {
            // Jika parameter 'print' bernilai 1, maka tampilkan view PDF
            $pdf = PDF::loadView('patient.registerDownload', compact('patient'));
            return $pdf->download('data_table.pdf');
        } else {
            // Jika parameter 'print' tidak ada atau bernilai 0, tampilkan view biasa
            return view('patient.registerDownload', compact('patient'));
        }



        // // Data to be passed to the view
        // $patient = Patient::all();
        // // Get the view content with data
        // // /$customPaper = array(0,0,567.00,283.80);
        // $pdfContent = view('patient.registerDownload', compact('patient'));

        // // Generate PDF using dompdf
        // $pdf = PDF::loadHTML($pdfContent);

        // // Optional: Set PDF options, such as paper size, orientation, etc.
        // $pdf->setPaper('A4', 'landscape');

        // // Return the PDF as a download
        // return $pdf->download('example.pdf');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:16',
            'fullName' => 'required|max:255',
            'address' => 'required|max:255',
            'birthDate' => 'required|date',
            'gender' => 'required',
            'phoneNumber' => 'required',
            'bpjsNumber' => 'max:13',
        ], [
            'fullName.required' => 'Nama lengkap wajib diisi',
            'fullName.max' => 'Nama lengkap maximal :max karakter',
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK maximal :max karakter',
            'birthDate.required' => 'Tanggal lahir wajib dipilih',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'phoneNumber.required' => 'Nomor HP wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maximal :max karakter',
            'bpjsNumber.max' => 'Nomor BPJS maksimal :max karakter',
        ]);

        $user = new User();
        $user->name = $request['fullName'];
        $user->email = $request['phoneNumber'].'@pasien.com';
        $user->password = Hash::make('12345678');
        $user->save();

        $user->assignRole('pasien');

        $patient = new Patient();
        $patient->nik = $request['nik'];
        $patient->name = $request['fullName'];
        $patient->address = $request['address'];
        $patient->phone = $request['phoneNumber'];
        $patient->birth_date = $request['birthDate'];
        $patient->gender = $request['gender'];
        $patient->bpjs_number = $request['bpjsNumber'];
        $patient->is_active = true;
        $patient->fk_user_id = $user->id;
        $patient->save();
        
        return redirect()->route('patient');
    }

    public function save(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:16',
            'fullName' => 'required|max:255',
            'address' => 'required|max:255',
            'birthDate' => 'required|date',
            'gender' => 'required',
            'phoneNumber' => 'required',
            'bpjsNumber' => 'max:13',
        ], [
            'fullName.required' => 'Nama lengkap wajib diisi',
            'fullName.max' => 'Nama lengkap maximal :max karakter',
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK maximal :max karakter',
            'birthDate.required' => 'Tanggal lahir wajib dipilih',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'phoneNumber.required' => 'Nomor HP wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maximal :max karakter',
            'bpjsNumber.max' => 'Nomor BPJS maksimal :max karakter',
        ]);

        $patient = Patient::findOrFail($request->patientId);
        $patient->nik = $request['nik'];
        $patient->name = $request['fullName'];
        $patient->address = $request['address'];
        $patient->phone = $request['phoneNumber'];
        $patient->birth_date = $request['birthDate'];
        $patient->gender = $request['gender'];
        $patient->bpjs_number = $request['bpjsNumber'];
        $patient->is_active = true;
        $patient->save();

        return redirect()->route('patient');
    }

    public function deleteData(Request $request)
    {
        $com = Patient::where('id',$request->id)->first();
        if($com != null)
        {
            $com->is_deleted = 1;
            $com->is_active = 0;
            $com->save();
        }
        return Response()->json($com);
    }
}
