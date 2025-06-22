<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentTraining extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'title',
        'topic',
        'institue',
        'passing_year',
        'duration',
        'image',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
