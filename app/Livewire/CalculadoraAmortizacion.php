<?php

namespace App\Livewire;

use App\traits\SistemasAmortizacion;
use Livewire\Component;

class CalculadoraAmortizacion extends Component
{
    use SistemasAmortizacion;

    public $sistemaSeleccionado = 'frances'; // 'frances', 'aleman', 'americano'

    // Opciones disponibles
    public function getSistemasOptions()
    {
        return [
            'frances' => 'Sistema Francés',
            'aleman' => 'Sistema Alemán',
            'americano' => 'Sistema Americano'
        ];
    }

    // Método que se ejecuta cuando cambia el sistema
    public function updatedSistemaSeleccionado()
    {
        // Limpiar datos anteriores
        $this->reset([
            'capitalPrestado_A',
            'tasaInteres_A',
            'numeroPeriodos_A',
            'cuotaFrances',
            'amortizacionAleman',
            'tablaAmortizacion',
            'sistemaActivo'
        ]);
    }

    // Método principal de cálculo
    public function calcular()
    {
        // Limpiar resultados anteriores
        $this->cuotaFrances = null;
        $this->amortizacionAleman = null;
        $this->tablaAmortizacion = [];

        match ($this->sistemaSeleccionado) {
            'frances' => $this->calcularAmortizacionFrances(),
            'aleman' => $this->calcularAmortizacionAleman(),
            'americano' => $this->calcularAmortizacionAmericano(),
            default => session()->flash('error', 'Sistema no reconocido')
        };
    }

    // Obtener descripción del sistema
    public function getDescripcionSistema()
    {
        return match ($this->sistemaSeleccionado) {
            'frances' => [
                'nombre' => 'Sistema Francés',
                'descripcion' => 'Cuota periódica constante durante toda la amortización.',
                'caracteristicas' => [
                    'Cuota: Constante',
                    'Amortización: Creciente',
                    'Intereses: Decreciente'
                ],
                'formula' => 'a = Co × [i / (1 - (1+i)^-n)]',
                'uso' => 'Usado en hipotecas, créditos al consumo'
            ],
            'aleman' => [
                'nombre' => 'Sistema Alemán',
                'descripcion' => 'Amortización de capital constante. Las cuotas disminuyen periódicamente.',
                'caracteristicas' => [
                    'Amortización: Constante',
                    'Cuota: Decreciente',
                    'Intereses: Decreciente'
                ],
                'formula' => 'A = Co / n, I = Dp × i, a = A + I',
                'uso' => 'Créditos comerciales, préstamos a corto plazo'
            ],
            'americano' => [
                'nombre' => 'Sistema Americano',
                'descripcion' => 'Se pagan solo intereses periódicamente. El capital se paga al final.',
                'caracteristicas' => [
                    'Períodos 1 a n-1: Solo intereses',
                    'Período final: Capital + Interés',
                    'Capital: Sin amortizar hasta el final'
                ],
                'formula' => 'a = Co × i (períodos intermedios), a´ = Co + (Co × i) (período final)',
                'uso' => 'Bonos, préstamos con fondos de amortización'
            ],
            default => []
        };
    }

    // Obtener información de campos
    public function getCamposFormula()
    {
        return [
            'capitalPrestado_A' => [
                'label' => 'Capital Prestado (Co)',
                'placeholder' => '500,000',
                'required' => true,
                'help' => 'Monto total del préstamo'
            ],
            'tasaInteres_A' => [
                'label' => 'Tasa de Interés (i) %',
                'placeholder' => '12',
                'required' => true,
                'help' => 'Tasa de interés anual (o por período)'
            ],
            'numeroPeriodos_A' => [
                'label' => 'Número de Períodos (n)',
                'placeholder' => '15',
                'required' => true,
                'help' => 'Cantidad total de cuotas/períodos'
            ]
        ];
    }

    // Validar que los datos sean correctos
    public function validarDatos()
    {
        if (is_null($this->capitalPrestado_A) || is_null($this->tasaInteres_A) || is_null($this->numeroPeriodos_A)) {
            return 'Todos los campos son obligatorios';
        }

        if ($this->capitalPrestado_A <= 0) {
            return 'El capital prestado debe ser mayor a cero';
        }

        if ($this->tasaInteres_A < 0) {
            return 'La tasa de interés no puede ser negativa';
        }

        if ($this->numeroPeriodos_A <= 0) {
            return 'El número de períodos debe ser mayor a cero';
        }

        return null;
    }

    // Obtener el estado de la tabla
    public function tieneTabla()
    {
        return !empty($this->tablaAmortizacion);
    }

    // Obtener formatos de número para la tabla
    public function formatoMoneda($valor)
    {
        if ($valor === null) {
            return '-';
        }
        return '$' . number_format($valor, 2);
    }

    // Obtener totales de la tabla
    public function obtenerTotales()
    {
        if (empty($this->tablaAmortizacion)) {
            return null;
        }

        $filaTotal = end($this->tablaAmortizacion);

        if (!isset($filaTotal['es_total']) || !$filaTotal['es_total']) {
            return null;
        }

        return [
            'capital' => $filaTotal['amortizacion'] ?? 0,
            'interes' => $filaTotal['interes'] ?? 0,
            'cuota' => $filaTotal['cuota'] ?? 0
        ];
    }

    public function render()
    {
        return view('livewire.calculadora-amortizacion', [
            'sistemasOptions' => $this->getSistemasOptions(),
            'camposFormula' => $this->getCamposFormula(),
            'descripcionSistema' => $this->getDescripcionSistema(),
            'resumenCuotas' => $this->getResumenCuotas(),
            'estadisticas' => $this->getEstadisticasAmortizacion(),
            'tabla' => $this->getTablaAmortizacion(),
            'totales' => $this->obtenerTotales(),
            'erroresValidacion' => $this->validarDatos(),
            'formatoMoneda' => function ($valor) {
                return $this->formatoMoneda($valor);
            }
        ]);
    }
}
