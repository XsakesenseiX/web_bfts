<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\MembershipPackage;

class ViewPackages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string $view = 'filament.member.pages.view-packages';
    protected static ?string $title = 'Paket Membership';
    protected static ?string $navigationLabel = 'Paket Membership';

    public $packages;

    public function mount(): void
    {
        $this->packages = MembershipPackage::all();
    }
}