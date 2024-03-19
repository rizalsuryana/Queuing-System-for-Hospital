<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuid;


class PoliSchedule extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $cast = [
        'id' => 'string'
    ];

    public $incrementing = false;
    protected $fillable = [
        'fk_poli_id',
        'start_time',
        'end_time',
        'is_active',
        'is_deleted',
    ];
    
    public function Poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
