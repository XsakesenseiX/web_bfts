<?php

namespace App\Filament\Resources\PersonalTrainerResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\MembershipPackage;

class PersonalTrainerPackagesOverview extends Widget
{
    protected static string $view = 'filament.resources.personal-trainer-resource.widgets.personal-trainer-packages-overview';

    protected int | string | array $columnSpan = 'full';

    public function getPersonalTrainerPackages()
    {
        return MembershipPackage::where('type', 'personal_trainer')->get();
    }
}
