<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplacementHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'component_id',
        'user_id',
        'replacement_date',
        'hm_km',
        'wo',
        'reservasi',
        'notes',
        'image',
        'status',
        'code_number',
        'category',
        'component_name',
        'pic',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'replacement_date' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}