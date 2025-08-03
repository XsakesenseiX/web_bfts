<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckInController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!$user->activeMembership()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Check-in gagal! Anda tidak memiliki membership aktif.');
        }
        $todayCheckIn = $user->checkIns()->whereDate('created_at', Carbon::today())->first();
        if ($todayCheckIn) {
            return redirect()->route('dashboard')->with('success', 'Anda sudah melakukan check-in hari ini.');
        }
        return view('member.checkin.create');
    }

    public function store(Request $request)
    {
        CheckIn::create(['user_id' => Auth::id()]);
        return response()->json(['success' => true, 'message' => 'Check-in berhasil!']);
    }
}