<?php

namespace App\Livewire;

use Livewire\Component;

class Tir extends Component
{
    public $calculationType = 'tir';
    public $capitalInicial = '';
    public $tasaK = '';
    public $periodos = [];
    public $resultado = null;

    public function mount()
    {
        $this->periodos = [
            ['periodo' => 1, 'flujo' => ''],
            ['periodo' => 2, 'flujo' => ''],
            ['periodo' => 3, 'flujo' => ''],
        ];
    }

    public function agregarPeriodo()
    {
        $this->periodos[] = [
            'periodo' => count($this->periodos) + 1,
            'flujo' => ''
        ];
    }

    public function eliminarPeriodo($index)
    {
        if (count($this->periodos) > 1) {
            unset($this->periodos[$index]);
            // Reindexar y renumerar
            $this->periodos = array_values($this->periodos);
            foreach ($this->periodos as $key => $periodo) {
                $this->periodos[$key]['periodo'] = $key + 1;
            }
        }
    }

    private function calcularVPN($tasa)
    {
        $tasaDecimal = $tasa / 100;
        $capital = floatval($this->capitalInicial);
        
        $vpn = -$capital; // Inversión inicial es negativa
        
        foreach ($this->periodos as $periodo) {
            $flujo = floatval($periodo['flujo']);
            $n = $periodo['periodo'];
            $vpn += $flujo / pow(1 + $tasaDecimal, $n);
        }
        
        return $vpn;
    }

    private function calcularTIR()
    {
        $tir = 0.1; // Estimación inicial del 10%
        $maxIteraciones = 500;
        $tolerancia = 0.000001;
        
        for ($i = 0; $i < $maxIteraciones; $i++) {
            $capital = floatval($this->capitalInicial);
            $vpn = -$capital;
            $derivada = 0;
            
            // Calcular VPN y su derivada
            foreach ($this->periodos as $periodo) {
                $flujo = floatval($periodo['flujo']);
                $n = $periodo['periodo'];
                $vpn += $flujo / pow(1 + $tir, $n);
                $derivada -= ($n * $flujo) / pow(1 + $tir, $n + 1);
            }
            
            // Si VPN es muy pequeño, hemos encontrado la TIR
            if (abs($vpn) < $tolerancia) {
                return $tir * 100; // Convertir a porcentaje
            }
            
            // Aplicar Newton-Raphson: x_nuevo = x_viejo - f(x)/f'(x)
            if ($derivada != 0) {
                $tir = $tir - $vpn / $derivada;
            } else {
                break;
            }
            
            // Evitar valores negativos extremos
            if ($tir < -0.99) {
                $tir = -0.99;
            }
        }
        
        return $tir * 100;
    }

    public function calcular()
    {
        // Validar campos
        if (empty($this->capitalInicial)) {
            session()->flash('error', 'Por favor ingresa el capital inicial');
            return;
        }

        foreach ($this->periodos as $periodo) {
            if (empty($periodo['flujo'])) {
                session()->flash('error', 'Por favor completa todos los flujos de caja');
                return;
            }
        }

        // Para calcular VAN necesitamos una tasa
        // Si no hay tasa K, usamos la TIR calculada
        $tasaParaVAN = !empty($this->tasaK) ? floatval($this->tasaK) : null;

        // Calcular TIR siempre
        $tirCalculada = $this->calcularTIR();

        // Si no hay tasa K, usar la TIR para calcular el VAN
        if ($tasaParaVAN === null) {
            $tasaParaVAN = $tirCalculada;
        }

        // Calcular VAN
        $vanCalculado = $this->calcularVPN($tasaParaVAN);

        // Generar tabla de flujos con detalles
        $tablaFlujos = $this->generarTablaFlujos($tasaParaVAN);

        // Guardar ambos resultados
        $this->resultado = [
            'tir' => $tirCalculada,
            'van' => $vanCalculado,
            'tasaUsada' => $tasaParaVAN,
            'tablaFlujos' => $tablaFlujos
        ];

        session()->flash('success', 'Cálculo realizado exitosamente');
    }

    private function generarTablaFlujos($tasa)
    {
        $tasaDecimal = floatval($tasa) / 100;
        $capital = floatval($this->capitalInicial);
        
        $tabla = [];
        $vpAcumulado = -$capital; // Inicia negativo por la inversión
        
        // Período 0 - Inversión inicial
        $tabla[] = [
            'periodo' => 0,
            'flujo' => -$capital,
            'factorDescuento' => 1.0,
            'valorPresente' => -$capital,
            'vpAcumulado' => $vpAcumulado
        ];
        
        // Períodos siguientes
        foreach ($this->periodos as $periodo) {
            $flujo = floatval($periodo['flujo'] ?? 0);
            $n = intval($periodo['periodo']);
            
            if ($n > 0) {
                $factorDescuento = 1 / pow(1 + $tasaDecimal, $n);
                $valorPresente = $flujo * $factorDescuento;
                $vpAcumulado += $valorPresente;
                
                $tabla[] = [
                    'periodo' => $n,
                    'flujo' => $flujo,
                    'factorDescuento' => $factorDescuento,
                    'valorPresente' => $valorPresente,
                    'vpAcumulado' => $vpAcumulado
                ];
            }
        }
        
        // Calcular totales
        $totalFlujos = -$capital;
        $totalVP = 0;
        foreach ($tabla as $fila) {
            $totalFlujos += ($fila['periodo'] > 0) ? $fila['flujo'] : 0;
            $totalVP += $fila['valorPresente'];
        }
        
        return [
            'filas' => $tabla,
            'totales' => [
                'flujos' => $totalFlujos,
                'valorPresente' => $totalVP,
                'vpAcumulado' => $vpAcumulado
            ]
        ];
    }

    public function limpiar()
    {
        $this->reset(['capitalInicial', 'tasaK', 'resultado']);
        $this->periodos = [
            ['periodo' => 1, 'flujo' => ''],
            ['periodo' => 2, 'flujo' => ''],
            ['periodo' => 3, 'flujo' => ''],
        ];
        session()->flash('info', 'Formulario limpiado');
    }

    public function render()
    {
        return view('livewire.tir');
    }
}