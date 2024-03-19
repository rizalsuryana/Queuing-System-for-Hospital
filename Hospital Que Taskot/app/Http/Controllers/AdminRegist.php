<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\view\Vw_Patient_Queue;
use App\Models\PatientQueue;
use App\Models\PatientQueueDetail;
use App\Models\PoliSchedule;
use App\Models\User;
use Exception;
use stdClass;
use PDF;

use function Laravel\Prompts\alert;

class AdminRegist extends Controller
{
    //untuk controller admin registrasi
    public function index(){
        $adminRegister = Auth::user();
        $isadminRegister = false;
        if(Auth::check()){
            if($adminRegister->hasRole('adminRegister')){
                $isadminRegister = true;
            }
        }
        $data = [];
        //dd($isadminRegister)

        if($isadminRegister)
        {
            $patient = User::where([
                'id' => $adminRegister->id
            ])
            ->first();
            $polis = Poli::where([
                'is_active' => '1',
                'is_deleted' => '0',
            ])->get();
            $data = [
                'patient' => $patient,
                'polis' => $polis,
                'redirectUrl' => '#'
            ];
        }
        else 
        {
            $data = [
                'redirectUrl' => route('login')
            ];
        }
        // dd($data);
        return view('adminRegisterDashboard', $data);
    }
    public function checkQueue(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:17',
        ], [
            'nik.required' => 'NIK wajib diisi',
        ]);

        return view('AdminRegisterDashboard.patientQueue.registrationChecking', [
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
                'patients.nik' => $nik
            ]);
            
            return datatables()->of($data)
                ->addColumn('action', 'AdminRegisterDashboard.patient.action')
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
            $maxCompleted = $qDetails->where('status','completed')->max('queue_number');
            $minPending = $qDetails->where('status','pending')->min('queue_number');
            // testing
            $maxCalled = $qDetails->where('status','called')->max('queue_number');
                    // Mengambil semua nomor antrian yang sudah dipanggil untuk poli ini
        // $calledNumbers = $qDetails->where('status','called')->pluck('queue_number')->toArray();
            $data = [
                'poliName' => $q->poli_name,
                'inRoom' => $maxInRoom,
                'completed' => $maxCompleted,
                'pending' => $minPending,
                

                // testing
                'called' => $maxCalled,
                // 'called' => $calledNumbers,
                // testing

            ];
            array_push($datas, $data);            
        }
        return view('AdminRegisterDashboard.patientQueue.allQueue', [
            'chunckData' => $datas
        ]);
    }

    public function antrianShowData(Request $request)
    {

        if(request()->ajax()) {
            $join = PatientQueueDetail::join('patients', 'patient_queue_details.fk_patient_id', '=', 'patients.id')
            ->join('patient_queues', 'patient_queue_details.fk_patient_queue_id', '=', 'patient_queues.id')
            ->select('patients.*', 'patient_queues.*','patient_queue_details.*')
            ->where([
                'patient_queue_details.is_active' => 1,
                'patient_queue_details.is_deleted' => 0
            ]);
            if(isset($request->startDate) && isset($request->endDate)){
                $join = $join->whereBetween('queue_at',[$request->startDate, $request->endDate]);
            }
            return datatables()->of($join)
                ->addColumn('action', 'adminRegisterDashboard.patient.action')
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
        $pendingPatients = $patientDetails->where('status','pending');
        $calledPatients = $patientDetails->where('status','called');
        $inroomPatients = $patientDetails->where('status','inroom');
        $completedPatients = $patientDetails->where('status','completed');
        return view('AdminRegisterDashboard.patientQueue.form', [
            'patientQueue' => $patientQueue,
            'patientDetailCount'=>$patientDetails->count(),
            'pendingPatients' => $pendingPatients,
            'calledPatients' => $calledPatients,
            'inroomPatients' => $inroomPatients,
            'completedPatients' => $completedPatients,
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
        $pdfContent = view('AdminRegisterDashboard.xpatientQueue.registerDownload', $data)->render();

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
            'fullName' => 'required|max:255',
            'nik' => 'required|max:17',
            'birthDate' => 'required|date',
            'gender' => 'required',
            'address' => 'required|max:255',
            'bpjsNumber' => 'max:13',
            'visitDate' => 'required|date|after_or_equal:today'

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
            'visitDate.after_or_equal' => 'Pendaftaran maksimal hari H kunjungan',
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
            
            $currentDateTime = now();
            $currentDate = $currentDateTime->toDateString();
            $currentTime = $currentDateTime->toTimeString();

            if($currentDate != $request->visitDate){
                throw new Exception('Hanya bisa melakukan pendaftaran untuk hari ini');
            }


            $patient = new Patient();
            $patient->fk_user_id = $request->patientId;
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
            $poliEndTime = PoliSchedule::where('fk_poli_id',$poli->id);
            $currentDate = $currentDateTime->toDateString();
            $currentTime = $currentDateTime->toTimeString();
            // if($currentDate == $request->visitDate){
            //     if($currentTime < $poliEndTime){
            //         throw new Exception("Jam sudah kelewat batas");
            //     }
            // }
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

            if ($queueDetails->where('fk_patient_id', $patient->id)->where('is_active', 1)->count() > 0) {
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

    public function cekIndex() {
        return view('AdminRegisterDashboard.cek');
    }
    
    public function daftarAntrian(){
        return view('AdminRegisterDashboard.daftarAntrian');
    }
    public function deleteAntrian(Request $request)
    {
        $patientQueue = PatientQueueDetail::where('id',$request->id)->first();
            if($patientQueue != null)
            {
                $patientQueue->is_deleted = 1;
                $patientQueue->is_active = 0;
                $patientQueue->save();
            }
            return Response()->json($patientQueue);
    }

    public function editAntrian(string $id)
    {
        $antrian = PatientQueueDetail::where(['id'=>$id])->first();
        // $patient = $antrian->patient_name;
        $patient = Patient::where('id',$antrian->fk_patient_id)->first();
        $polis = Poli::where([
            'is_active' => '1',
            'is_deleted' => '0',
        ])->get();
        return view('adminRegisterDashboard.patient.form', [
            'id' =>$id,
            'antrian' => $antrian,
            'patient' => $patient,
            'polis' => $polis,
            'formName' => 'Form Edit Pasien',
            'formUrl' => route('antrian.savee'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Edit Pasien'
        ]);
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
        // $antrian = PatientQueueDetail::where('fk_patient_id',$request->patientId)->get();
        // $antrian->name = $request['fullName'];
        $patient->nik = $request['nik'];
        $patient->name = $request['fullName'];
        $patient->address = $request['address'];
        $patient->phone = $request['phoneNumber'];
        $patient->birth_date = $request['birthDate'];
        $patient->gender = $request['gender'];
        $patient->bpjs_number = $request['bpjsNumber'];
        $patient->is_active = true;
        $patient->save();

        $antrian = PatientQueueDetail::where('fk_patient_id',$request->patientId)->first();
        $antrian->patient_name = $request['fullName'];  
        $antrian->save();

        return redirect('/daftarOffline');
    }
}
