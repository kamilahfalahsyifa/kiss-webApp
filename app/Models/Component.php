<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_name',
        'part_number',
        'category',
        'stock',
        'price',
        'vendor',
    ];

    public function replacementHistories()
    {
        return $this->hasMany(ReplacementHistory::class);
    }

    public function aplComponents()
    {
        return $this->hasMany(AplComponent::class);
    }
}