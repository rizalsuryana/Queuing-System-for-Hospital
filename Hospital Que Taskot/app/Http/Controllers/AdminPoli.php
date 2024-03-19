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

class AdminPoli extends Controller
{
    //untuk controller admin registrasi
    public function index(){

        // dd($join);
        $id = Auth::id();
        $user = User::where('id',$id)->first();
        $data = [
            'user' => $user,
            // Add more data if needed
        ];
        return redirect()->route('patientQueue',$data);
    }
    public function exportPDF(Request $id)
    {
        // dd($id->id);
        $patientQueue = PatientQueue::where(['id'=>$id->id])->first();
        $patientDetails = PatientQueueDetail::where(['fk_patient_queue_id'=>$id->id])->get();
        $pendingPatients = $patientDetails->where('status', 'pending');
        $calledPatients = $patientDetails->where('status', 'called');
        $inroomPatients = $patientDetails->where('status', 'inroom');
        $completedPatients = $patientDetails->where('status', 'completed');
        $cancelledPatients = $patientDetails->where('status', 'cancelled');
        $pdf = PDF::loadView('patientQueue.export', [
            'patientQueue'=>$patientQueue,
            'patientDetailCount' => $patientDetails->count(),
            'pendingPatients' => $pendingPatients,
            'calledPatients' => $calledPatients,
            'inroomPatients' => $inroomPatients,
            'completedPatients' => $completedPatients,
            'cancelledPatients' => $cancelledPatients,
            'id' => $id,
        ])->setOptions(['defaultFont' => 'sans-serif']);
        
    return $pdf->download('exported_data.pdf');
    }
    public function exportHariIniPDF(Request $request)
    {
        if($request->start != null && $request->end != null){

            $startDate = $request->start;
            $endDate = $request->end;
            $datesInRange = PatientQueue::whereBetween('queue_at', [$startDate, $endDate])->get();
            // dd($datesInRange);
            $count = $datesInRange->count();
            // dd($datesInRange);
            $dataArray = [];
            foreach ($datesInRange as $patientQueue) {
                $id = $patientQueue->id;
                $patientDetails = PatientQueueDetail::where(['fk_patient_queue_id' => $id])->get();
            
                foreach ($patientDetails as $pp) {
                    $dataArray[$id][] = [
                        'name' => $pp->patient_name,
                        'poli_name' => $patientQueue->poli_name,
                        'waktu' => $pp->out_room_at != null ? $pp->out_room_at : 'Belum selesai'
                    ];
                }
            }
            // // dd($dataArray);
                
            //     return view('patientQueue.exportHariIni', ['dataArray' => $dataArray]);
                $pdf = PDF::loadView('patientQueue.exportHariIni', [
                    'dataArray' => $dataArray
                ])->setOptions(['defaultFont' => 'sans-serif']);
                
            return $pdf->download('exported_data.pdf');
        } else {
            return redirect()->back();
        }
        

        // $pdf = PDF::loadView('patientQueue.export', [
        //     'patientQueue'=>$patientQueue,
        //     'patientDetailCount' => $patientDetails->count(),
        //     'pendingPatients' => $pendingPatients,
        //     'calledPatients' => $calledPatients,
        //     'inroomPatients' => $inroomPatients,
        //     'completedPatients' => $completedPatients,
        //     'cancelledPatients' => $cancelledPatients,
        //     'id' => $id,
        // ])->setOptions(['defaultFont' => 'sans-serif']);
        
    // return $pdf->download('exported_data.pdf');
    }
    }