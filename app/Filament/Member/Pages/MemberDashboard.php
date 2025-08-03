<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MemberDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.member.pages.member-dashboard';
    protected static ?string $title = 'Dashboard';

    public $membership;
    public $checkInHistory;

    public function mount(): void
{
    $user = Auth::user();

    // 1. Prioritaskan mencari membership yang 'active'
    $displayMembership = $user->memberships()->where('status', 'active')->first();

    // 2. Jika tidak ada yang aktif, baru cari yang 'pending'
    if (!$displayMembership) {
        $displayMembership = $user->memberships()->where('status', 'pending')->latest()->first();
    }

    // 3. Jika masih tidak ada, cari yang paling baru (kemungkinan expired)
    if (!$displayMembership) {
        $displayMembership = $user->memberships()->latest()->first();
    }

    $this->membership = $displayMembership;
    $this->checkInHistory = $user->checkIns()->latest()->take(10)->get();
}
}