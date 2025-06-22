<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusName extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'status_group_id',
        'name',
        'desc',
        'status',
    ];

    public function statusGroup()
    {
        return $this->belongsTo(StatusGroup::class, 'status_group_id');
    }
}
