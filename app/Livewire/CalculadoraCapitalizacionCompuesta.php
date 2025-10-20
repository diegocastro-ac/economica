<?php

namespace App\Livewire;

use Livewire\Component;

class CalculadoraCapitalizacionCompuesta extends Component
{
    public $capital = 10000;
    public $tasaInteres = 5;
    public $tiempo = 3;
    public $frecuencia = 1; // 1=Anual, 2=Semestral, 4=Trimestral, 12=Mensual, 365=Diaria
    public $montoFinal = null;
    public $interesTotal = null;

    public function mount()
    {
        $this->calcular();
    }

    public function calcular()
    {
        // Fórmula: M = C × (1 + i/m)^(m×n)
        $i = $this->tasaInteres / 100;
        $m = $this->frecuencia;
        $n = $this->tiempo;
        
        $this->montoFinal = $this->capital * pow((1 + ($i / $m)), ($m * $n));
        $this->interesTotal = $this->montoFinal - $this->capital;
    }

    public function updated($propertyName)
    {
        $this->calcular();
    }

    public function render()
    {
        return view('livewire.calculadora-capitalizacion-compuesta');
    }
}
