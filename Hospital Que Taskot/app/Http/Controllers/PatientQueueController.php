<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\view\Vw_Patient_Queue;
use App\Models\PatientQueue;
use App\Models\PatientQueueDetail;
use App\Models\Poli;
use App\Models\PoliSchedule;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;
use PDF;

class PatientQueueController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $user = User::where('id',$id)->first();
        $data = [
            'user' => $user,
            // Add more data if needed
        ];
        return view('patientQueue.index',$data);
    }

    public function checkQueue(Request $request)
    {
        // dd(Auth::id());
        $request->validate([
            'nik' => 'required|max:17',
        ], [
            'nik.required' => 'NIK wajib diisi',
        ]);

        return view('patientQueue.registrationChecking', [
            'nik' => $request->nik
        ]);
    }

    public function getPatientQueue(string $nik)
    {        
        if(request()->ajax()) {
            $data = Patient::select('patients.name', 'patients.nik', 'patient_queue_details.queue_number', 'patient_queues.poli_name'
            , 'patient_queues.queue_at'
            , 'patient_queue_details.patient_bpjs_number'
            , 'patient_queue_details.guarantor')
            ->join('patient_queue_details', 'patients.id', '=', 'patient_queue_details.fk_patient_id')
            ->join('patient_queues', 'patient_queue_details.fk_patient_queue_id', '=', 'patient_queues.id')
            ->where([
                'patients.nik' => $nik,
                'patient_queue_details.is_active' => 1
            ]);
            
            return datatables()->of($data)
                ->addColumn('action', 'patientQueue.registerCheckingAction')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            
        }
        return null;

    }

    public function checkAllQueue()
    {
        $now = Carbon::now();
        $datas = [];
        $queues = PatientQueue::whereDate('queue_at', $now)->get();
        foreach ($queues as $key => $q) {
            
            $qDetails = PatientQueueDetail::where([
                'fk_patient_queue_id' => $q->id
            ])->get();

            $maxInRoom = $qDetails->where('status','inroom')->max('queue_number');
            $minCompleted = $qDetails->where('status','completed')->min('queue_number');
            $maxPending = $qDetails->where('status','pending')->max('queue_number');
            $data = [
                'poliName' => $q->poli_name,
                'inRoom' => $maxInRoom,
                'completed' => $minCompleted,
                'pending' => $maxPending,
            ];
            array_push($datas, $data);            
        }
        return view('patientQueue.allQueue', [
            'chunckData' => $datas
        ]);
    }

    public function showData(Request $request)
    {
        $adminId = Auth::id();
        $selectedAdmin = User::where('id', $adminId)->first();
        $poliId = $selectedAdmin->fk_poli_id;

        if((Auth::user()->name == "Admin")){
            if (request()->ajax()) {
                $query = PatientQueue::select('*')->where([
                    'is_active' => 1,
                    'is_deleted' => 0,
                ]);
                if(isset($request->startDate) && isset($request->endDate)){
                    $query = $query->whereBetween('queue_at', [$request->startDate, $request->endDate]);
                }
                return datatables()->of($query)
                    ->addColumn('action', 'patientQueue.action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return null;
        }
        if (request()->ajax()) {
            $query = PatientQueue::select('*')->where([
                'is_active' => 1,
                'is_deleted' => 0,
                'fk_poli_id' =>$poliId
            ]);
            if(isset($request->startDate) && isset($request->endDate)){
                $query = $query->whereBetween('queue_at', [$request->startDate, $request->endDate]);
            }
            return datatables()->of($query)
                ->addColumn('action', 'patientQueue.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return null;
    }

    public function showDetail(string $id)
    {
        $patientQueue = PatientQueue::findOrFail($id);
        $patientDetails = PatientQueueDetail::where('fk_patient_queue_id', $id)->get();
        $sisaPatient = $patientDetails->where('is_active', 1)->count();
        $idQueue = $patientDetails->where('status','pending');
        $pendingPatients = $patientDetails->where('status','pending')->sortby('queue_number');
        $calledPatients = $patientDetails->where('status','called')->sortby('queue_number');
        $inroomPatients = $patientDetails->where('status','inroom')->sortby('queue_number');
        $completedPatients = $patientDetails->where('status','completed');
        $cancelledPatients = $patientDetails->where('status','cancelled');
        $cancelledPatientsCount = $patientDetails->where('status','cancelled')->count();
        $id = Auth::id();
        $user = User::where('id',$id)->first();
        return view('patientQueue.form', [
            'patientQueue' => $patientQueue,
            'patientDetailCount'=>$patientDetails->count(),
            'pendingPatients' => $pendingPatients,
            'calledPatients' => $calledPatients,
            'inroomPatients' => $inroomPatients,
            'completedPatients' => $completedPatients,
            'cancelledPatients' => $cancelledPatients,
            'sisaPatient' => $sisaPatient,
            'id' =>$id,
            'user' =>$user,
        ]);
    }

    public function changeQuota(Request $request){
        $patientQueue = PatientQueue::findOrFail($request->patientQueueId);
        $isSuccess = false;
        $customError = [
            'customError' => []
        ];
        $responseStatusCode = 422;
        if(!empty($patientQueue)){
            if($request->quota < $patientQueue->quota){
                array_push($customError['customError'], 'Kuota harus lebih besar dari'.$patientQueue->quota);
            }
            else {
                $patientQueue->quota = $request->quota;
                $patientQueue->save();
                $isSuccess = true;
                $responseStatusCode = 200;
                $customError = [];
            }
        }
        
        $results = [
            'message' => $isSuccess ? 'success' : 'failed',
            'isSuccess' => $isSuccess,
            'errors' => $customError
        ];

        return response()->json($results, $responseStatusCode);
    }

    public function changeStatus(Request $request){
        $patientQueueDetail = PatientQueueDetail::findOrFail($request->id);
        $isSuccess = false;
        $customError = [
            'customError' => []
        ];
        $responseStatusCode = 422;
        $statuses = ['called', 'inroom','completed'];
        if(empty($patientQueueDetail)){
            array_push($customError['customError'], 'data tidak ditemukan');
        }
        else if(!in_array($request->status, $statuses)){
            array_push($customError['customError'], 'Status tidak valid');            
        }
        else {
            $now = Carbon::now('Asia/Bangkok');
            $status = $request->status;
            switch ($status) {
                case 'called':
                    $patientQueueDetail->called_at = $now;
                    break;
                case 'inroom':
                    $patientQueueDetail->in_room_at = $now;
                    break;
                case 'completed':
                    $patientQueueDetail->out_room_at = $now;
                    break;
                
                default:
                    $status = 'pending';
                    break;
            }
            $patientQueueDetail->status = $status;
            $patientQueueDetail->save();
            $isSuccess = true;
            $responseStatusCode = 200;
            $customError = [];
        }
        
        $results = [
            'message' => $isSuccess ? 'success' : 'failed',
            'isSuccess' => $isSuccess,
            'errors' => $customError
        ];

        return response()->json($results, $responseStatusCode);
    }

    public function downloadRegisterNumber(Request $request){
        
        $poliName = $request->input('poliName');
        $queueNumber = $request->input('queueNumber');
        $patientName = $request->input('patientName');
        $queueAt = $request->input('queueAt');
        $guarantor = $request->input('guarantor');

        // Data to be passed to the view
        $data = [
            'poliName' => $poliName,
            'queueNumber' => $queueNumber,
            'patientName' => $patientName,
            'queueAt' => $queueAt,
            'guarantor' => $guarantor,
        ];

        // Get the view content with data
        // /$customPaper = array(0,0,567.00,283.80);
        $pdfContent = view('patientQueue.registerDownload', $data)->render();

        // Generate PDF using dompdf
        $pdf = PDF::loadHTML($pdfContent);

        // Optional: Set PDF options, such as paper size, orientation, etc.
        $pdf->setPaper('A7', 'portrait');

        // Return the PDF as a download
        return $pdf->download('example.pdf');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'poliId' => 'required',
            'patientId' => 'required',
            'fullName' => 'required|max:255',
            'nik' => 'required|max:17',
            'birthDate' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'bpjsNumber' => 'max:13',
        ], [
            'poliId.required' => 'Poli wajib dipilih',
            'fullName.required' => 'Nama lengkap wajib diisi',
            'fullName.max' => 'Nama lengkap maximal :max karakter',
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK maximal :max karakter',
            'birthDate.required' => 'Tanggal lahir wajib dipilih',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maximal :max karakter',
            'bpjsNumber.max' => 'Nomor BPJS maksimal 13 karakter',
            'visitDate.required' => 'Tanggal kunjungan wajib dipilih',
        ]);

        $isSuccess = false;
        $responseStatusCode = 200;
        $customErros = [
            'customError' => []
        ];

        Carbon::setLocale('id');
        $carbonDate = Carbon::createFromFormat('Y-m-d', $request->visitDate);
        $dayOfWeek = $carbonDate->isoFormat('dddd');
        $formattedDate = $carbonDate->isoFormat('D MMMM YYYY');
        $data = new stdClass();
        $data->patientName = '';
        $data->queueNumber = '';
        $data->queueAt = '';
        $data->poliName = '';
        try {
            DB::beginTransaction();

            
            $patient = Patient::find($request->patientId);
            if (empty($patient)) {
                throw new Exception('Data anda tidak ditemukan');
            }

            $patient->name = $request->fullName;
            $patient->nik = $request->nik;
            $patient->phone = $request->phoneNumber;
            $patient->birth_date = $request->birthDate;
            $patient->address = $request->address;
            $patient->gender = $request->gender;
            $patient->bpjs_number = $request->bpjsNumber;
            $patient->save();

            $poli = Poli::find($request->poliId);
            if (empty($poli)) {
                throw new Exception('Poli tidak ditemukan. Cek poli yang anda pilih');
            }
            
            $currentDateTime = now();
            $poliEndTime = PoliSchedule::where('fk_poli_id',$poli->id)->first();
            $batas = $poliEndTime->end_time;
            $currentDate = $currentDateTime->toDateString();
            $currentTime = $currentDateTime->toTimeString();
            if($currentDate == $request->visitDate){
                if($currentTime > $batas){
                    throw new Exception("Jam sudah kelewat batas");
                }
            }

            $poliSchedule = PoliSchedule::where([
                'fk_poli_id' => $poli->id,
                'is_active' => 1,
                'is_deleted' => 0,
                'day' => $dayOfWeek
            ])
                ->orderBy('start_time')
                ->first();

            if (empty($poliSchedule)) {
                throw new Exception($poli->name . ' tidak ada jadwal di tanggal terpilih');
            }

            $queue = PatientQueue::where('fk_poli_id', $poli->id)
                ->whereDate('queue_at', $request->visitDate)->first();
            if (empty($queue)) {
                $queue = new PatientQueue();
                $queue->queue_at = $request->visitDate;
                $queue->fk_poli_id = $poli->id;
                $queue->poli_name = $poli->name;
                $queue->quota = $poli->quota;
                $queue->start_time = $poliSchedule->start_time;
                $queue->end_time = $poliSchedule->end_time;
                $queue->status = 'active';
                $queue->note = $poli->note;
            } 
            // else {
            //     $queue->quota = $queue->quota - 1;
            // }
            $queue->save();

            $queueDetails = PatientQueueDetail::where([
                'fk_patient_queue_id' => $queue->id
            ])->get();

            $qNumber = 1;
            if (!empty($queueDetails)) {
                $qNumber = $queueDetails->max('queue_number') + 1;
            }

            if ($queueDetails->where('fk_patient_id', $patient->id)->where('is_active',1)->count() > 0) {
                throw new Exception('Anda sudah mendaftar di poli ini di tanggal terpilih');
            }
            if (($queue->quota - ($queueDetails->where('is_active',1)->count() + 1)) < 0) {
                throw new Exception($poli->name . ' sudah penuh');
            }

            $qDetail = new PatientQueueDetail();
            $qDetail->queue_number = $qNumber;
            $qDetail->fk_patient_id = $patient->id;
            $qDetail->fk_patient_queue_id = $queue->id;
            $qDetail->patient_name = $patient->name;
            $qDetail->patient_bpjs_number = $patient->bpjs_number;
            $qDetail->guarantor = $request->guarantor;
            $qDetail->status = 'pending';
            $qDetail->save();

            DB::commit();
            $isSuccess = true;
            $data->patientName = $patient->name;
            $data->queueNumber = $qNumber;
            $data->queueAt = $formattedDate;
            $data->poliName = $poli->name;
            $data->guarantor = $qDetail->guarantor;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            array_push($customErros['customError'], $th->getMessage());
        }

        if (!$isSuccess) {
            $responseStatusCode = 422;
        } else {
            $customErros = [];
        }
        $results = [
            'message' => $isSuccess ? 'success' : 'failed',
            'isSuccess' => $isSuccess,
            'queueData' => $data,
            'errors' => $customErros
        ];
        return response()->json($results, $responseStatusCode);
    }

    public function cancel(Request $id) {
        $a = PatientQueueDetail::where([
            'fk_patient_queue_id' => $id->id,
            'status'=>'called'
        ])->update([
            'status' => 'cancelled'
        ]);
        return redirect()->back();
        
    }
    public function cancelOne(Request $id) {
        //dd($id->id);
        $a =PatientQueueDetail::where([
            'id' => $id->id,
            'status'=>'called',
            'is_active' => '1',
            'is_deleted' => '0'
        ]);
        $a->update([
            'status' => 'cancelled',
            'is_active' => '0',
            'is_deleted' => '1'
        ]);
        return redirect()->back();
        
    }
    public function getQuota($date, $poli){
        $Poli = PatientQueue::where('fk_poli_id',$poli)->first();
        $quota = $Poli->quota;
        $idPoli= $Poli->id;
        $sisaPoli = PatientQueueDetail::where('fk_patient_queue_id',$idPoli)->whereDate('called_at','=',$date)->count();
        $data = "$quota / $sisaPoli";
        return response()->json($data);
    }
}
