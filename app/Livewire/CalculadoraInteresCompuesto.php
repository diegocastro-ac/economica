<?php

namespace App\Livewire;

use App\traits\formulas;
use Livewire\Component;

class CalculadoraInteresCompuesto extends Component
{

    use formulas;

    public float $tasaInteres_C;
    public float $capitalInicial_C;
    public float $montoFinal_C;
    public int $capitalizacion_C = 1;
    public float $tiempo_C;


    public function render()
    {
        return view('livewire.calculadora-interes-compuesto');
    }

    
}
