<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentAcademic extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'program_id',
        'group',
        'course',
        'cgpa',
        'scale',
        'duration',
        'passing_year',
        'institute',
        'course_start_date',
        'course_end_date',
        'certificate_image',
        'transcript_image',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class,'program_id');
    }
}
