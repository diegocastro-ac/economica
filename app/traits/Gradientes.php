<?php

namespace App\traits;

trait Gradientes
{
    // Propiedades comunes
    public ?float $valorPresente_G = null;
    public ?float $valorFuturo_G = null;
    public ?float $tasaInteres_G = null;
    public ?int $numeroPeriodos_G = null;

    // Propiedades específicas de Gradiente Aritmético
    public ?float $pagoBase_A = null;
    public ?float $gradienteAritmetico_A = null;

    // Propiedades específicas de Gradiente Geométrico
    public ?float $pagoInicial_Geo = null;
    public ?float $tasaCrecimiento_Geo = null;

    public ?float $result = null;
    public ?float $resultVP = null; // Para cuando se calculan VP y VF simultáneamente
    public ?float $resultVF = null; // Para cuando se calculan VP y VF simultáneamente

    /**
     * Calcula gradiente aritmético
     */
    public function calcularGradienteAritmetico($esAnticipado = false)
    {
        try {
            $camposVacios = $this->detectarCamposVaciosAritmetico();

            // Validar: permitir 1 o 2 campos vacíos (solo si son VP y VF)
            if (count($camposVacios) == 2) {
                // Verificar que los dos campos vacíos sean VP y VF
                if (!in_array('valorPresente_G', $camposVacios) || !in_array('valorFuturo_G', $camposVacios)) {
                    session()->flash('error', "Si deja dos campos vacíos, deben ser Valor Presente y Valor Futuro.");
                    return;
                }
                // Calcular ambos
                $this->calcularVPyVFAritmetico($esAnticipado);
                return;
            }

            if (count($camposVacios) != 1) {
                session()->flash('error', "Debe dejar UN campo vacío o dejar vacíos VP y VF para calcular ambos. Campos vacíos encontrados: " . count($camposVacios));
                return;
            }

            $campoACalcular = $camposVacios[0];

            // Validaciones básicas
            if (is_null($this->tasaInteres_G) || is_null($this->numeroPeriodos_G)) {
                session()->flash('error', "La tasa de interés y el número de períodos son obligatorios.");
                return;
            }

            // Convertir tasa a decimal
            $i = $this->tasaInteres_G / 100;
            $n = $this->numeroPeriodos_G;

            // Calcular según el campo vacío
            switch ($campoACalcular) {
                case 'valorPresente_G':
                    $this->calcularVPAritmetico($i, $n, $esAnticipado);
                    break;

                case 'valorFuturo_G':
                    $this->calcularVFAritmetico($i, $n, $esAnticipado);
                    break;

                case 'pagoBase_A':
                    $this->calcularPagoBaseAritmetico($i, $n, $esAnticipado);
                    break;

                case 'gradienteAritmetico_A':
                    $this->calcularGradienteA($i, $n, $esAnticipado);
                    break;
            }
        } catch (\Exception $e) {
            $this->result = null;
            $this->resultVP = null;
            $this->resultVF = null;
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    /**
     * Calcula gradiente geométrico
     */
    public function calcularGradienteGeometrico($esAnticipado = false)
    {
        try {
            $camposVacios = $this->detectarCamposVaciosGeometrico();

            // Validar: permitir 1 o 2 campos vacíos (solo si son VP y VF)
            if (count($camposVacios) == 2) {
                // Verificar que los dos campos vacíos sean VP y VF
                if (!in_array('valorPresente_G', $camposVacios) || !in_array('valorFuturo_G', $camposVacios)) {
                    session()->flash('error', "Si deja dos campos vacíos, deben ser Valor Presente y Valor Futuro.");
                    return;
                }
                // Calcular ambos
                $this->calcularVPyVFGeometrico($esAnticipado);
                return;
            }

            if (count($camposVacios) != 1) {
                session()->flash('error', "Debe dejar UN campo vacío o dejar vacíos VP y VF para calcular ambos. Campos vacíos encontrados: " . count($camposVacios));
                return;
            }

            $campoACalcular = $camposVacios[0];

            // Validaciones básicas
            if (is_null($this->tasaInteres_G) || is_null($this->numeroPeriodos_G)) {
                session()->flash('error', "La tasa de interés y el número de períodos son obligatorios.");
                return;
            }

            // Convertir tasas a decimal
            $i = $this->tasaInteres_G / 100;
            $g = $this->tasaCrecimiento_Geo ? $this->tasaCrecimiento_Geo / 100 : null;
            $n = $this->numeroPeriodos_G;

            // Calcular según el campo vacío
            switch ($campoACalcular) {
                case 'valorPresente_G':
                    $this->calcularVPGeometrico($i, $g, $n, $esAnticipado);
                    break;

                case 'valorFuturo_G':
                    $this->calcularVFGeometrico($i, $g, $n, $esAnticipado);
                    break;

                case 'pagoInicial_Geo':
                    $this->calcularPagoInicialGeometrico($i, $g, $n, $esAnticipado);
                    break;

                case 'tasaCrecimiento_Geo':
                    $this->calcularTasaCrecimiento($i, $n, $esAnticipado);
                    break;
            }
        } catch (\Exception $e) {
            $this->result = null;
            $this->resultVP = null;
            $this->resultVF = null;
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    // ===== MÉTODOS PRIVADOS - GRADIENTE ARITMÉTICO =====

    private function detectarCamposVaciosAritmetico()
    {
        $camposVacios = [];

        if (is_null($this->valorPresente_G) || $this->valorPresente_G === '')
            $camposVacios[] = 'valorPresente_G';
        if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '')
            $camposVacios[] = 'valorFuturo_G';
        if (is_null($this->pagoBase_A) || $this->pagoBase_A === '')
            $camposVacios[] = 'pagoBase_A';
        if (is_null($this->gradienteAritmetico_A) || $this->gradienteAritmetico_A === '')
            $camposVacios[] = 'gradienteAritmetico_A';

        return $camposVacios;
    }

    private function calcularVPyVFAritmetico($esAnticipado)
    {
        if (is_null($this->pagoBase_A) || is_null($this->gradienteAritmetico_A)) {
            session()->flash('error', "Se requiere el pago base y el gradiente aritmético.");
            return;
        }

        $i = $this->tasaInteres_G / 100;
        $n = $this->numeroPeriodos_G;

        if ($i == 0) {
            session()->flash('error', "La tasa de interés debe ser mayor a cero.");
            return;
        }

        $A = $this->pagoBase_A;
        $G = $this->gradienteAritmetico_A;

        // Calcular VP vencido
        $factor1 = (pow(1 + $i, $n) - 1) / ($i * pow(1 + $i, $n));
        $factor2 = (pow(1 + $i, $n) - $i * $n - 1) / (pow($i, 2) * pow(1 + $i, $n));
        $vpVencido = $A * $factor1 + $G * $factor2;

        // Si es anticipado, multiplicar por (1+i)
        $vp = $esAnticipado ? $vpVencido * (1 + $i) : $vpVencido;

        // Calcular VF
        $vf = $vp * pow(1 + $i, $n);

        $this->resultVP = $vp;
        $this->resultVF = $vf;
    }

    private function calcularVPAritmetico($i, $n, $esAnticipado)
    {
        // P = A[(1-(1+i)^-n)/i] + (G/i)[(1-(1+i)^-n)/i - n/(1+i)^n]

        if (is_null($this->pagoBase_A) || is_null($this->gradienteAritmetico_A)) {
            session()->flash('error', "Se requiere el pago base y el gradiente aritmético.");
            return;
        }

        if ($i == 0) {
            session()->flash('error', "La tasa de interés debe ser mayor a cero.");
            return;
        }

        $A = $this->pagoBase_A;
        $G = $this->gradienteAritmetico_A;

        $factor1 = (pow(1 + $i, $n) - 1) / ($i * pow(1 + $i, $n));
        $factor2 = (pow(1 + $i, $n) - $i * $n - 1) / (pow($i, 2) * pow(1 + $i, $n));

        $vpVencido = $A * $factor1 + $G * $factor2;

        // Si es anticipado: P = [VP_vencido] * (1+i)
        $this->result = $esAnticipado ? $vpVencido * (1 + $i) : $vpVencido;
    }

    private function calcularVFAritmetico($i, $n, $esAnticipado)
    {
        // F = A[(1+i)^n - 1]/i + (G/i)[((1+i)^n - 1)/i - n]

        if (is_null($this->pagoBase_A) || is_null($this->gradienteAritmetico_A)) {
            session()->flash('error', "Se requiere el pago base y el gradiente aritmético.");
            return;
        }

        if ($i == 0) {
            session()->flash('error', "La tasa de interés debe ser mayor a cero.");
            return;
        }

        $A = $this->pagoBase_A;
        $G = $this->gradienteAritmetico_A;

        $factor1 = (pow(1 + $i, $n) - 1) / $i;
        $factor2 = ((pow(1 + $i, $n) - 1) / $i) - $n;

        $vfVencido = $A * $factor1 + ($G / $i) * $factor2;

        // Si es anticipado: F = [VF_vencido] * (1+i)
        $this->result = $esAnticipado ? $vfVencido * (1 + $i) : $vfVencido;
    }

    private function calcularPagoBaseAritmetico($i, $n, $esAnticipado)
    {
        // A = (VP - G*factor2) / factor1

        if (is_null($this->valorPresente_G) || is_null($this->gradienteAritmetico_A)) {
            session()->flash('error', "Se requiere el valor presente y el gradiente aritmético.");
            return;
        }

        if ($i == 0) {
            session()->flash('error', "La tasa de interés debe ser mayor a cero.");
            return;
        }

        $VP = $this->valorPresente_G;
        $G = $this->gradienteAritmetico_A;

        // Si es anticipado, convertir a vencido
        $vpVencido = $esAnticipado ? $VP / (1 + $i) : $VP;

        $factor1 = (pow(1 + $i, $n) - 1) / ($i * pow(1 + $i, $n));
        $factor2 = (pow(1 + $i, $n) - $i * $n - 1) / (pow($i, 2) * pow(1 + $i, $n));

        if ($factor1 == 0) {
            session()->flash('error', "Error en el cálculo del factor de anualidad.");
            return;
        }

        $this->result = ($vpVencido - $G * $factor2) / $factor1;
    }

    private function calcularGradienteA($i, $n, $esAnticipado)
    {
        // G = (VP - A*factor1) / factor2

        if (is_null($this->valorPresente_G) || is_null($this->pagoBase_A)) {
            session()->flash('error', "Se requiere el valor presente y el pago base.");
            return;
        }

        if ($i == 0) {
            session()->flash('error', "La tasa de interés debe ser mayor a cero.");
            return;
        }

        $VP = $this->valorPresente_G;
        $A = $this->pagoBase_A;

        // Si es anticipado, convertir a vencido
        $vpVencido = $esAnticipado ? $VP / (1 + $i) : $VP;

        $factor1 = (pow(1 + $i, $n) - 1) / ($i * pow(1 + $i, $n));
        $factor2 = (pow(1 + $i, $n) - $i * $n - 1) / (pow($i, 2) * pow(1 + $i, $n));

        if ($factor2 == 0) {
            session()->flash('error', "Error en el cálculo del factor de gradiente.");
            return;
        }

        $this->result = ($vpVencido - $A * $factor1) / $factor2;
    }

    // ===== MÉTODOS PRIVADOS - GRADIENTE GEOMÉTRICO =====

    private function detectarCamposVaciosGeometrico()
    {
        $camposVacios = [];

        if (is_null($this->valorPresente_G) || $this->valorPresente_G === '')
            $camposVacios[] = 'valorPresente_G';
        if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '')
            $camposVacios[] = 'valorFuturo_G';
        if (is_null($this->pagoInicial_Geo) || $this->pagoInicial_Geo === '')
            $camposVacios[] = 'pagoInicial_Geo';
        if (is_null($this->tasaCrecimiento_Geo) || $this->tasaCrecimiento_Geo === '')
            $camposVacios[] = 'tasaCrecimiento_Geo';

        return $camposVacios;
    }

    private function calcularVPyVFGeometrico($esAnticipado)
    {
        if (is_null($this->pagoInicial_Geo) || is_null($this->tasaCrecimiento_Geo)) {
            session()->flash('error', "Se requiere el pago inicial y la tasa de crecimiento.");
            return;
        }

        $i = $this->tasaInteres_G / 100;
        $g = $this->tasaCrecimiento_Geo / 100;
        $n = $this->numeroPeriodos_G;
        $A = $this->pagoInicial_Geo;

        // Calcular VP vencido
        if (abs($i - $g) < 0.0000001) {
            // Caso especial: i = g
            $vpVencido = ($n * $A) / (1 + $i);
        } else {
            // Caso general: P = A[(1+G)^n(1+i)^-n - 1] / (G-i)
            $vpVencido = $A * (1 - pow((1 + $g) / (1 + $i), $n)) / ($i - $g);
        }

        // Si es anticipado: P = [VP_vencido] * (1+i)
        $vp = $esAnticipado ? $vpVencido * (1 + $i) : $vpVencido;

        // Calcular VF
        $vf = $vp * pow(1 + $i, $n);

        $this->resultVP = $vp;
        $this->resultVF = $vf;
    }

    private function calcularVPGeometrico($i, $g, $n, $esAnticipado)
    {
        if (is_null($this->pagoInicial_Geo) || is_null($g)) {
            session()->flash('error', "Se requiere el pago inicial y la tasa de crecimiento.");
            return;
        }

        $A = $this->pagoInicial_Geo;

        // Caso especial: i = g (vencido)
        if (abs($i - $g) < 0.0000001) {
            $vpVencido = ($n * $A) / (1 + $i);
        } else {
            // Caso general: P = A[1 - ((1+g)/(1+i))^n] / (i - g)
            $vpVencido = $A * (1 - pow((1 + $g) / (1 + $i), $n)) / ($i - $g);
        }

        // Si es anticipado: multiplicar por (1+i)
        $this->result = $esAnticipado ? $vpVencido * (1 + $i) : $vpVencido;
    }

    private function calcularVFGeometrico($i, $g, $n, $esAnticipado)
    {
        if (is_null($this->pagoInicial_Geo) || is_null($g)) {
            session()->flash('error', "Se requiere el pago inicial y la tasa de crecimiento.");
            return;
        }

        $A = $this->pagoInicial_Geo;

        // Caso especial: i = g (vencido)
        if (abs($i - $g) < 0.0000001) {
            $vfVencido = ($n * $A * pow(1 + $i, $n)) / (1 + $i);
        } else {
            // Caso general: F = A[(1+G)^n - (1+i)^n] / (G-i)
            $vfVencido = $A * (pow(1 + $g, $n) - pow(1 + $i, $n)) / ($g - $i);
        }

        // Si es anticipado: F = [VF_vencido] * (1+i)
        $this->result = $esAnticipado ? $vfVencido * (1 + $i) : $vfVencido;
    }

    private function calcularPagoInicialGeometrico($i, $g, $n, $esAnticipado)
    {
        if (is_null($this->valorPresente_G) || is_null($g)) {
            session()->flash('error', "Se requiere el valor presente y la tasa de crecimiento.");
            return;
        }

        $VP = $this->valorPresente_G;

        // Si es anticipado, convertir a vencido
        $vpVencido = $esAnticipado ? $VP / (1 + $i) : $VP;

        // Caso especial: i = g
        if (abs($i - $g) < 0.0000001) {
            $this->result = ($vpVencido * (1 + $i)) / $n;
        } else {
            // A = VP * (i - g) / [1 - ((1+g)/(1+i))^n]
            $denominador = 1 - pow((1 + $g) / (1 + $i), $n);

            if ($denominador == 0) {
                session()->flash('error', "Error en el cálculo: denominador cero.");
                return;
            }

            $this->result = $vpVencido * ($i - $g) / $denominador;
        }
    }

    private function calcularTasaCrecimiento($i, $n, $esAnticipado)
    {
        if (is_null($this->valorPresente_G) || is_null($this->pagoInicial_Geo)) {
            session()->flash('error', "Se requiere el valor presente y el pago inicial.");
            return;
        }

        $VP = $this->valorPresente_G;
        $A = $this->pagoInicial_Geo;

        // Si es anticipado, convertir a vencido
        $vpVencido = $esAnticipado ? $VP / (1 + $i) : $VP;

        // Usar Newton-Raphson
        $g = 0.05; // 5% inicial
        $tolerance = 0.0001;
        $maxIterations = 100;

        for ($iter = 0; $iter < $maxIterations; $iter++) {
            // Caso especial: i ≈ g
            if (abs($i - $g) < 0.0000001) {
                $f = ($A * $n) / (1 + $i) - $vpVencido;
                if (abs($f) < $tolerance) {
                    $this->result = $g * 100;
                    return;
                }
            }

            // f(g) = A * [1 - ((1+g)/(1+i))^n] / (i - g) - VP
            $ratio = (1 + $g) / (1 + $i);
            $f = $A * (1 - pow($ratio, $n)) / ($i - $g) - $vpVencido;

            if (abs($f) < $tolerance) {
                $this->result = $g * 100;
                return;
            }

            // Derivada aproximada
            $dg = 0.0001;
            $ratio2 = (1 + $g + $dg) / (1 + $i);
            $f2 = $A * (1 - pow($ratio2, $n)) / ($i - $g - $dg) - $vpVencido;
            $df = ($f2 - $f) / $dg;

            if (abs($df) < 0.0000001) {
                session()->flash('error', "No se pudo converger en el cálculo de la tasa de crecimiento.");
                return;
            }

            $g = $g - $f / $df;

            if ($g < -0.99 || $g > 10) {
                $g = 0.05;
            }
        }

        session()->flash('error', "No se pudo calcular la tasa de crecimiento después de $maxIterations iteraciones.");
    }
}
