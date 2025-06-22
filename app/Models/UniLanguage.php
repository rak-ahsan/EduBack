<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniLanguage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'university_id',
        'language_id',
        'overall_score',
        'reading',
        'writing',
        'speaking',
        'listening',
        'status',
    ];

    /**
     * Get the university that owns the UniLanguage.
     */

    /**
     * Get the language that owns the UniLanguage.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
