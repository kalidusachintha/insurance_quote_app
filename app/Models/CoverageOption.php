<?php

namespace App\Models;

use Database\Factories\CoverageOptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoverageOption extends Model
{
    /** @use HasFactory<CoverageOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get quotes
     * @return BelongsToMany
     */
    public function quotes(): BelongsToMany
    {
        return $this->belongsToMany(Quote::class)->withTimestamps();
    }
}
