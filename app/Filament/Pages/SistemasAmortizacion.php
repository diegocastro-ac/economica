<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Page;


class SistemasAmortizacion extends Page
{
    protected string $view = 'filament.pages.amortizacion';

    protected static ?string $slug = 'segundo-corte/sistemas-amortizacion';

    protected static ?int $navigationSort = 2;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-c-arrow-down-left';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Segundo Corte';
    }

    protected array $extraBodyAttributes = [
        'class' => 'bg-gray-100 dark:bg-black',
    ];

    //public function getMaxContentWidth(): Width
    //    {
    //        return Width::Full;
    //    }
}
