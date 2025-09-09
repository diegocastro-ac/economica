<?php

namespace App\traits;

trait formulas
{
    public ?float $tasaInteres_S = null;
    public ?float $capitalInicial_S = null;
    public ?float $montoFinal_S = null;
    public int $frecuencia_S = 1;
    public ?float $tiempo_S = null;
    public ?float $result = null;
    public ?float $interesSimple_S = null;

    public function calcular(String $tipo)
    {
        if ($tipo === "interesSimple") {
            $this->interesSimple();
        } else if ($tipo === "interesCompuesto") {
            $this->interesCompuesto();
        } else {
            $this->anualidad();
        }
    }

    private function interesSimple()
    {
        try {
            // Detectar automáticamente qué campo está vacío y calcularlo
            $camposVacios = $this->detectarCamposVacios();

            if (count($camposVacios) != 1) {
                throw new \InvalidArgumentException("Debe dejar exactamente UN campo vacío para calcular. Campos vacíos encontrados: " . count($camposVacios));
            }

            $campoACalcular = $camposVacios[0];

            // Convertir tiempo según la frecuencia si es necesario
            $tiempo = $this->tiempo_S;
            if ($this->frecuencia_S > 1 && $tiempo) {
                $tiempo = $tiempo / $this->frecuencia_S;
            }

            // Convertir tasa de interés a decimal si es necesario
            $tasaInteres = $this->tasaInteres_S ? $this->tasaInteres_S / 100 : null;

            // Calcular según la fórmula seleccionada y el campo vacío
            if ($this->formulaSeleccionada === 'interes') {
                $this->calcularFormulaInteres($campoACalcular, $tasaInteres, $tiempo);
            } else {
                $this->calcularFormulaMonto($campoACalcular, $tasaInteres, $tiempo);
            }
        } catch (\Exception $e) {
            $this->result = null;
            $this->interesSimple_S = null;
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    private function detectarCamposVacios()
    {
        $camposVacios = [];

        if ($this->formulaSeleccionada === 'interes') {
            // Fórmula I = C × i × t
            if (is_null($this->interesSimple_S) || $this->interesSimple_S === '') $camposVacios[] = 'interesSimple_S';
            if (is_null($this->capitalInicial_S) || $this->capitalInicial_S === '') $camposVacios[] = 'capitalInicial_S';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        } else {
            // Fórmula M = C(1 + i × t)
            if (is_null($this->montoFinal_S) || $this->montoFinal_S === '') $camposVacios[] = 'montoFinal_S';
            if (is_null($this->capitalInicial_S) || $this->capitalInicial_S === '') $camposVacios[] = 'capitalInicial_S';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        }

        return $camposVacios;
    }

    private function calcularFormulaInteres($campoACalcular, $tasaInteres, $tiempo)
    {
        // Fórmula: I = C × i × t
        switch ($campoACalcular) {
            case 'interesSimple_S':
                // I = C × i × t
                if (is_null($this->capitalInicial_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el interés.");
                }
                $this->result = $this->capitalInicial_S * $tasaInteres * $tiempo;
                $this->interesSimple_S = $this->result;
                break;

            case 'capitalInicial_S':
                // C = I / (i × t)
                if (is_null($this->interesSimple_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el capital.");
                }
                if ($tasaInteres == 0 || $tiempo == 0) {
                    throw new \InvalidArgumentException("La tasa de interés y el tiempo deben ser mayores a cero.");
                }
                $this->result = $this->interesSimple_S / ($tasaInteres * $tiempo);
                break;

            case 'tasaInteres_S':
                // i = I / (C × t)
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la tasa de interés.");
                }
                if ($this->capitalInicial_S == 0 || $tiempo == 0) {
                    throw new \InvalidArgumentException("El capital y el tiempo deben ser mayores a cero.");
                }
                $tasaDecimal = $this->interesSimple_S / ($this->capitalInicial_S * $tiempo);
                $this->result = $tasaDecimal * 100; // Convertir a porcentaje
                break;

            case 'tiempo_S':
                // t = I / (C × i)
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($tasaInteres)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el tiempo.");
                }
                if ($this->capitalInicial_S == 0 || $tasaInteres == 0) {
                    throw new \InvalidArgumentException("El capital y la tasa de interés deben ser mayores a cero.");
                }
                $tiempoBase = $this->interesSimple_S / ($this->capitalInicial_S * $tasaInteres);

                // Ajustar según la frecuencia
                if ($this->frecuencia_S > 1) {
                    $this->result = $tiempoBase * $this->frecuencia_S;
                } else {
                    $this->result = $tiempoBase;
                }
                break;
        }
    }

    private function calcularFormulaMonto($campoACalcular, $tasaInteres, $tiempo)
    {
        // Fórmula: M = C(1 + i × t)
        switch ($campoACalcular) {
            case 'montoFinal_S':
                // M = C(1 + i × t)
                if (is_null($this->capitalInicial_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el monto final.");
                }
                $this->result = $this->capitalInicial_S * (1 + $tasaInteres * $tiempo);
                $this->interesSimple_S = $this->result - $this->capitalInicial_S;
                break;

            case 'capitalInicial_S':
                // C = M / (1 + i × t)
                if (is_null($this->montoFinal_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el capital inicial.");
                }
                $denominador = 1 + $tasaInteres * $tiempo;
                if ($denominador == 0) {
                    throw new \InvalidArgumentException("Error: denominador cero en el cálculo.");
                }
                $this->result = $this->montoFinal_S / $denominador;
                $this->interesSimple_S = $this->montoFinal_S - $this->result;
                break;

            case 'tasaInteres_S':
                // i = (M - C) / (C × t)
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la tasa de interés.");
                }
                if ($this->capitalInicial_S == 0 || $tiempo == 0) {
                    throw new \InvalidArgumentException("El capital y el tiempo deben ser mayores a cero.");
                }
                $tasaDecimal = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tiempo);
                $this->result = $tasaDecimal * 100; // Convertir a porcentaje
                $this->interesSimple_S = $this->montoFinal_S - $this->capitalInicial_S;
                break;

            case 'tiempo_S':
                // t = (M - C) / (C × i)
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($tasaInteres)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el tiempo.");
                }
                if ($this->capitalInicial_S == 0 || $tasaInteres == 0) {
                    throw new \InvalidArgumentException("El capital y la tasa de interés deben ser mayores a cero.");
                }
                $tiempoBase = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tasaInteres);

                // Ajustar según la frecuencia
                if ($this->frecuencia_S > 1) {
                    $this->result = $tiempoBase * $this->frecuencia_S;
                } else {
                    $this->result = $tiempoBase;
                }
                $this->interesSimple_S = $this->montoFinal_S - $this->capitalInicial_S;
                break;
        }
    }

    private function interesCompuesto()
    {
        // Implementar más adelante
    }

    private function anualidad()
    {
        // Implementar más adelante
    }
}
