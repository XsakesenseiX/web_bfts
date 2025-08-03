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
}

