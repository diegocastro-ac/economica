<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;

use Filament\Pages\Page;

class InteresCompuesto extends Page
{
    protected string $view = 'filament.pages.interes-compuesto';

    protected static ?string $slug = 'primer-corte/interes-compuesto';

    protected static ?int $navigationSort = 1;

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
}
