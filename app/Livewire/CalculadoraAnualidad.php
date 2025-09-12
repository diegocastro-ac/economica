<?php

namespace App\Livewire;

use App\traits\Anualidades;
use Livewire\Component;

class CalculadoraAnualidad extends Component
{
    use Anualidades;

    public $formulaSeleccionada = 'valor_futuro'; // Fórmula por defecto

    // Control para el modo de entrada de tiempo
    public $modoTiempoDetallado = false;
    public $tiempo_anos = null;
    public $tiempo_meses = null;
    public $tiempo_dias = null;

    // Opciones disponibles para el combobox de fórmulas de anualidad
    public function getFormulasOptions()
    {
        return [
            'valor_futuro' => 'VF = A x [(1+i)^n - 1] / i (Valor Futuro de Anualidad)',
            'valor_presente' => 'VP = A x [1 - (1+i)^-n] / i (Valor Presente de Anualidad)'
        ];
    }

    // Método que se ejecuta cuando cambia la fórmula seleccionada
    public function updatedFormulaSeleccionada()
    {
        $this->reset(['result', 'valorFuturoAnualidad', 'valorPresenteAnualidad']);
    }

    // Método que se ejecuta cuando cambia el modo de tiempo
    public function updatedModoTiempoDetallado()
    {
        if ($this->modoTiempoDetallado) {
            $this->tiempo_S = null;
        } else {
            $this->reset(['tiempo_anos', 'tiempo_meses', 'tiempo_dias']);
        }
        $this->reset(['result', 'valorFuturoAnualidad', 'valorPresenteAnualidad']);
    }

    // Convertir tiempo detallado a valor único según la frecuencia
    private function convertirTiempoDetallado($precision = 2)
    {
        if (!$this->modoTiempoDetallado) {
            return $this->tiempo_S;
        }

        $anos = floatval($this->tiempo_anos ?? 0);
        $meses = floatval($this->tiempo_meses ?? 0);
        $dias = floatval($this->tiempo_dias ?? 0);

        switch ($this->frecuencia_S) {
            case 1: // AÑOS
                $valor = $anos + ($meses / 12) + ($dias / 365);
                break;
            case 12: // MESES
                $valor = ($anos * 12) + $meses + ($dias / 30);
                break;
            case 4: // TRIMESTRAL
                $valor = ($anos * 4) + ($meses / 3) + ($dias / 90);
                break;
            case 2: // SEMESTRAL
                $valor = ($anos * 2) + ($meses / 6) + ($dias / 182);
                break;
            default:
                $valor = $anos + ($meses / 12) + ($dias / 365);
        }

        return round($valor, $precision);
    }

    // Override del método calcular para manejar el tiempo detallado
    public function calcular()
    {
        $this->calcularAnualidades();
    }

    // Determinar qué campos mostrar según la fórmula seleccionada
    public function getCamposFormula()
    {
        switch ($this->formulaSeleccionada) {
            case 'valor_futuro':
                return [
                    'valorFuturoAnualidad' => ['label' => 'Valor Futuro (VF)', 'placeholder' => '100,000'],
                    'anualidad' => ['label' => 'Anualidad (A)', 'placeholder' => '5,000'],
                    'tasaInteres_S' => ['label' => 'Tasa de Interés (i) %', 'placeholder' => '5.5'],
                    'tiempo' => ['label' => 'Número de Períodos (n)', 'placeholder' => '10'],
                    'frecuencia_S' => ['label' => 'Frecuencia de Pagos', 'placeholder' => '']
                ];
            case 'valor_presente':
                return [
                    'valorPresenteAnualidad' => ['label' => 'Valor Presente (VP)', 'placeholder' => '50,000'],
                    'anualidad' => ['label' => 'Anualidad (A)', 'placeholder' => '5,000'],
                    'tasaInteres_S' => ['label' => 'Tasa de Interés (i) %', 'placeholder' => '5.5'],
                    'tiempo' => ['label' => 'Número de Períodos (n)', 'placeholder' => '10'],
                    'frecuencia_S' => ['label' => 'Frecuencia de Pagos', 'placeholder' => '']
                ];
            default:
                return [];
        }
    }

    // Método para obtener el texto descriptivo del tiempo
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
        return view('livewire.calculadora-anualidad', [
            'formulasOptions' => $this->getFormulasOptions(),
            'camposFormula' => $this->getCamposFormula()
        ]);
    }
}
