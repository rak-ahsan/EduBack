<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_assignotor_id',
        'user_executor_id',
        'task_duration',
        'task_description',
        'status',
    ];

    public function assignor()
    {
        return $this->belongsTo(User::class, 'user_assignotor_id');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'user_executor_id');
    }
}

