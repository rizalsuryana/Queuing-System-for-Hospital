<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class Doctor extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $fillable = [
        'name',
        'nik',
        'address',        
        'phone',
        'birth_date',
        'address',
        'gender',
        'is_active',
        'is_deleted',
        'fk_poli_id',
    ];

    public function Poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function DoctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function PatientQueues()
    {
        return $this->hasMany(PatientQueue::class);
    }
}
