<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityReplacement extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'part_number',
        'stock_code',
        'description',
        'qty',
        'stock',
        'price',
        'amount',
        'wr',
        'remarks_install',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'price' => 'decimal:2',
            'amount' => 'decimal:2',
            'qty' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
