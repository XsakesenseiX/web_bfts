<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    protected $fillable = ['name', 'price', 'duration_days', 'check_in_limit', 'description', 'type'];
}
