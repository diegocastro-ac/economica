<?php

namespace App\Traits;

trait Gradientes
{
    // Propiedades específicas de Gradientes
    public ?float $valorPresente_G = null;
    public ?float $valorFuturo_G = null;
    public ?float $pagoBase_G = null;
    public ?float $gradiente_G = null;
    public ?float $tasaInteres_G = null;
    public ?float $numeroPeriodos_G = null;
    public ?float $result = null;

    // Tolerancia para considerar G = i en gradientes geométricos
    private float $toleranciaIgualdad = 0.0001;

    // Parámetros para métodos numéricos
    private int $maxIteraciones = 1000;
    private float $toleranciaConvergencia = 0.000001;

    public function calcularGradientes()
    {
        try {
            $camposVacios = $this->detectarCamposVaciosGradientes();

            if (count($camposVacios) != 1) {
                session()->flash('error', "Debe dejar exactamente UN campo vacío. Campos vacíos encontrados: " . count($camposVacios));
                return;
            }

            $campoACalcular = $camposVacios[0];

            // Convertir tasa de interés a decimal si es necesario
            $tasaInteres = $this->tasaInteres_G ? $this->tasaInteres_G / 100 : null;

            // Convertir gradiente a decimal para geométricos si es necesario
            $gradiente = $this->gradiente_G;
            if ($this->esGradienteGeometrico() && $gradiente !== null) {
                $gradiente = $gradiente / 100;
            }

            // Calcular según la fórmula seleccionada y el campo vacío
            $this->ejecutarCalculo($campoACalcular, $tasaInteres, $gradiente);
        } catch (\Exception $e) {
            $this->result = null;
            session()->flash('error', "Error en el cálculo: " . $e->getMessage());
        }
    }

    private function detectarCamposVaciosGradientes()
    {
        $camposVacios = [];

        if (is_null($this->valorPresente_G) || $this->valorPresente_G === '') {
            if ($this->esFormulaValorPresente()) {
                $camposVacios[] = 'valorPresente_G';
            }
        }

        if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '') {
            if ($this->esFormulaValorFuturo()) {
                $camposVacios[] = 'valorFuturo_G';
            }
        }

        if (is_null($this->pagoBase_G) || $this->pagoBase_G === '') {
            $camposVacios[] = 'pagoBase_G';
        }

        if (is_null($this->gradiente_G) || $this->gradiente_G === '') {
            $camposVacios[] = 'gradiente_G';
        }

        if (is_null($this->tasaInteres_G) || $this->tasaInteres_G === '') {
            $camposVacios[] = 'tasaInteres_G';
        }

        if (is_null($this->numeroPeriodos_G) || $this->numeroPeriodos_G === '') {
            $camposVacios[] = 'numeroPeriodos_G';
        }

