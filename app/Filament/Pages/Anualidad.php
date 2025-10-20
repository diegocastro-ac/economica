<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Anualidad extends Page
{
    protected string $view = 'filament.pages.anualidad';

    protected static ?string $slug = 'primer-corte/anualidad';

    protected static ?int $navigationSort = 3;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-c-arrow-down-left';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Primer Corte';
    }

    protected array $extraBodyAttributes = [
        'class' => 'bg-gray-100 dark:bg-black',
    ];

    //public function getMaxContentWidth(): Width
    //    {
    //        return Width::Full;
    //    }
}
