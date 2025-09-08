<?php

namespace App\Livewire;

use App\traits\formulas;
use Livewire\Component;

class CalculadoraInteresSimple extends Component
{
    use formulas;

    public function render()
    {
        return view('livewire.calculadora-interes-simple');

        
    }

    
    
    
}
