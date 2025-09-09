<?php

namespace App\Livewire;

use App\traits\formulas;
use Livewire\Component;

class CalculadoraInteresSimple extends Component
{
    use formulas;

    public $formulaSeleccionada = 'interes'; // Fórmula por defecto

    // Nuevo: Control para el modo de entrada de tiempo
    public $modoTiempoDetallado = false;
    public $tiempo_anos = null;
    public $tiempo_meses = null;
    public $tiempo_dias = null;

    // Opciones disponibles para el combobox de fórmulas
    public function getFormulasOptions()
    {
        return [
            'interes' => 'I = C × i × t (Calcular Interés)',
            'monto' => 'M = C(1 + i × t) (Calcular Monto/Capital/Tasa/Tiempo)'
        ];
    }

    // Método que se ejecuta cuando cambia la fórmula seleccionada
    public function updatedFormulaSeleccionada()
    {
        // Limpiar resultados cuando cambie la fórmula
        $this->reset(['result', 'interesSimple_S']);
    }

    // Nuevo: Método que se ejecuta cuando cambia el modo de tiempo
    public function updatedModoTiempoDetallado()
    {
        if ($this->modoTiempoDetallado) {
            // Si cambia a modo detallado, limpiar el campo simple
            $this->tiempo_S = null;
        } else {
            // Si cambia a modo simple, limpiar los campos detallados
            $this->reset(['tiempo_anos', 'tiempo_meses', 'tiempo_dias']);
        }
        // Limpiar resultados
        $this->reset(['result', 'interesSimple_S']);
    }

    // Nuevo: Convertir tiempo detallado a valor único según la frecuencia
    private function convertirTiempoDetallado($precision = 2)
    {
        if (!$this->modoTiempoDetallado) {
            return $this->tiempo_S;
        }

        $anos = floatval($this->tiempo_anos ?? 0);
        $meses = floatval($this->tiempo_meses ?? 0);
        $dias = floatval($this->tiempo_dias ?? 0);

        switch ($this->frecuencia_S) {
            case 1: // queremos periodos en AÑOS
                $valor = $anos + ($meses / 12) + ($dias / 365);
                break;
            case 12: // queremos periodos en MESES
                $valor = ($anos * 12) + $meses + ($dias / 30); // aquí 30 días/mes aproximado
                break;
            case 365: // queremos periodos en DÍAS
                $valor = ($anos * 365) + ($meses * 30) + $dias;
                break;
            default:
                $valor = $anos + ($meses / 12) + ($dias / 365);
        }

        // <-- redondeamos para que coincida con el campo "tiempo simple"
        return round($valor, $precision);
    }


    // Override del método calcular para manejar el tiempo detallado
    public function calcular(String $tipo)
    {
        // Si está en modo tiempo detallado, convertir a tiempo simple
        if ($this->modoTiempoDetallado) {
            $this->tiempo_S = $this->convertirTiempoDetallado();
        }

        // Llamar al método original del trait
        if ($tipo === "interesSimple") {
            $this->interesSimple();
        } else if ($tipo === "interesCompuesto") {
            $this->interesCompuesto();
        } else {
            $this->anualidad();
        }
    }

    // Determinar qué campos mostrar según la fórmula seleccionada
    public function getCamposFormula()
    {
        switch ($this->formulaSeleccionada) {
            case 'interes':
                return [
                    'interesSimple_S' => ['label' => 'Interés (I)', 'placeholder' => '5,000'],
                    'capitalInicial_S' => ['label' => 'Capital (C)', 'placeholder' => '10,000'],
                    'tasaInteres_S' => ['label' => 'Tasa de Interés (i) %', 'placeholder' => '5.5'],
                    'tiempo' => ['label' => 'Tiempo (t)', 'placeholder' => '2'], // Cambiado para manejo especial
                    'frecuencia_S' => ['label' => 'Unidades de Tiempo', 'placeholder' => '']
                ];
            case 'monto':
                return [
                    'montoFinal_S' => ['label' => 'Monto Final (M)', 'placeholder' => '15,000'],
                    'capitalInicial_S' => ['label' => 'Capital (C)', 'placeholder' => '10,000'],
                    'tasaInteres_S' => ['label' => 'Tasa de Interés (i) %', 'placeholder' => '5.5'],
                    'tiempo' => ['label' => 'Tiempo (t)', 'placeholder' => '2'], // Cambiado para manejo especial
                    'frecuencia_S' => ['label' => 'Unidades de Tiempo', 'placeholder' => '']
                ];
            default:
                return [];
        }
    }

    // Nuevo: Método para obtener el texto descriptivo del tiempo
    public function getTiempoDescriptivo()
    {
        if (!$this->modoTiempoDetallado) {
            return null;
        }

        $partes = [];
        if ($this->tiempo_anos && $this->tiempo_anos > 0) {
            $partes[] = $this->tiempo_anos . ' ' . ($this->tiempo_anos == 1 ? 'año' : 'años');
        }
        if ($this->tiempo_meses && $this->tiempo_meses > 0) {
            $partes[] = $this->tiempo_meses . ' ' . ($this->tiempo_meses == 1 ? 'mes' : 'meses');
        }
        if ($this->tiempo_dias && $this->tiempo_dias > 0) {
            $partes[] = $this->tiempo_dias . ' ' . ($this->tiempo_dias == 1 ? 'día' : 'días');
        }

        return count($partes) > 0 ? implode(', ', $partes) : 'Sin tiempo especificado';
    }

    public function render()
    {
        return view('livewire.calculadora-interes-simple', [
            'formulasOptions' => $this->getFormulasOptions(),
            'camposFormula' => $this->getCamposFormula()
        ]);
    }
}
