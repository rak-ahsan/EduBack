<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'country_id',
        'name',
        'state_code',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
