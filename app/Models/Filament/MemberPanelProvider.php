<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// Impor semua halaman yang akan kita daftarkan
use App\Filament\Member\Pages\MemberDashboard;
use App\Filament\Member\Pages\ViewPackages;
use App\Filament\Member\Pages\PurchasePackage;
use App\Filament\Member\Pages\MemberCheckIn;

class MemberPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('member')
            ->path('member')
            ->login()
            ->colors([
                'primary' => '#9BFD14',
                'gray' => [
                    50 => '#909090',
                    100 => '#909090',
                    200 => '#909090',
                    300 => '#909090',
                    400 => '#909090',
                    500 => '#909090',
                    600 => '#909090',
                    700 => '#909090',
                    800 => '#909090',
                    900 => '#909090',
                ],
            ])
            // Kita tidak lagi terlalu bergantung pada discoverPages
            ->discoverPages(in: app_path('Filament/Member/Pages'), for: 'App\\Filament\\Member\\Pages')
            ->pages([
                // Daftarkan semua halaman Anda secara manual di sini
                MemberDashboard::class,
                ViewPackages::class,
                PurchasePackage::class,
                MemberCheckIn::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/member-safe-styling.css')
            ->darkMode(false);
    }
}