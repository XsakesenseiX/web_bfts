<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPackage; // Add this line
use Illuminate\View\View; // Add this line for return type hint

class PersonalTrainerPackageController extends Controller
{
    public function index(): View
    {
        $personalTrainerPackages = MembershipPackage::where('type', 'personal_trainer')->get();

        return view('member.personal-trainer-packages.index', compact('personalTrainerPackages'));
    }
}
