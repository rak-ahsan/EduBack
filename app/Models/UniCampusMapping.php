<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniCampusMapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'university_id',
        'uni_course_id',
        'uni_campus_id',
        'status',
    ];

    //get campus
    public function campus(): BelongsTo
    {
        return $this->belongsTo(UniCampus::class, 'uni_campus_id');
    }
}
