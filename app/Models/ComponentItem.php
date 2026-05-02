<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentItem extends Model
{
    protected $fillable = [
        'apl_component_id',
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
            'price' => 'decimal:2',
            'amount' => 'decimal:2',
            'qty' => 'integer',
        ];
    }

    public function aplComponent(): BelongsTo
    {
        return $this->belongsTo(AplComponent::class);
    }
}
