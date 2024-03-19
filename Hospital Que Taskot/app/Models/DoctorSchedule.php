<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;


class DoctorSchedule extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $fillable = [
        'fk_doctor_id',
        'fk_poli_schedule_id',
        'quota',
        'start_time',
        'end_time',
        'is_active',
        'is_deleted',
    ];
    
    public function Doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
