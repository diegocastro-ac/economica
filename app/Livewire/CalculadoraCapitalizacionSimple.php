<?php

namespace App\Livewire;

use Livewire\Component;

class CalculadoraCapitalizacionSimple extends Component
{
    public $capital = null;
    public $tasaInteres = null;
    public $tiempoAnios = null;
    public $tiempoMeses = null;
    public $tiempoDias = null;
    public $tiempo = null; // Tiempo total en años (decimal)
    public $montoFinal = null;
    public $interesTotal = null;
    public $frecuencia = 'anual'; // Tipo de capitalización
    
    // Para rastrear qué campo está vacío
    public $campoACalcular = null;
    public $resultadoCalculado = false;

    public function mount()
    {
        // Iniciamos sin valores para que el usuario llene
    }

    public function calcular()
    {
        $this->resultadoCalculado = false;
        
        // Calcular tiempo total en años según la frecuencia
        $tiempoEnUnidad = ($this->tiempoAnios ?? 0) + (($this->tiempoMeses ?? 0) / 12) + (($this->tiempoDias ?? 0) / 360);
        
        // Ajustar el tiempo según la frecuencia de capitalización
        switch($this->frecuencia) {
            case 'diaria':
                $this->tiempo = $tiempoEnUnidad; // Ya está en años
                $diasTotales = (($this->tiempoAnios ?? 0) * 360) + (($this->tiempoMeses ?? 0) * 30) + ($this->tiempoDias ?? 0);
                break;
            case 'mensual':
                $this->tiempo = $tiempoEnUnidad;
                break;
            case 'trimestral':
                $this->tiempo = $tiempoEnUnidad;
                break;
            case 'semestral':
                $this->tiempo = $tiempoEnUnidad;
                break;
            case 'anual':
            default:
                $this->tiempo = $tiempoEnUnidad;
                break;
        }
        
        // Contar cuántos campos están vacíos o en cero
        $camposVacios = [];
        
        if (empty($this->capital) || $this->capital == 0) {
            $camposVacios[] = 'capital';
        }
        if (empty($this->tasaInteres) || $this->tasaInteres == 0) {
            $camposVacios[] = 'tasaInteres';
        }
        if ($this->tiempo == 0) {
            $camposVacios[] = 'tiempo';
        }
        if (empty($this->montoFinal) || $this->montoFinal == 0) {
            $camposVacios[] = 'montoFinal';
        }

        // Solo calcular si hay exactamente un campo vacío
        if (count($camposVacios) != 1) {
            session()->flash('error', 'Debes llenar exactamente 3 campos y dejar 1 vacío para calcular.');
            return;
        }
        
        $this->campoACalcular = $camposVacios[0];
        
        try {
            switch ($this->campoACalcular) {
                case 'montoFinal':
                    // M = C × (1 + i × t)
                    $i = $this->tasaInteres / 100;
                    $this->montoFinal = $this->capital * (1 + ($i * $this->tiempo));
                    break;
                    
                case 'capital':
                    // C = M / (1 + i × t)
                    $i = $this->tasaInteres / 100;
                    $this->capital = $this->montoFinal / (1 + ($i * $this->tiempo));
                    break;
                    
                case 'tasaInteres':
                    // i = (M/C - 1) / t
                    if ($this->tiempo == 0) {
                        session()->flash('error', 'El tiempo no puede ser cero.');
                        return;
                    }
                    $i = (($this->montoFinal / $this->capital) - 1) / $this->tiempo;
                    $this->tasaInteres = $i * 100;
                    break;
                    
                case 'tiempo':
                    // t = (M/C - 1) / i
                    $i = $this->tasaInteres / 100;
                    if ($i == 0) {
                        session()->flash('error', 'La tasa de interés no puede ser cero.');
                        return;
                    }
                    $this->tiempo = (($this->montoFinal / $this->capital) - 1) / $i;
                    
                    // Convertir tiempo decimal a años, meses y días
                    $this->tiempoAnios = floor($this->tiempo);
                    $restoAnios = $this->tiempo - $this->tiempoAnios;
                    
                    $mesesDecimal = $restoAnios * 12;
                    $this->tiempoMeses = floor($mesesDecimal);
                    $restoMeses = $mesesDecimal - $this->tiempoMeses;
                    
                    $this->tiempoDias = round($restoMeses * 30);
                    break;
            }
            
            // Calcular interés total
            if ($this->montoFinal && $this->capital) {
                $this->interesTotal = $this->montoFinal - $this->capital;
            }
            
            $this->resultadoCalculado = true;
            session()->flash('success', 'Cálculo realizado exitosamente.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error en el cálculo: ' . $e->getMessage());
        }
    }
    
    public function limpiarTodo()
    {
        $this->capital = null;
        $this->tasaInteres = null;
        $this->tiempoAnios = null;
        $this->tiempoMeses = null;
        $this->tiempoDias = null;
        $this->tiempo = null;
        $this->montoFinal = null;
        $this->interesTotal = null;
        $this->campoACalcular = null;
        $this->resultadoCalculado = false;
        session()->flash('info', 'Todos los campos han sido limpiados.');
    }

    public function render()
    {
        return view('livewire.calculadora-capitalizacion-simple');
    }
}