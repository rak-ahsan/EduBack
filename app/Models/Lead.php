<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'resource',
        'marketer_id',
        'junior_consultant_id',
        'abc_user_id',
        'reference',
        'academic_details',
        'language_details',
        'destination',
        'program_id',
        'intake_id',
        'intake_year',
        'lead_finacial',
        'lead_situation',
        'lead_status_id',
        'appointment_date',
        'last_call_status',
        'last_call_date',
        'number_of_call',
        'remarks',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'first_name',
        'last_name',
        'birthday',
        'email',
        'phone',
        'alt_phone',
        'fathers_name',
        'mothers_name',
        'gender',
        'blood_group',
        'marital_status',
        'religion',
        'nationality',
        'nid_number',
        'nid_image',
        'user_image',
        'passport_number',
        'issue_date',
        'expiry_date',
        'passport_image',
        'duplicate',
        'duplicate_number',
        'status',
    ];

    // Example relationships
    public function marketer()
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }
    public function juniorConsultant()
    {
         return $this->belongsTo(User::class, 'junior_consultant_id');
    }
    public function abcUser()
    {
         return $this->belongsTo(User::class, 'abc_user_id');
    }
    public function program()
    {
         return $this->belongsTo(Program::class);
    }
    public function intake()
    {
         return $this->belongsTo(Intake::class);
    }
    public function leadStatus()
    {
         return $this->belongsTo(StatusName::class, 'lead_status_id');
    }
    public function country(){
         return $this->belongsTo(Country::class);
    }
    public function state(){
         return $this->belongsTo(State::class);
    }
    public function city()
    {
         return $this->belongsTo(City::class);
    }


    public function studentAcademics()
    {
        return $this->hasMany(StudentAcademic::class);
    }

    public function studentExperiences()
    {
        return $this->hasMany(StudentExperience::class);
    }


    public function studentLanguages()
    {
        return $this->hasMany(StudentLanguage::class);
    }
    public function securityDeposits()
    {
        return $this->hasMany(SecurityDeposit::class);
    }

    public function applications()
    {
       return $this->hasMany(Application::class);
    }

    

}
