<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
    'user_id',
    'membership_package_id',
    'start_date',
    'end_date',
    'status',
    'check_ins_made',
    'payment_proof',
];


public function user()
{
    return $this->belongsTo(User::class);
}


public function package()
{
    return $this->belongsTo(MembershipPackage::class, 'membership_package_id');
}

public function membershipPackage()
{
    return $this->belongsTo(MembershipPackage::class, 'membership_package_id');
}

/**
 * Get the transaction proofs for the membership.
 */
public function transactionProofs()
{
    return $this->hasMany(TransactionProof::class);
}
}

