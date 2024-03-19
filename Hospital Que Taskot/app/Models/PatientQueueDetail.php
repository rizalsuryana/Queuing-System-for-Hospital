<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class PatientQueueDetail extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];

    public $incrementing = false;
    
    protected $fillable = [
        'queue_at',
        'patient_name',     
        'patient_nik',
        'birth_date',
        'doctor_name',
        'poli_name',
        'queue_number',
        'patient_bpjs_number',
        'is_active',
        'is_deleted',
    ];
    
    public function Patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
