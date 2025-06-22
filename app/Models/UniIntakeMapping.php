<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniIntakeMapping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'university_id',
        'uni_courses_id',
        'uni_intake_id',
        'status',
    ];

    //get intake
    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class, 'uni_intake_id');
    }
}

