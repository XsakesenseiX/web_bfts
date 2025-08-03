<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        // Jika user sudah login, arahkan langsung ke "gerbang" dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Jika belum, tampilkan halaman company profile
        return view('welcome');
    }
}