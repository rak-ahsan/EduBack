<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityDeposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'transaction_type',
        'deposit_amount',
        'deposit_document',
        'ducoment_file_path',
        'security_deposit_status',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
