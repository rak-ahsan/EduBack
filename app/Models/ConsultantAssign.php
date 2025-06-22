<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsultantAssign extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'consultant_id',        
        'branch_id',        
    ];
    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
