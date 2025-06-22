<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRight extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'role_rights';

    public function right()
    {
        return $this->belongsTo(Right::class, 'right_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
