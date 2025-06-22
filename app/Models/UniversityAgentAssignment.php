<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class UniversityAgentAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'university_id',
    ];

    public function user() 
    {
         return $this->belongsTo(User::class, 'user_id'); 
    }

    public function university() 
    {
         return $this->belongsTo(University::class, 'university_id'); 
    }
}
