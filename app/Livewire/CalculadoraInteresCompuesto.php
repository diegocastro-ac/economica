<?php

namespace App\Livewire;

use App\traits\formulas;
use Livewire\Component;

class CalculadoraInteresCompuesto extends Component
{
    use formulas;

    public $capitalInicial_C;
    public $montoFinal_C;
    public $tasaInteres_C;
    public $tipoTasa_C = 1;
    public $tiempo_C;
    public $capitalizacion_C = 1; // Por defecto semestral

    public function render()
    {
        return view('livewire.calculadora-interes-compuesto');
    }

    public function getDescripcionResultado()
    {
        if (!isset($this->result)) {
            return 'Ingresa los datos y haz clic en calcular';
        }

        $descripcion = '';

        if (empty($this->capitalInicial_C)) {
            $descripcion = 'Capital inicial requerido';
        } elseif (empty($this->montoFinal_C)) {
            $descripcion = 'Monto final después de ' . $this->tiempo_C . ' años';
        } elseif (empty($this->tasaInteres_C)) {
            $descripcion = 'Tasa de interés anual requerida';
        } elseif (empty($this->tiempo_C)) {
            $descripcion = 'Tiempo requerido para alcanzar el monto objetivo';
        }

        // Agregar información sobre capitalización
        $frecuencias = [
            1 => 'capitalización anual',
            2 => 'capitalización semestral',
            3 => 'capitalización trimestral',
            12 => 'capitalización mensual',
            365 => 'capitalización diaria'
        ];

        $frecuencia = $frecuencias[$this->capitalizacion_C] ?? 'capitalización personalizada';
        
        return $descripcion . ' con ' . $frecuencia;
    }

    public function mount()
    {
        // Valores por defecto del ejemplo
        // Un inversionista necesita $50,000,000 en 6 años al 9% semestral
        //$this->montoFinal_C = 50000000;
        //$this->tiempo_C = 6;
        //$this->tasaInteres_C = 9;
        //$this->capitalizacion_C = 2; // Semestral
    }
}