<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BranchAssign extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_manager_id',        
        'branch_id',        
    ];
    public function branchManger()
    {
        return $this->belongsTo(User::class, 'branch_manager_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
