<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentAssign extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'agent_manager_id',        
        'agent_id',        
    ];
    public function agentManger()
    {
        return $this->belongsTo(User::class, 'agent_manager_id');
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
