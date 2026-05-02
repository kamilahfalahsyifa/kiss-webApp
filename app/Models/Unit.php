<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'qr_code',
        'location',
        'status',
    ];

    public function replacementHistories()
    {
        return $this->hasMany(ReplacementHistory::class);
    }
}