<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentLanguage extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'language_id',
        'overall_result',
        'reading',
        'writing',
        'speaking',
        'listening',
        'examination_date',
        'expiry_date',
        'image',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