        return $camposVacios;
    }

    private function ejecutarCalculo($campoACalcular, $tasaInteres, $gradiente)
    {
        switch ($campoACalcular) {
            case 'valorPresente_G':
                $this->calcularValorPresente($tasaInteres, $gradiente);
                break;
            case 'valorFuturo_G':
                $this->calcularValorFuturo($tasaInteres, $gradiente);
                break;
            case 'pagoBase_G':
                $this->calcularPagoBase($tasaInteres, $gradiente);
                break;
            case 'gradiente_G':
                $this->calcularGradiente($tasaInteres);
                break;
            case 'tasaInteres_G':
                $this->calcularTasaInteres($gradiente);
                break;
            case 'numeroPeriodos_G':
                $this->calcularNumeroPeriodos($tasaInteres, $gradiente);
                break;
        }
    }

    // ==================== CÁLCULO DE VALOR PRESENTE ====================

    private function calcularValorPresente($i, $g)
    {
        $A = $this->pagoBase_G;
        $n = $this->numeroPeriodos_G;

        if ($this->esGradienteAritmetico()) {
            // Gradiente Aritmético
            $factor1 = (1 - pow(1 + $i, -$n)) / $i;
            $factor2 = ((1 - pow(1 + $i, -$n)) / $i) - ($n / pow(1 + $i, $n));

            $P = ($A * $factor1) + (($g / $i) * $factor2);

            if ($this->esAnticipado()) {
                $P = $P * (1 + $i);
            }

            $this->result = $P;
        } else {
            // Gradiente Geométrico
            if ($this->esGIgualI($g, $i)) {
                // Caso G = i
                $P = ($n * $A) / (1 + $i);

                if ($this->esAnticipado()) {
                    $P = $n * $A;
                }
            } else {
                // Caso G ≠ i
                $numerador = pow(1 + $g, $n) * pow(1 + $i, -$n) - 1;
                $P = $A * ($numerador / ($g - $i));

                if ($this->esAnticipado()) {
                    $P = $P * (1 + $i);
                }
            }

            $this->result = $P;
        }
    }

    // ==================== CÁLCULO DE VALOR FUTURO ====================

    private function calcularValorFuturo($i, $g)
    {
        $A = $this->pagoBase_G;
        $n = $this->numeroPeriodos_G;

        if ($this->esGradienteAritmetico()) {
            // Gradiente Aritmético
            $factor1 = (pow(1 + $i, $n) - 1) / $i;
            $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;

            $F = ($A * $factor1) + (($g / $i) * $factor2);

            if ($this->esAnticipado()) {
                $F = $F * (1 + $i);
            }

            $this->result = $F;
        } else {
            // Gradiente Geométrico
            if ($this->esGIgualI($g, $i)) {
                // Caso G = i
                $F = ($n * $A * pow(1 + $i, $n)) / (1 + $i);

                if ($this->esAnticipado()) {
                    $F = $n * $A * pow(1 + $i, $n);
                }
            } else {
                // Caso G ≠ i
                $numerador = pow(1 + $g, $n) - pow(1 + $i, $n);
                $F = $A * ($numerador / ($g - $i));

                if ($this->esAnticipado()) {
                    $F = $F * (1 + $i);
                }
            }

            $this->result = $F;
        }
    }

    // ==================== CÁLCULO DE PAGO BASE (A) ====================

    private function calcularPagoBase($i, $g)
    {
        $n = $this->numeroPeriodos_G;
        $valorObjetivo = $this->esFormulaValorPresente() ? $this->valorPresente_G : $this->valorFuturo_G;

        // Ajustar valor si es anticipado
        if ($this->esAnticipado()) {
            $valorObjetivo = $valorObjetivo / (1 + $i);
        }

        if ($this->esGradienteAritmetico()) {
            // Gradiente Aritmético
            if ($this->esFormulaValorPresente()) {
                $factor1 = (1 - pow(1 + $i, -$n)) / $i;
                $factor2 = ((1 - pow(1 + $i, -$n)) / $i) - ($n / pow(1 + $i, $n));
            } else {
                $factor1 = (pow(1 + $i, $n) - 1) / $i;
                $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;
            }

            // Despeje: A = (Valor - (G/i) * factor2) / factor1
            $A = ($valorObjetivo - (($g / $i) * $factor2)) / $factor1;

            $this->result = $A;
        } else {
            // Gradiente Geométrico
            if ($this->esGIgualI($g, $i)) {
                // Caso G = i
                if ($this->esFormulaValorPresente()) {
                    $A = $valorObjetivo * (1 + $i) / $n;
                } else {
                    $A = $valorObjetivo * (1 + $i) / ($n * pow(1 + $i, $n));
                }
            } else {
                // Caso G ≠ i
                if ($this->esFormulaValorPresente()) {
                    $numerador = pow(1 + $g, $n) * pow(1 + $i, -$n) - 1;
                } else {
                    $numerador = pow(1 + $g, $n) - pow(1 + $i, $n);
                }

                $A = $valorObjetivo * ($g - $i) / $numerador;
            }

            $this->result = $A;
        }
    }

    // ==================== CÁLCULO DE GRADIENTE (G) ====================

    private function calcularGradiente($i)
    {
        $A = $this->pagoBase_G;
        $n = $this->numeroPeriodos_G;
        $valorObjetivo = $this->esFormulaValorPresente() ? $this->valorPresente_G : $this->valorFuturo_G;

        // Ajustar valor si es anticipado
        if ($this->esAnticipado()) {
            $valorObjetivo = $valorObjetivo / (1 + $i);
        }

        if ($this->esGradienteAritmetico()) {
            // Gradiente Aritmético - Despeje algebraico posible
            if ($this->esFormulaValorPresente()) {
                $factor1 = (1 - pow(1 + $i, -$n)) / $i;
                $factor2 = ((1 - pow(1 + $i, -$n)) / $i) - ($n / pow(1 + $i, $n));
            } else {
                $factor1 = (pow(1 + $i, $n) - 1) / $i;
                $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;
            }

            // Despeje: G = i * (Valor - A * factor1) / factor2
            if (abs($factor2) < 0.000001) {
                throw new \InvalidArgumentException("No se puede calcular el gradiente con estos parámetros (división por cero).");
            }

            $G = ($i * ($valorObjetivo - ($A * $factor1))) / $factor2;

            $this->result = $G;
        } else {
            // Gradiente Geométrico - Requiere método numérico
            $this->result = $this->calcularGradienteGeometricoNumerico($i, $A, $n, $valorObjetivo);

            // Convertir a porcentaje
            if ($this->result !== null) {
                $this->result = $this->result * 100;
            }
        }
    }

    // ==================== CÁLCULO DE TASA DE INTERÉS (i) ====================

    private function calcularTasaInteres($g)
    {
        $A = $this->pagoBase_G;
        $n = $this->numeroPeriodos_G;
        $valorObjetivo = $this->esFormulaValorPresente() ? $this->valorPresente_G : $this->valorFuturo_G;

        // Para ambos tipos de gradiente, se requiere método numérico
        $tasaDecimal = $this->calcularTasaInteresNumerica($g, $A, $n, $valorObjetivo);

        if ($tasaDecimal !== null) {
            $this->result = $tasaDecimal * 100; // Convertir a porcentaje
        }
    }

    // ==================== CÁLCULO DE NÚMERO DE PERÍODOS (n) ====================

    private function calcularNumeroPeriodos($i, $g)
    {
        $A = $this->pagoBase_G;
        $valorObjetivo = $this->esFormulaValorPresente() ? $this->valorPresente_G : $this->valorFuturo_G;

        // Ajustar valor si es anticipado
        if ($this->esAnticipado()) {
            $valorObjetivo = $valorObjetivo / (1 + $i);
        }

        if ($this->esGradienteGeometrico() && $this->esGIgualI($g, $i) && $this->esFormulaValorPresente()) {
            // Único caso con despeje algebraico directo: VP geométrico con G = i
            // Fórmula: P = (n * A) / (1 + i)
            // Despeje: n = P * (1 + i) / A
            $n = $valorObjetivo * (1 + $i) / $A;

            if ($n < 1) {
                throw new \InvalidArgumentException("El número de períodos debe ser al menos 1.");
            }

            $this->result = round($n, 2);
        } else {
            // Para todos los demás casos, usar método numérico
            $this->result = $this->calcularNumeroPeriodosNumerico($i, $g, $A, $valorObjetivo);
        }
    }

    // ==================== MÉTODOS NUMÉRICOS ====================

    private function calcularGradienteGeometricoNumerico($i, $A, $n, $valorObjetivo)
    {
        // Método de Newton-Raphson para encontrar G
        $g = 0.05; // Valor inicial 5%

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            // Evitar caso G = i
            if (abs($g - $i) < $this->toleranciaIgualdad) {
                $g = $i + 0.01;
            }

            // Calcular f(g) - la diferencia entre valor calculado y objetivo
            if ($this->esFormulaValorPresente()) {
                $numerador = pow(1 + $g, $n) * pow(1 + $i, -$n) - 1;
                $valorCalculado = $A * ($numerador / ($g - $i));
            } else {
                $numerador = pow(1 + $g, $n) - pow(1 + $i, $n);
                $valorCalculado = $A * ($numerador / ($g - $i));
            }

            $f = $valorCalculado - $valorObjetivo;

            // Verificar convergencia
            if (abs($f) < $this->toleranciaConvergencia) {
                return $g;
            }

            // Calcular derivada numérica
            $h = 0.0001;
            $gMasH = $g + $h;

            if ($this->esFormulaValorPresente()) {
                $numeradorDerivada = pow(1 + $gMasH, $n) * pow(1 + $i, -$n) - 1;
                $valorDerivada = $A * ($numeradorDerivada / ($gMasH - $i));
            } else {
                $numeradorDerivada = pow(1 + $gMasH, $n) - pow(1 + $i, $n);
                $valorDerivada = $A * ($numeradorDerivada / ($gMasH - $i));
            }

            $fPrima = ($valorDerivada - $valorCalculado) / $h;

            if (abs($fPrima) < 0.000001) {
                // Derivada muy pequeña, cambiar a bisección
                return $this->calcularGradienteGeometricoBiseccion($i, $A, $n, $valorObjetivo);
            }

            // Actualizar g
            $gNuevo = $g - $f / $fPrima;

            // Limitar cambios bruscos
            if (abs($gNuevo - $g) > 0.5) {
                $gNuevo = $g + 0.5 * ($gNuevo - $g) / abs($gNuevo - $g);
            }

            $g = $gNuevo;
        }

        // Si no converge, intentar con bisección
        return $this->calcularGradienteGeometricoBiseccion($i, $A, $n, $valorObjetivo);
    }

    private function calcularGradienteGeometricoBiseccion($i, $A, $n, $valorObjetivo)
    {
        $gMin = -0.99; // -99%
        $gMax = 2.0;   // 200%

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            $gMedio = ($gMin + $gMax) / 2;

            // Evitar G = i
            if (abs($gMedio - $i) < $this->toleranciaIgualdad) {
                $gMedio = $i + 0.01;
            }

            if ($this->esFormulaValorPresente()) {
                $numerador = pow(1 + $gMedio, $n) * pow(1 + $i, -$n) - 1;
                $valorCalculado = $A * ($numerador / ($gMedio - $i));
            } else {
                $numerador = pow(1 + $gMedio, $n) - pow(1 + $i, $n);
                $valorCalculado = $A * ($numerador / ($gMedio - $i));
            }

            $diferencia = $valorCalculado - $valorObjetivo;

            if (abs($diferencia) < $this->toleranciaConvergencia || abs($gMax - $gMin) < $this->toleranciaConvergencia) {
                return $gMedio;
            }

            if ($diferencia > 0) {
                $gMax = $gMedio;
            } else {
                $gMin = $gMedio;
            }
        }

        throw new \InvalidArgumentException("No se pudo calcular el gradiente geométrico. Verifique los datos ingresados.");
    }

    private function calcularTasaInteresNumerica($g, $A, $n, $valorObjetivo)
    {
        // Ajustar valor si es anticipado
        $valorAjustado = $valorObjetivo;

        // Método de Newton-Raphson
        $i = 0.05; // Valor inicial 5%

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            // Calcular valor con i actual
            $valorCalculado = $this->calcularValorConTasa($i, $g, $A, $n);

            // Ajustar por anticipado
            if ($this->esAnticipado()) {
                $valorCalculado = $valorCalculado * (1 + $i);
            }

            $f = $valorCalculado - $valorAjustado;

            if (abs($f) < $this->toleranciaConvergencia) {
                return $i;
            }

            // Derivada numérica
            $h = 0.0001;
            $valorDerivada = $this->calcularValorConTasa($i + $h, $g, $A, $n);

            if ($this->esAnticipado()) {
                $valorDerivada = $valorDerivada * (1 + $i + $h);
            }

            $fPrima = ($valorDerivada - $valorCalculado) / $h;

            if (abs($fPrima) < 0.000001) {
                return $this->calcularTasaInteresBiseccion($g, $A, $n, $valorObjetivo);
            }

            $iNuevo = $i - $f / $fPrima;

            // Limitar a valores positivos razonables
            if ($iNuevo < 0.0001) $iNuevo = 0.0001;
            if ($iNuevo > 5) $iNuevo = 5;

            $i = $iNuevo;
        }

        return $this->calcularTasaInteresBiseccion($g, $A, $n, $valorObjetivo);
    }

    private function calcularTasaInteresBiseccion($g, $A, $n, $valorObjetivo)
    {
        $iMin = 0.0001;
        $iMax = 2.0;

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            $iMedio = ($iMin + $iMax) / 2;

            $valorCalculado = $this->calcularValorConTasa($iMedio, $g, $A, $n);

            if ($this->esAnticipado()) {
                $valorCalculado = $valorCalculado * (1 + $iMedio);
            }

            $diferencia = $valorCalculado - $valorObjetivo;

            if (abs($diferencia) < $this->toleranciaConvergencia || abs($iMax - $iMin) < $this->toleranciaConvergencia) {
                return $iMedio;
            }

            if ($diferencia > 0) {
                $iMax = $iMedio;
            } else {
                $iMin = $iMedio;
            }
        }

        throw new \InvalidArgumentException("No se pudo calcular la tasa de interés. Verifique los datos ingresados.");
    }

    private function calcularNumeroPeriodosNumerico($i, $g, $A, $valorObjetivo)
    {
        // Newton-Raphson para encontrar n
        $n = 10.0; // Valor inicial

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            $valorCalculado = $this->calcularValorConPeriodos($n, $i, $g, $A);

            $f = $valorCalculado - $valorObjetivo;

            if (abs($f) < $this->toleranciaConvergencia) {
                return max(1, round($n, 2)); // Asegurar n positivo
            }

            // Derivada numérica
            $h = 0.01;
            $valorDerivada = $this->calcularValorConPeriodos($n + $h, $i, $g, $A);
            $fPrima = ($valorDerivada - $valorCalculado) / $h;

            if (abs($fPrima) < 0.000001) {
                return $this->calcularNumeroPeriodosBiseccion($i, $g, $A, $valorObjetivo);
            }

            $nNuevo = $n - $f / $fPrima;

            if ($nNuevo < 1) $nNuevo = 1;
            if ($nNuevo > 1000) $nNuevo = 1000;

            $n = $nNuevo;
        }

        return $this->calcularNumeroPeriodosBiseccion($i, $g, $A, $valorObjetivo);
    }

    private function calcularNumeroPeriodosBiseccion($i, $g, $A, $valorObjetivo)
    {
        $nMin = 1;
        $nMax = 1000;

        for ($iter = 0; $iter < $this->maxIteraciones; $iter++) {
            $nMedio = ($nMin + $nMax) / 2;

            $valorCalculado = $this->calcularValorConPeriodos($nMedio, $i, $g, $A);

            $diferencia = $valorCalculado - $valorObjetivo;

            if (abs($diferencia) < $this->toleranciaConvergencia || abs($nMax - $nMin) < 0.01) {
                return round($nMedio, 2);
            }

            if ($diferencia > 0) {
                $nMax = $nMedio;
            } else {
                $nMin = $nMedio;
            }
        }

        throw new \InvalidArgumentException("No se pudo calcular el número de períodos. Verifique los datos ingresados.");
    }

    // ==================== FUNCIONES AUXILIARES PARA MÉTODOS NUMÉRICOS ====================

    private function calcularValorConTasa($i, $g, $A, $n)
    {
        if ($this->esGradienteAritmetico()) {
            if ($this->esFormulaValorPresente()) {
                $factor1 = (1 - pow(1 + $i, -$n)) / $i;
                $factor2 = ((1 - pow(1 + $i, -$n)) / $i) - ($n / pow(1 + $i, $n));
                return ($A * $factor1) + (($g / $i) * $factor2);
            } else {
                $factor1 = (pow(1 + $i, $n) - 1) / $i;
                $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;
                return ($A * $factor1) + (($g / $i) * $factor2);
            }
        } else {
            if ($this->esGIgualI($g, $i)) {
                if ($this->esFormulaValorPresente()) {
                    return ($n * $A) / (1 + $i);
                } else {
                    return ($n * $A * pow(1 + $i, $n)) / (1 + $i);
                }
            } else {
                if ($this->esFormulaValorPresente()) {
                    $numerador = pow(1 + $g, $n) * pow(1 + $i, -$n) - 1;
                    return $A * ($numerador / ($g - $i));
                } else {
                    $numerador = pow(1 + $g, $n) - pow(1 + $i, $n);
                    return $A * ($numerador / ($g - $i));
                }
            }
        }
    }

    private function calcularValorConPeriodos($n, $i, $g, $A)
    {
        if ($this->esGradienteAritmetico()) {
            if ($this->esFormulaValorPresente()) {
                $factor1 = (1 - pow(1 + $i, -$n)) / $i;
                $factor2 = ((1 - pow(1 + $i, -$n)) / $i) - ($n / pow(1 + $i, $n));
                return ($A * $factor1) + (($g / $i) * $factor2);
            } else {
                $factor1 = (pow(1 + $i, $n) - 1) / $i;
                $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;
                return ($A * $factor1) + (($g / $i) * $factor2);
            }
        } else {
            if ($this->esGIgualI($g, $i)) {
                if ($this->esFormulaValorPresente()) {
                    return ($n * $A) / (1 + $i);
                } else {
                    return ($n * $A * pow(1 + $i, $n)) / (1 + $i);
                }
            } else {
                if ($this->esFormulaValorPresente()) {
                    $numerador = pow(1 + $g, $n) * pow(1 + $i, -$n) - 1;
                    return $A * ($numerador / ($g - $i));
                } else {
                    $numerador = pow(1 + $g, $n) - pow(1 + $i, $n);
                    return $A * ($numerador / ($g - $i));
                }
            }
        }
    }

    // ==================== MÉTODOS DE UTILIDAD ====================

    private function esGradienteAritmetico()
    {
        return str_contains($this->formulaSeleccionada, 'aritmetico');
    }

    private function esGradienteGeometrico()
    {
        return str_contains($this->formulaSeleccionada, 'geometrico');
    }

    private function esFormulaValorPresente()
    {
        return str_contains($this->formulaSeleccionada, 'vp');
    }

    private function esFormulaValorFuturo()
    {
        return str_contains($this->formulaSeleccionada, 'vf');
    }

    private function esAnticipado()
    {
        return str_contains($this->formulaSeleccionada, 'anticipado');
    }

    private function esGIgualI($g, $i)
    {
        return abs($g - $i) < $this->toleranciaIgualdad;
    }
}
