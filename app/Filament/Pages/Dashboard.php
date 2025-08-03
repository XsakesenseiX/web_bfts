<?php

namespace App\Filament\Pages;

// 1. Ganti 'Page' menjadi 'Dashboard as BaseDashboard'
use Filament\Pages\Dashboard as BaseDashboard;

// 2. Ganti 'extends Page' menjadi 'extends BaseDashboard'
class Dashboard extends BaseDashboard
{
    // Anda bisa mengganti ikonnya jika mau
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\RecentCheckIns::class,
        ];
    }
}