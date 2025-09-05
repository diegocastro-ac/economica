<?php

namespace App\Filament\Pages;

use Filament\Jetstream\Pages\Dashboard as PagesDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends PagesDashboard
{
    protected string $view = 'filament.pages.dashboard';

    public function getHeading(): string|Htmlable
    {
        return 'test';
    }
}
