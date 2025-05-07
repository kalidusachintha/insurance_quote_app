<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Destination|null $destination
 */
class Quote extends Model
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'start_date',
        'end_date',
        'number_of_travelers',
        'total_price',
        'client_ip',
        'user_agent',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'number_of_travelers' => 'integer',
        'total_price' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            $quote->client_ip = request()->ip();
            $quote->user_agent = request()->userAgent();
        });
    }

    /**
     * Get destinations
     *
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get coverage options
     *
     * @return BelongsToMany
     */
    public function coverageOptions(): BelongsToMany
    {
        return $this->belongsToMany(CoverageOption::class)
            ->withTimestamps();
    }
}
