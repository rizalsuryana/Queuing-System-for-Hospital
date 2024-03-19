<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();
        $pqd = DB::table('patient_queues as pq')
            ->join('patient_queue_details as pqd', 'pq.id', '=', 'pqd.fk_patient_queue_id')
            ->select('pq.poli_name',DB::raw('COUNT(1) AS queueCount'))
            ->whereDate('pq.queue_at', $now)
            ->groupBy('pq.poli_name')
            ->get();
        return view('home', [
            'datas' => $pqd
        ]);
    }

    public function patientDashboard()
    {
        $user = Auth::user();
        $isPatient = false;
        if(Auth::check()){
            if($user->hasRole('pasien')){
                $isPatient = true;
            }
        }
        $data = [];
        // dd($isPatient);
        if($isPatient)
        {
            $patient = Patient::where([
                'fk_user_id' => $user->id
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
        return view('dashboard', $data);
    }
}
