<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'country_id',
        'state_id',
        'name',
        'phone',
        'email',
        'address',
        'status',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function branchAssign(): HasOne
    {
        return $this->hasOne(BranchAssign::class);
    }
}
