<?php

namespace App\Filament\Pages;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Support\Enums\Width;
use Filament\Pages\Page;


class InteresSimple extends Page
{
    protected string $view = 'filament.pages.interes-simple';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    protected array $extraBodyAttributes = [
        'class' => 'bg-gray-100 dark:bg-black',
    ];

    //public function getMaxContentWidth(): Width
    //    {
    //        return Width::Full;
    //    }

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static string|null|\BackedEnum $activeNavigationIcon = 'heroicon-c-arrow-down-left';
    
    
}
