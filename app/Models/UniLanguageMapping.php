<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class UniLanguageMapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'university_id',
        'uni_courses_id',
        'language_id',
        'overall_score',
        'reading',
        'writing',
        'speaking',
        'listening',
        'status',
    ];

    //get language
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
