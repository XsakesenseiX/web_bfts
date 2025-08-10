<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $pollingInterval = '5s';
}
