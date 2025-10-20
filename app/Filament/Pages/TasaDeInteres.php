<?php

namespace App\Filament\Pages;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Support\Enums\Width;

use Filament\Pages\Page;

class TasaDeInteres extends Page
{
    protected string $view = 'filament.pages.tasa-de-interes';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    protected array $extraBodyAttributes = [
        'class' => 'bg-gray-100 dark:bg-black',
    ];

    /*public function getMaxContentWidth(): Width
        {
            return Width::Full;
        }
    */

    protected static ?string $slug = 'primer-corte/tasa-interes';

    protected static ?int $navigationSort = 0;

    public static function getNavigationGroup(): ?string
    {
        return 'Primer Corte';
    }


    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-s-chart-bar';

}
