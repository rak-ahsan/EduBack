<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentExperience extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'company',
        'designation',
        'location',
        'job_start_date',
        'job_end_date',
        'image',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
