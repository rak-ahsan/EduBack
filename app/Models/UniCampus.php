<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniCampus extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'university_id',
        'campus_name',
        'state_id',
        'status',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
