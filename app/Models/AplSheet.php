<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AplSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'apl_file_id',
        'name',
    ];

    public function aplFile(): BelongsTo
    {
        return $this->belongsTo(AplFile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(AplItem::class);
    }
}
