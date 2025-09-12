<?php

namespace App\Filament\Pages;
use Illuminate\Contracts\Support\Htmlable;

use Filament\Pages\Page;

class InteresCompuesto extends Page
{
    protected string $view = 'filament.pages.interes-compuesto';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    protected array $extraBodyAttributes = [
        'class' => 'bg-gray-100 dark:bg-black',
    ];

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-c-arrow-down-left';
}
