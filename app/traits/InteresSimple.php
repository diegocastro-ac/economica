<?php

namespace App\Traits;

trait InteresSimple
{
    // Propiedades específicas de Interés Simple
    public ?float $tasaInteres_S = null;
    public ?float $capitalInicial_S = null;
    public ?float $montoFinal_S = null;
    public int $frecuencia_S = 1;
    public ?float $tiempo_S = null;
    public ?float $result = null;
    public ?float $interesSimple_S = null;

    public function calcularInteresSimple()
    {
        try {
            $camposVacios = $this->detectarCamposVaciosInteresSimple();
            if (count($camposVacios) != 1) {
                session()->flash('error', "Debe dejar exactamente UN campo vacío. Campos vacíos encontrados: " . count($camposVacios));
                return;
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

    private function detectarCamposVaciosInteresSimple()
    {
        $camposVacios = [];

        if ($this->formulaSeleccionada === 'interes') {
            // Fórmula I = C x i x t
            if (is_null($this->interesSimple_S) || $this->interesSimple_S === '') $camposVacios[] = 'interesSimple_S';
            if (is_null($this->capitalInicial_S) || $this->capitalInicial_S === '') $camposVacios[] = 'capitalInicial_S';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        } else {
            // Fórmula M = C(1 + i x t)
            if (is_null($this->montoFinal_S) || $this->montoFinal_S === '') $camposVacios[] = 'montoFinal_S';
            if (is_null($this->capitalInicial_S) || $this->capitalInicial_S === '') $camposVacios[] = 'capitalInicial_S';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        }

        return $camposVacios;
    }

    private function calcularFormulaInteres($campoACalcular, $tasaInteres, $tiempo)
    {
        // Fórmula: I = C x i x t
        switch ($campoACalcular) {
            case 'interesSimple_S':
                // I = C x i x t
                if (is_null($this->capitalInicial_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular el interés.");
                    break;
                }

                $this->result = $this->capitalInicial_S * $tasaInteres * $tiempo;
                break;

            case 'capitalInicial_S':
                // C = I / (i x t)
                if (is_null($this->interesSimple_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular el capital.");
                    break;
                }

                if ($tasaInteres == 0 || $tiempo == 0) {
                    session()->flash('error', "La tasa de interés y el tiempo deben ser mayores a cero.");
                    break;
                }

                $this->result = $this->interesSimple_S / ($tasaInteres * $tiempo);
                break;

            case 'tasaInteres_S':
                // i = I / (C x t)
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular la tasa de interés.");
                    break;
                }

                if ($this->capitalInicial_S == 0 || $tiempo == 0) {
                    session()->flash('error', "El capital y el tiempo deben ser mayores a cero.");
                    break;
                }

                $tasaDecimal = $this->interesSimple_S / ($this->capitalInicial_S * $tiempo);
                $this->result = $tasaDecimal * 100; // Convertir a porcentaje
                break;

            case 'tiempo_S':
                // t = I / (C x i)
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($tasaInteres)) {
                    session()->flash('error', "Faltan datos para calcular el tiempo.");
                    break;
                }

                if ($this->capitalInicial_S == 0 || $tasaInteres == 0) {
                    session()->flash('error', "El capital y la tasa de interés deben ser mayores a cero.");
                    break;
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
        // Fórmula: M = C(1 + i x t)
        switch ($campoACalcular) {
            case 'montoFinal_S':
                // M = C(1 + i x t)
                if (is_null($this->capitalInicial_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular el monto final.");
                    break;
                }

                $this->result = $this->capitalInicial_S * (1 + $tasaInteres * $tiempo);
                break;

            case 'capitalInicial_S':
                // C = M / (1 + i x t)
                if (is_null($this->montoFinal_S) || is_null($tasaInteres) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular el capital inicial.");
                    break;
                }

                $denominador = 1 + $tasaInteres * $tiempo;
                if ($denominador == 0) {
                    session()->flash('error', "Error: denominador cero en el cálculo.");
                    break;
                }

                $this->result = $this->montoFinal_S / $denominador;
                break;

            case 'tasaInteres_S':
                // i = (M - C) / (C x t)
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($tiempo)) {
                    session()->flash('error', "Faltan datos para calcular la tasa de interés.");
                    break;
                }

                if ($this->capitalInicial_S == 0 || $tiempo == 0) {
                    session()->flash('error', "El capital y el tiempo deben ser mayores a cero.");
                    break;
                }

                $tasaDecimal = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tiempo);
                $this->result = $tasaDecimal * 100; // Convertir a porcentaje
                break;

            case 'tiempo_S':
                // t = (M - C) / (C x i)
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($tasaInteres)) {
                    session()->flash('error', "Faltan datos para calcular el tiempo.");
                    break;
                }

                if ($this->capitalInicial_S == 0 || $tasaInteres == 0) {
                    session()->flash('error', "El capital y la tasa de interés deben ser mayores a cero.");
                    break;
                }

                $tiempoBase = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tasaInteres);

                // Ajustar según la frecuencia
                if ($this->frecuencia_S > 1) {
                    $this->result = $tiempoBase * $this->frecuencia_S;
                } else {
                    $this->result = $tiempoBase;
                }

                // $this->interesSimple_S = $this->montoFinal_S - $this->capitalInicial_S;
                break;
        }
    }
}
