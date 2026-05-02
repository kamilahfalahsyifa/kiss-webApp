<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AplComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_id',
        'quantity',
        'total_price',
        'description',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}