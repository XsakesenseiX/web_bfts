<?php

namespace App\Filament\Widgets;

use App\Models\Membership;
use App\Models\User;
use App\Models\CheckIn;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VerificationOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '5s'; // Poll every 5 seconds

    protected function getStats(): array
    {
        $pendingMemberships = Membership::where('status', 'pending')->count();
        $pendingStudentVerifications = User::where('status', 'mahasiswa')->where('is_approved', false)->count();
        $dailyVisitors = CheckIn::whereDate('created_at', Carbon::today())->count();
        $activeMembers = User::whereHas('memberships', function ($query) {
            $query->where('status', 'active');
        })->count();

        return [
            Stat::make('Verifikasi Pembayaran Tertunda', $pendingMemberships)
                ->description('Menunggu persetujuan')
                ->color('warning'),
            Stat::make('Verifikasi Mahasiswa Tertunda', $pendingStudentVerifications)
                ->description('Menunggu persetujuan')
                ->color('warning'),
            Stat::make('Pengunjung Harian', $dailyVisitors)
                ->description('Check-in hari ini')
                ->color('success'),
            Stat::make('Member Aktif', $activeMembers)
                ->description('Memiliki membership aktif')
                ->color('success'),
        ];
    }
}
