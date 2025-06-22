<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'university_id',
        'program_id',
        'course_name',
        'course_fees',
        'course_duration',
        'course_academic_req',
        'course_link',
        'status',
    ];

    /**
     * Get the university that owns the UniCourse.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }
    /**
     * Get the program that owns the UniCourse.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    /**
     * Get the language mappings for the UniCourse.
     */
    public function languageMappings(): HasMany
    {
        return $this->hasMany(UniLanguageMapping::class, 'uni_courses_id');

    }
    /**
     * Get the campus mappings for the UniCourse.
     */
    public function campusMappings(): HasMany
    {
        return $this->hasMany(UniCampusMapping::class, 'uni_course_id');
    }

    /**
     * Get the intake mappings for the UniCourse.
     */
    public function intakeMappings(): HasMany
    {
        return $this->hasMany(UniIntakeMapping::class, 'uni_courses_id');
    }
}
