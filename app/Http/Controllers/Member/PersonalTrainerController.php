<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    public function index()
    {
        $trainers = PersonalTrainer::all();
        return view('member.trainers.index', compact('trainers'));
    }
}