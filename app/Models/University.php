<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;
    protected $appends = ['college_logo'];

    protected $fillable = [
        'id',
        'country_id',
        'uni_name',
        'application_fees',
        'ranking',
        'initial_deposit',
        'usp',
        'uni_academic_req',
        'uni_link',
        'scholarship',
        'image',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function campuses(): HasMany
    {
        return $this->hasMany(UniCampus::class);
    }
    public function languages(): HasMany
    {
        return $this->hasMany(UniLanguage::class);
    }
    public function intakes(): HasMany
    {
        return $this->hasMany(UniIntake::class)->orderBy('id', 'desc');
    }
       public function intakes_id(): HasMany
    {
        return $this->hasMany(UniIntake::class)->orderBy('id', 'desc');
    }
    public function programs(): HasMany
    {
        return $this->hasMany(UniProgram::class);
    }

    public function uniCourses(): HasMany
    {
        return $this->hasMany(UniCourse::class);
    }
    public function getCollegeLogoAttribute()
    {
        $image = $this->image;
        if ($image) {
            return env('APP_URL') . '/' . $image;
        } else {
            return '';
        }
    }

    public function UniversityAgents(): HasMany
    {
        return $this->hasMany(UniversityAgentAssignment::class, 'university_id');
    }
}
