<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;


class Poli extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $fillable = [
        'name',
        'quota',
        'is_active',
        'fk_admin_id'
    ];

    public function Doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function PoliSchedules()
    {
        return $this->hasMany(PoliSchedule::class);
    }

    public function PatientQueues()
    {
        return $this->hasMany(PatientQueue::class);
    }
}
