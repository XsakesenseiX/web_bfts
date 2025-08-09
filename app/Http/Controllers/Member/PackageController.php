<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = MembershipPackage::query();

        if ($user->status === 'mahasiswa') {
            $query->whereIn('type', ['student', 'loyalty']);
        } else {
            $query->whereIn('type', ['regular', 'loyalty']);
        }

        $packages = $query->get();

        return view('member.packages.index', compact('packages'));
    }

    public function show(MembershipPackage $package)
    {
        $user = Auth::user();
        $additionalFee = 0;
        $lastActiveMembership = $user->memberships()->where('status', 'active')->latest('end_date')->first();

        if (!$lastActiveMembership || Carbon::parse($lastActiveMembership->end_date)->addMonths(3)->isPast()) {
            $additionalFee = 40000;
        }

        $totalPrice = $package->price + $additionalFee;

        return view('member.packages.show', compact('package', 'additionalFee', 'totalPrice'));
    }

    public function purchase(Request $request, MembershipPackage $package)
    {
        $request->validate(['payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $path = $request->file('payment_proof')->store('proofs', 'public');

        Membership::create([
            'user_id' => Auth::id(),
            'membership_package_id' => $package->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($package->duration_days),
            'status' => 'pending',
            'payment_proof' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', 'Permintaan pembelian berhasil dikirim.');
    }
}