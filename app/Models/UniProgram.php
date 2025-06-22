<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniProgram extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'university_id',
        'program_id',
        'status',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
