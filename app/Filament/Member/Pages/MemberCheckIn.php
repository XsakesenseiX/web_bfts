<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\CheckIn;
use Filament\Actions\Action;

class MemberCheckIn extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static string $view = 'filament.member.pages.member-check-in';
    protected static ?string $title = 'Check-in';
    protected static ?string $navigationLabel = 'Check-in';

    public function mount(): void
    {
        $user = Auth::user();

        // Validasi sebelum halaman dimuat
        if (!$user->activeMembership()->exists()) {
            $this->redirect(MemberDashboard::getUrl(), navigate: true);
        }

        $todayCheckIn = $user->checkIns()->whereDate('created_at', Carbon::today())->first();
        if ($todayCheckIn) {
            $this->redirect(MemberDashboard::getUrl(), navigate: true);
        }
    }

    // Method ini akan dipanggil oleh JavaScript
    public function recordCheckIn(): array
    {
        CheckIn::create(['user_id' => Auth::id()]);
        return ['success' => true, 'message' => 'Check-in berhasil!'];
    }
}