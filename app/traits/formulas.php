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
        // limpiamos resultado previo
        $this->result = null;
        $this->interesSimple_S = null;
        session()->forget('error');

        // detectar campos vacíos (antes de cualquier conversión)
        $camposVacios = $this->detectarCamposVacios();

        if (count($camposVacios) != 1) {
            session()->flash('error', "Debe dejar exactamente UN campo vacío para calcular. Campos vacíos encontrados: " . count($camposVacios));
            return;
        }

        $campoACalcular = $camposVacios[0];

        // --- Preparar tasa por periodo y número de periodos ---
        // tasaInteres_S se asume como tasa ANUAL en %, luego:
        if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') {
            $tasaPeriodo = null;
        } else {
            // tasa anual -> decimal
            $tasaAnualDecimal = $this->tasaInteres_S / 100.0;
            // tasa por periodo (ej: mensual = anual / 12)
            $tasaPeriodo = $tasaAnualDecimal / max(1, $this->frecuencia_S);
        }

        // tiempo_S debe estar en la misma unidad que la frecuencia:
        // frecuencia 1 -> tiempo en años, 12 -> tiempo en meses, 365 -> tiempo en días.
        $periodos = $this->tiempo_S; // si convertirTiempoDetallado ya asignó, aquí está en la unidad correcta

        // Si tiempo es null pero fórmula requiere tiempo para el cálculo, detectarlo luego.

        // Llamar a la fórmula adecuada
        if ($this->formulaSeleccionada === 'interes') {
            $this->calcularFormulaInteres($campoACalcular, $tasaPeriodo, $periodos);
        } else {
            $this->calcularFormulaMonto($campoACalcular, $tasaPeriodo, $periodos);
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

    private function calcularFormulaInteres($campoACalcular, $tasaPeriodo, $periodos)
    {
        // Fórmula: I = C × i_periodo × periodos
        switch ($campoACalcular) {
            case 'interesSimple_S':
                if (is_null($this->capitalInicial_S) || is_null($tasaPeriodo) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular el interés.");
                    return;
                }
                $this->result = $this->capitalInicial_S * $tasaPeriodo * $periodos;
                $this->interesSimple_S = $this->result;
                return;

            case 'capitalInicial_S':
                if (is_null($this->interesSimple_S) || is_null($tasaPeriodo) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular el capital.");
                    return;
                }
                if ($tasaPeriodo == 0 || $periodos == 0) {
                    session()->flash('error', "La tasa por periodo y el número de periodos deben ser mayores a cero.");
                    return;
                }
                $this->result = $this->interesSimple_S / ($tasaPeriodo * $periodos);
                return;

            case 'tasaInteres_S':
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular la tasa de interés.");
                    return;
                }
                if ($this->capitalInicial_S == 0 || $periodos == 0) {
                    session()->flash('error', "El capital y el número de periodos deben ser mayores a cero.");
                    return;
                }
                // tasaPeriodo decimal = I / (C * periodos)
                $tasaPeriodoDecimal = $this->interesSimple_S / ($this->capitalInicial_S * $periodos);
                // convertir a tasa anual en %
                $tasaAnualDecimal = $tasaPeriodoDecimal * max(1, $this->frecuencia_S);
                $this->result = $tasaAnualDecimal * 100; // en %
                return;

            case 'tiempo_S':
                if (is_null($this->interesSimple_S) || is_null($this->capitalInicial_S) || is_null($tasaPeriodo)) {
                    session()->flash('error', "Faltan datos para calcular el tiempo.");
                    return;
                }
                if ($this->capitalInicial_S == 0 || $tasaPeriodo == 0) {
                    session()->flash('error', "El capital y la tasa deben ser mayores a cero.");
                    return;
                }
                // periodos = I / (C * i_periodo)
                $periodosBase = $this->interesSimple_S / ($this->capitalInicial_S * $tasaPeriodo);
                // resultado en la misma unidad que la frecuencia (periodos)
                $this->result = $periodosBase;
                return;
        }
    }

    private function calcularFormulaMonto($campoACalcular, $tasaPeriodo, $periodos)
    {
        // Fórmula: M = C (1 + i_periodo * periodos)
        switch ($campoACalcular) {
            case 'montoFinal_S':
                if (is_null($this->capitalInicial_S) || is_null($tasaPeriodo) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular el monto final.");
                    return;
                }
                $this->result = $this->capitalInicial_S * (1 + $tasaPeriodo * $periodos);
                $this->interesSimple_S = $this->result - $this->capitalInicial_S;
                return;

            case 'capitalInicial_S':
                if (is_null($this->montoFinal_S) || is_null($tasaPeriodo) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular el capital inicial.");
                    return;
                }
                $denominador = 1 + $tasaPeriodo * $periodos;
                if ($denominador == 0) {
                    session()->flash('error', "Error: denominador cero en el cálculo.");
                    return;
                }
                $this->result = $this->montoFinal_S / $denominador;
                $this->interesSimple_S = $this->montoFinal_S - $this->result;
                return;

            case 'tasaInteres_S':
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($periodos)) {
                    session()->flash('error', "Faltan datos para calcular la tasa de interés.");
                    return;
                }
                if ($this->capitalInicial_S == 0 || $periodos == 0) {
                    session()->flash('error', "El capital y el número de periodos deben ser mayores a cero.");
                    return;
                }
                // tasaPeriodoDecimal = (M - C) / (C * periodos)
                $tasaPeriodoDecimal = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $periodos);
                $tasaAnualDecimal = $tasaPeriodoDecimal * max(1, $this->frecuencia_S);
                $this->result = $tasaAnualDecimal * 100; // en %
                $this->interesSimple_S = $this->montoFinal_S - $this->capitalInicial_S;
                return;

            case 'tiempo_S':
                if (is_null($this->montoFinal_S) || is_null($this->capitalInicial_S) || is_null($tasaPeriodo)) {
                    session()->flash('error', "Faltan datos para calcular el tiempo.");
                    return;
                }
                if ($this->capitalInicial_S == 0 || $tasaPeriodo == 0) {
                    session()->flash('error', "El capital y la tasa deben ser mayores a cero.");
                    return;
                }
                $periodosBase = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tasaPeriodo);
                $this->result = $periodosBase;
                $this->interesSimple_S = $this->montoFinal_S - $this->capitalInicial_S;
                return;
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
