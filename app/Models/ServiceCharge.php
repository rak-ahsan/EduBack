<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'country_id',
        'university_id',
        'campus_id',
        'intake_id',
        'program_id',
        'course_id',
        'service_amount',
        'service_charge_status',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function campus()
    {
        return $this->belongsTo(UniCampus::class, 'uni_campus_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function course()
    {
        return $this->belongsTo(UniCourse::class, 'uni_course_id');
    }
}
