<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'weekly_fee',
        'billing_period_days',
        'billing_at_time',
        'billing_cycle_anchor',
        'accumulated_expected_fees',
        'current_period',
    ];

    protected $casts = [
        'billing_cycle_anchor' => 'datetime',
        'weekly_fee' => 'decimal:2',
        'accumulated_expected_fees' => 'decimal:2',
        'billing_period_days' => 'float',
        'current_period' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
