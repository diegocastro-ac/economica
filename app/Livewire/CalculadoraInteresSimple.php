<?php

namespace App\Livewire;

use App\traits\formulas;
use Livewire\Component;

class CalculadoraInteresSimple extends Component
{
    use formulas;

    public float $tasaInteres_S;
    public float $capitalInicial_S;
    public float $montoFinal_S;
    public int $frecuencia_S = 1;
    public float $tiempo_S;
    public float $interesSimple_S;
    

    public function render()
    {
        return view('livewire.calculadora-interes-simple');

        
    }

    
    
    
}
