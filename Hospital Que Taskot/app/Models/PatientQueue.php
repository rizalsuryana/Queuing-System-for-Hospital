<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;

class PatientQueue extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];
    protected $fillable = [
    'poli_name'
    ];
    public $incrementing = false;

    public function PatientQueueDetails()
    {
        return $this->hasMany(PatientQueueDetail::class);
    }

    public function Poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
