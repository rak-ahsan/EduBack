<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniIntake extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'university_id',
        'intake_id',
        'intake_application_date',
        'intake_interview_date',
        'intake_payment_date',
        'intake_cas_coe_i_date',
        'status',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }
    public function intake_id(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }
}
