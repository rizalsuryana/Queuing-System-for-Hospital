<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Poli;
use App\Models\PoliSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class DoctorController extends Controller
{
    public function index()
    {
        return view('doctor.index');
    }
    public function showAdd() 
    { 
        $polis = Poli::where([
            'is_active' => 1,
            'is_deleted' => 0
        ])
        ->orderBy('name')
        ->get();
        return view('doctor.form', [
            'polis' => $polis,
            'formName' => 'Form Tambah Dokter',
            'formUrl' => route('doctor.store'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Tambah Dokter'
        ]);
    }

    public function showData()
    {
        if(request()->ajax()) {
            return datatables()->of(Doctor::select('*')->where([
                'is_active' => 1,
                'is_deleted' => 0,
            ]))
                ->addColumn('action', 'doctor.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            
        }
        return null;

    }

    public function getSchedule(string $id)
    {
        
        if(request()->ajax()) {
            $data = DB::table('doctor_schedules')
            ->join('poli_schedules', 'doctor_schedules.fk_poli_schedule_id', '=', 'poli_schedules.id')
            ->select('doctor_schedules.id','poli_schedules.day', 'doctor_schedules.start_time', 'doctor_schedules.end_time', 'doctor_schedules.quota')
            ->where([
                'doctor_schedules.is_active' => 1,
                'doctor_schedules.is_deleted' => 0,
                'doctor_schedules.fk_doctor_id' => $id
            ]);
            return datatables()->of($data)
                ->addColumn('action', 'doctor.scheduleAction')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            
        }
        return null;

    }

    public function getPoliSchedule(string $id)
    {
        if(request()->ajax()) {
            $doctor = Doctor::where([
                'id' => $id
            ])->first();

            if(!isset($doctor))
            {
                return null;
            }

            $fkPoliId = DoctorSchedule::where([
                'is_active' => 1,
                'is_deleted' => 0,
                'fk_doctor_id' => $id
            ])
            ->pluck('fk_poli_schedule_id')
            ->toArray();
        
            $poliSchedules = PoliSchedule::where([
                'fk_poli_id' => $doctor->fk_poli_id,
                'is_active' => 1,
                'is_deleted' => 0,
            ])->get();

            if(!empty($fkPoliId))
            {
                $poliSchedules = PoliSchedule::where([
                    'fk_poli_id' => $doctor->fk_poli_id,
                    'is_active' => 1,
                    'is_deleted' => 0
                ])
                ->whereNotIn('id', $fkPoliId)
                ->get();
            }
            return $poliSchedules;
            
        }
        return null;

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 
            'birthDate' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'nik' => 'required',
            'poliId' => 'required',
            'phone' => 'required',
        ]);

        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->nik = $request->nik;
        $doctor->address = $request->address;
        $doctor->phone = $request->phone;
        $doctor->birth_date = $request->birthDate;
        $doctor->address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->is_active = 1;
        $doctor->is_deleted = 0;
        $doctor->fk_poli_id = $request->poliId;
        $doctor->is_active = true;
        $doctor->save();   
        return response()->json(['success' => 'Dokter berhasil ditambahkan.']); 
    }

    public function showDetail(string $id)
    {
        $polis = Poli::where([
            'is_active' => 1,
            'is_deleted' => 0
        ])
        ->orderBy('name')
        ->get();

        $doctor = Doctor::where([
            'id' => $id
        ])
        ->first();

        return view('doctor.form', [
            'polis' => $polis,
            'doctor' => $doctor,
            'formName' => 'Form Edit Dokter',
            'formUrl' => route('doctor.save'),
            'formMethod' => 'post',
            'breadcrumbName' => 'Edit Dokter'
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required', 
            'birthDate' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'nik' => 'required',
            'poliId' => 'required',
            'phone' => 'required',
        ]);

        $doctor = Doctor::findOrFail($request->doctorId);
        $doctor->name = $request->name;
        $doctor->nik = $request->nik;
        $doctor->address = $request->address;
        $doctor->phone = $request->phone;
        $doctor->birth_date = $request->birthDate;
        $doctor->address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->fk_poli_id = $request->poliId;
        $doctor->save();   

        return response()->json(['success' => 'Dokter berhasil diupdate.']); 
    }

    public function delete(Request $request)
    {
        $doctor = Doctor::where(['id'=>$request->id])->first();
        $doctor->is_active = false;
        $doctor->is_deleted = true;
        $doctor->save();
        return Response()->json($doctor);
    }

    public function addSchedule(Request $request)
    {
        $input = $request->all();
        $input['poliScheduleId'] = $request->input('poliScheduleId');

        $poliSchedules = PoliSchedule::where([
            'is_active' => 1,
            'is_deleted' => 0
        ])
        ->whereIn('id', $input['poliScheduleId'])
        ->get();

        if(!empty($poliSchedules))
        {
            foreach ($poliSchedules as $key => $value) {
                $doctorSchedule = new DoctorSchedule();
                $doctorSchedule->fk_doctor_id = $request->doctorId;
                $doctorSchedule->fk_poli_schedule_id = $value->id;
                $doctorSchedule->quota = $request->scheduleQuota;
                $doctorSchedule->start_time = $value->start_time;
                $doctorSchedule->end_time = $value->end_time;
                $doctorSchedule->is_active = true;
                $doctorSchedule->is_deleted = false;
                $doctorSchedule->save();
            }
        }
        
        return response()->json(['success' => 'Jadwal berhasil ditambahkan.']);  

    }

    public function deleteSchedule(Request $request)
    {
        $com = DoctorSchedule::where('id',$request->id)->delete();
        return Response()->json($com);
    }

}
