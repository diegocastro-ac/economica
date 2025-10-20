<?php

namespace App\Filament\Pages;
use Illuminate\Contracts\Support\Htmlable;

use Filament\Pages\Page;

class SistemasDeCapitalización extends Page
{
    protected string $view = 'filament.pages.sistemas-de-capitalización';

    protected static ?string $slug = 'segundo-corte/sistemas-de-capitalización';

    protected static ?int $navigationSort = 0;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-c-arrow-down-left';

    // Esta es la propiedad que necesitas para el wire:model
    public string $tipoCapitalizacion = '';

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
}
