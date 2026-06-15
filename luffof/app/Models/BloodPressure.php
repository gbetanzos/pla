<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodPressure extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "systolic",
        "diastolic",
        "notes",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "systolic" => "integer",
        "diastolic" => "integer",
    ];

    /**
     * Get the user that owns the blood pressure reading.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
