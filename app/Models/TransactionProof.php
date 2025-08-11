<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionProof extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'proof_path',
        'status',
        'notes',
    ];

    /**
     * Get the user that owns the transaction proof.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the membership that the transaction proof belongs to.
     */
    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }
}
