<?php

namespace App\Livewire;

use Livewire\Component;

class CalculadoraCapitalizacionContinua extends Component
{
    public $capital = 10000;
    public $tasaInteres = 5;
    public $tiempo = 3;
    public $montoFinal = null;
    public $interesTotal = null;

    public function mount()
    {
        $this->calcular();
    }

    public function calcular()
    {
        // Fórmula: M = C × e^(i×n)
        $i = $this->tasaInteres / 100;
        $this->montoFinal = $this->capital * exp($i * $this->tiempo);
        $this->interesTotal = $this->montoFinal - $this->capital;
    }

    public function updated($propertyName)
    {
        $this->calcular();
    }

    public function render()
    {
        return view('livewire.calculadora-capitalizacion-continua');
    }
}
