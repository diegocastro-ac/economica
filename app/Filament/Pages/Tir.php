<?php

namespace App\Filament\Pages;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Page;

class Tir extends Page
{

    protected string $view = 'filament.pages.tir';

    protected static ?string $slug = 'segundo-corte/tir';

    protected static ?int $navigationSort = 0;

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
}
