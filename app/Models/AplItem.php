<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AplItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'apl_sheet_id',
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

    protected $casts = [
        'price' => 'decimal:2',
        'amount' => 'decimal:2',
        'qty' => 'integer',
    ];

    public function aplSheet(): BelongsTo
    {
        return $this->belongsTo(AplSheet::class);
    }
}
