<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'admission_id',
        'compliance_id',
        'country_id',
        'state_id',
        'university_id',
        'uni_campus_id',
        'uni_program_id',
        'uni_course_id',
        'uni_intake_id',
        'lead_status_id',
        'application_fees_status',
        'application_fees_amount',
        'applied_via',
        'submitted_portal_date',
        'submitted_university_date',
        'application_confirmation',
        'offer_letter_date',
        'offer_letter_desc',
        'scholarship',
        'scholarship_amount',
        'student_id',
        'portal_student_id',
        'medical_test',
        'medical_test_date',
        'mock_interview',
        'mock_interview_qty',
        'cas_interview_date',
        'interview_invitation',
        'interview_link',
        'cas_interview_result',
        'cas_coe_loa_request',
        'cas_coe_loa_receive',
        'visa_application_date',
        'visa_result',
        'visa_interview',
        'air_ticket_booked',
        'flying_date',
        'enrollment',
        'class_start_date',
        'class_end_date',
        'notification',
        'status',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function admission() 
    {
         return $this->belongsTo(User::class, 'admission_id'); 
    }
    
    public function compliance() 
    {
         return $this->belongsTo(User::class, 'compliance_id'); 
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

     public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function campus()
    {
        return $this->belongsTo(UniCampus::class, 'uni_campus_id');
    }


    public function program()
    {
        return $this->belongsTo(Program::class, 'uni_program_id');
    }

    public function course()
    {
        return $this->belongsTo(UniCourse::class, 'uni_course_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'uni_intake_id');
    }


    public function leadStatus()
    {
        return $this->belongsTo(StatusName::class, 'lead_status_id');
    }

    public function serviceCharges()
    {
        return $this->hasMany(ServiceCharge::class);
    }
}
