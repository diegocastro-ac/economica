<?php

namespace App\Traits;

trait SistemasAmortizacion
{
    // Propiedades comunes
    public ?float $capitalPrestado_A = null;
    public ?float $tasaInteres_A = null;
    public ?int $numeroPeriodos_A = null;

    // Resultados
    public ?float $cuotaFrances = null;
    public ?float $amortizacionAleman = null;
    public ?array $tablaAmortizacion = [];
    public ?string $sistemaActivo = null;

    /**
     * Calcula tabla de amortización sistema FRANCÉS
     * Cuota constante, capital creciente, intereses decrecientes
     */
    public function calcularAmortizacionFrances()
    {
        try {
            // Validar datos obligatorios
            if (is_null($this->capitalPrestado_A) || is_null($this->tasaInteres_A) || is_null($this->numeroPeriodos_A)) {
                session()->flash('error', "Capital prestado, tasa de interés y número de períodos son obligatorios.");
                return;
            }

            $Co = $this->capitalPrestado_A;
            $i = $this->tasaInteres_A / 100;
            $n = $this->numeroPeriodos_A;

            if ($Co <= 0 || $i < 0 || $n <= 0) {
                session()->flash('error', "Los valores deben ser positivos.");
                return;
            }

            // Fórmula: a = Co × [i / (1 - (1+i)^-n)]
            $denominador = 1 - pow(1 + $i, -$n);

            if ($denominador == 0) {
                session()->flash('error', "Error en el cálculo de la cuota.");
                return;
            }

            $this->cuotaFrances = $Co * ($i / $denominador);

            // Generar tabla
            $this->generarTablaFrances($Co, $i, $n);
            $this->sistemaActivo = 'frances';
        } catch (\Exception $e) {
            $this->cuotaFrances = null;
            $this->tablaAmortizacion = [];
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    /**
     * Calcula tabla de amortización sistema ALEMÁN
     * Amortización constante, capital decreciente, cuotas decrecientes
     */
    public function calcularAmortizacionAleman()
    {
        try {
            // Validar datos obligatorios
            if (is_null($this->capitalPrestado_A) || is_null($this->tasaInteres_A) || is_null($this->numeroPeriodos_A)) {
                session()->flash('error', "Capital prestado, tasa de interés y número de períodos son obligatorios.");
                return;
            }

            $Co = $this->capitalPrestado_A;
            $i = $this->tasaInteres_A / 100;
            $n = $this->numeroPeriodos_A;

            if ($Co <= 0 || $i < 0 || $n <= 0) {
                session()->flash('error', "Los valores deben ser positivos.");
                return;
            }

            // Fórmula: A = C / n
            $this->amortizacionAleman = $Co / $n;

            // Generar tabla
            $this->generarTablaAleman($Co, $i, $n);
            $this->sistemaActivo = 'aleman';
        } catch (\Exception $e) {
            $this->amortizacionAleman = null;
            $this->tablaAmortizacion = [];
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    /**
     * Calcula tabla de amortización sistema AMERICANO
     * Pagos de solo interés, capital al final
     */
    public function calcularAmortizacionAmericano()
    {
        try {
            // Validar datos obligatorios
            if (is_null($this->capitalPrestado_A) || is_null($this->tasaInteres_A) || is_null($this->numeroPeriodos_A)) {
                session()->flash('error', "Capital prestado, tasa de interés y número de períodos son obligatorios.");
                return;
            }

            $Co = $this->capitalPrestado_A;
            $i = $this->tasaInteres_A / 100;
            $n = $this->numeroPeriodos_A;

            if ($Co <= 0 || $i < 0 || $n <= 0) {
                session()->flash('error', "Los valores deben ser positivos.");
                return;
            }

            // Generar tabla
            $this->generarTablaAmericano($Co, $i, $n);
            $this->sistemaActivo = 'americano';
        } catch (\Exception $e) {
            $this->tablaAmortizacion = [];
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    // ===== MÉTODOS PRIVADOS - GENERACIÓN DE TABLAS =====

    private function generarTablaFrances($Co, $i, $n)
    {
        $this->tablaAmortizacion = [];
        $capitalPendiente = $Co;
        $cuota = $this->cuotaFrances;
        $totalInteres = 0;
        $totalAmortizacion = 0;

        for ($periodo = 1; $periodo <= $n; $periodo++) {
            // Calcular interés sobre capital pendiente
            $interes = $capitalPendiente * $i;

            // Amortización = Cuota - Interés
            $amortizacion = $cuota - $interes;

            // Reducir capital pendiente
            $capitalPendiente -= $amortizacion;

            // Evitar errores de redondeo en el último período
            if ($periodo == $n) {
                $capitalPendiente = 0;
            }

            $totalInteres += $interes;
            $totalAmortizacion += $amortizacion;

            $this->tablaAmortizacion[] = [
                'periodo' => $periodo,
                'capital_inicial' => $periodo == 1 ? $Co : ($capitalPendiente + $amortizacion),
                'amortizacion' => $amortizacion,
                'interes' => $interes,
                'cuota' => $cuota,
                'capital_pendiente' => $capitalPendiente
            ];
        }

        // Agregar fila de totales
        $this->tablaAmortizacion[] = [
            'periodo' => 'TOTAL',
            'capital_inicial' => null,
            'amortizacion' => $totalAmortizacion,
            'interes' => $totalInteres,
            'cuota' => $totalInteres + $totalAmortizacion,
            'capital_pendiente' => null,
            'es_total' => true
        ];
    }

    private function generarTablaAleman($Co, $i, $n)
    {
        $this->tablaAmortizacion = [];
        $capitalPendiente = $Co;
        $amortizacion = $this->amortizacionAleman;
        $totalInteres = 0;
        $totalCuotas = 0;

        for ($periodo = 1; $periodo <= $n; $periodo++) {
            // Calcular interés sobre capital pendiente
            $interes = $capitalPendiente * $i;

            // Cuota = Amortización + Interés
            $cuota = $amortizacion + $interes;

            // Reducir capital pendiente
            $capitalPendiente -= $amortizacion;

            // Evitar errores de redondeo en el último período
            if ($periodo == $n) {
                $capitalPendiente = 0;
            }

            $totalInteres += $interes;
            $totalCuotas += $cuota;

            $this->tablaAmortizacion[] = [
                'periodo' => $periodo,
                'capital_inicial' => $periodo == 1 ? $Co : ($capitalPendiente + $amortizacion),
                'amortizacion' => $amortizacion,
                'interes' => $interes,
                'cuota' => $cuota,
                'capital_pendiente' => $capitalPendiente
            ];
        }

        // Agregar fila de totales
        $this->tablaAmortizacion[] = [
            'periodo' => 'TOTAL',
            'capital_inicial' => null,
            'amortizacion' => $amortizacion * $n,
            'interes' => $totalInteres,
            'cuota' => $totalCuotas,
            'capital_pendiente' => null,
            'es_total' => true
        ];
    }

    private function generarTablaAmericano($Co, $i, $n)
    {
        $this->tablaAmortizacion = [];

        // Cuota de interés periódico
        $cuotaInteres = $Co * $i;
        $totalInteres = 0;

        for ($periodo = 1; $periodo <= $n; $periodo++) {
            // Períodos 1 a n-1: solo interés
            if ($periodo < $n) {
                $interes = $cuotaInteres;
                $amortizacion = 0;
                $cuota = $interes;
                $capitalPendiente = $Co; // No cambia
            } else {
                // Período n: capital + interés
                $interes = $cuotaInteres;
                $amortizacion = $Co;
                $cuota = $Co + $interes;
                $capitalPendiente = 0;
            }

            $totalInteres += $interes;

            $this->tablaAmortizacion[] = [
                'periodo' => $periodo,
                'capital_inicial' => $Co,
                'amortizacion' => $amortizacion,
                'interes' => $interes,
                'cuota' => $cuota,
                'capital_pendiente' => $capitalPendiente
            ];
        }

        // Agregar fila de totales
        $totalCuotas = ($cuotaInteres * ($n - 1)) + ($Co + $cuotaInteres);

        $this->tablaAmortizacion[] = [
            'periodo' => 'TOTAL',
            'capital_inicial' => null,
            'amortizacion' => $Co,
            'interes' => $totalInteres,
            'cuota' => $totalCuotas,
            'capital_pendiente' => null,
            'es_total' => true
        ];
    }

    /**
     * Obtiene la información de la tabla generada
     */
    public function getTablaAmortizacion()
    {
        return $this->tablaAmortizacion;
    }

    /**
     * Obtiene el resumen de cuotas calculadas
     */
    public function getResumenCuotas()
    {
        $resumen = [];

        if ($this->sistemaActivo === 'frances') {
            $resumen['tipo'] = 'Francés';
            $resumen['cuota_constante'] = $this->cuotaFrances;
            $resumen['descripcion'] = 'Cuota constante durante todos los períodos';
        } elseif ($this->sistemaActivo === 'aleman') {
            $resumen['tipo'] = 'Alemán';
            $resumen['amortizacion_fija'] = $this->amortizacionAleman;
            $resumen['descripcion'] = 'Amortización fija, cuotas decrecientes';

            // Calcular cuota inicial y final
            $i = $this->tasaInteres_A / 100;
            $resumen['cuota_inicial'] = $this->amortizacionAleman + ($this->capitalPrestado_A * $i);
            $resumen['cuota_final'] = $this->amortizacionAleman + ($this->capitalPrestado_A / $this->numeroPeriodos_A * $i);
        } elseif ($this->sistemaActivo === 'americano') {
            $resumen['tipo'] = 'Americano';
            $i = $this->tasaInteres_A / 100;
            $resumen['cuota_periodica'] = $this->capitalPrestado_A * $i;
            $resumen['cuota_final'] = $this->capitalPrestado_A + ($this->capitalPrestado_A * $i);
            $resumen['descripcion'] = 'Solo intereses hasta el período final, luego capital + interés';
        }

        return $resumen;
    }

    /**
     * Obtiene estadísticas de la amortización
     */
    public function getEstadisticasAmortizacion()
    {
        if (empty($this->tablaAmortizacion)) {
            return null;
        }

        $filaTotal = end($this->tablaAmortizacion);

        return [
            'capital_total' => $this->capitalPrestado_A,
            'interes_total' => $filaTotal['interes'] ?? 0,
            'cuota_total' => $filaTotal['cuota'] ?? 0,
            'porcentaje_interes' => (($filaTotal['interes'] ?? 0) / $this->capitalPrestado_A) * 100,
            'tasa_efectiva' => $this->tasaInteres_A
        ];
    }
}
