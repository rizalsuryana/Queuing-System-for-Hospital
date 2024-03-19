<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class Patient extends Model
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
        'phone',
        'birth_date',
        'address',
        'gender',
        'bpjs_number',
        'is_active',
        'is_deleted',
        'fk_user_id',
    ];

    public function PatientQueues()
    {
        return $this->hasMany(PatientQueue::class);
    }
}
