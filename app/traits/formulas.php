<?php

namespace App\traits;

trait formulas
{

    public float $result;
    

    public function calcular(String $tipo1)
    {

        if ($tipo1 == "interesSimple") {

            $this->interesSimple();
        } else if ($tipo1 == "interesCompuesto") {

            $this->interesCompuesto();
        } else

            $this->anualidad();
    }

    private function interesSimple()
    {
        if (!empty($this->montoFinal_S)) {
            $tiempo = $this->tiempo_S / $this->frecuencia_S;
        }

        //dd($tiempo);

        if (!empty($this->tasaInteres_S)) {
            $tasaInteres = $this->tasaInteres_S / 100;
        }

        //calcular monto final
        if (empty($this->montoFinal_S) && $this->capitalInicial_S && $this->tasaInteres_S && $this->tiempo_S) {
            $this->result = $this->capitalInicial_S * (1 + $tasaInteres * $tiempo);

            $this->interesSimple_S = $this->result - $this->capitalInicial_S;
        }

        //calcular capital inicial
        else if (empty($this->capitalInicial_S) && $this->montoFinal_S && $this->tasaInteres_S && $this->tiempo_S) {
            $this->result = $this->montoFinal_S / (1 + $tasaInteres * $tiempo);
        }

        //calcular tasa de interes
        else if (empty($this->tasaInteres_S) && $this->montoFinal_S && $this->capitalInicial_S && $this->tiempo_S) {
            $this->result = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tiempo) * 100;
        } else if (empty($this->tiempo_S) && $this->montoFinal_S && $this->capitalInicial_S && $this->tasaInteres_S) {
            $this->result = ($this->montoFinal_S - $this->capitalInicial_S)
                / ($this->capitalInicial_S * $this->tasaInteres_S);
        } else {
            throw new \InvalidArgumentException("No se pudo determinar qué calcular en interés simple.");
        }
    }

    private function interesCompuesto()
    {

        // calcular capital inicial
        //if (empty($this->capitalInicial_C) && $this->montoFinal_C && $this->tasaInteres_C && $this->tiempo_C) {
        //    $this->result = $this->montoFinal_C / pow(1 + ($this->tasaInteres_C / 100), $this->tiempo_C);
        //}

        // calcular capital inicial
        //if (empty($this->capitalInicial_C) && $this->montoFinal_C && $this->tasaInteres_C && $this->tiempo_C && $this->capitalizacion_C) {
        //    $n = $this->tiempo_C * $this->capitalizacion_C; // convierte a períodos correctos
        //    $this->result = $this->montoFinal_C / pow(1 + ($this->tasaInteres_C / 100), $n);
        //}

        // calcular capital inicial
        if (empty($this->capitalInicial_C) && $this->montoFinal_C && $this->tasaInteres_C && $this->tiempo_C && $this->capitalizacion_C) {

            if ($this->capitalizacion_C == '2') {
                // Tasa nominal anual -> dividir entre la capitalización
                $i = ($this->tasaInteres_C / 100) / $this->capitalizacion_C;
            } else {
                // Tasa ya periódica (ej: mensual, trimestral, etc.)
                $i = $this->tasaInteres_C / 100;
            }

            $n = $this->tiempo_C * $this->capitalizacion_C;
            $this->result = $this->montoFinal_C / pow(1 + $i, $n);
        }




        //calcular monto final
        if (empty($this->montoFinal_C) && $this->capitalInicial_C && $this->tasaInteres_C && $this->tiempo_C) {
            $this->result = $this->capitalInicial_C * pow(1 + ($this->tasaInteres_C / 100), $this->tiempo_C);
        }

        // calcular tasa de interés
        if (empty($this->tasaInteres_C) && $this->capitalInicial_C && $this->montoFinal_C && $this->tiempo_C) {
            $this->result = (pow(($this->montoFinal_C / $this->capitalInicial_C), 1 / $this->tiempo_C) - 1) * 100;
        }

        // calcular tiempo
        if (empty($this->tiempo_C) && $this->capitalInicial_C && $this->montoFinal_C && $this->tasaInteres_C) {
            $this->result = log($this->montoFinal_C / $this->capitalInicial_C) / log(1 + ($this->tasaInteres_C / 100));
        }
    }

    private function anualidad() {}

    private function a() {}

    private function aa() {}
}
