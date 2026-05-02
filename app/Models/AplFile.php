<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AplFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sheets(): HasMany
    {
        return $this->hasMany(AplSheet::class);
    }
}
