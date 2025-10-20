<?php

namespace App\traits;
// NO SE USA
trait formulas
{
    public float $result;
    public string $resultMessage = '';



    public function calcular(String $tipo1)
    {

        if ($tipo1 == "interesSimple") {

            $this->interesSimple();
        } else if ($tipo1 == "interesCompuesto") {

            $this->interesCompuesto();
        } else
            $this->anualidad();
    }

    private function interesCompuesto()
    {
        $tiempoTotal = 0;
        if (!empty($this->tiempoAnios_C)) {
            $tiempoTotal += $this->tiempoAnios_C;
        }
        if (!empty($this->tiempoMeses_C)) {
            $tiempoTotal += $this->tiempoMeses_C / 12;
        }
        if (!empty($this->tiempoDias_C)) {
            $tiempoTotal += $this->tiempoDias_C / 365;
        }


        
        // Calcular capital inicial (P)
        if (empty($this->capitalInicial_C) && !empty($this->montoFinal_C) && !empty($this->tasaInteres_C) ) {

            // Convertir la tasa dada a tasa efectiva por período de capitalización
            $tasaEfectivaPorPeriodo = $this->obtenerTasaEfectivaPorPeriodo();

            // Número total de períodos de capitalización
            $n = $tiempoTotal * $this->capitalizacion_C;

            // Fórmula: P = M / (1 + i)^n
            $this->result = $this->montoFinal_C / pow(1 + $tasaEfectivaPorPeriodo, $n);
            $this->resultMessage = '$' . number_format($this->result, 2);
            return;
        }

        // Calcular monto final (M)
        if (empty($this->montoFinal_C) && !empty($this->capitalInicial_C) && !empty($this->tasaInteres_C) ) {

            // Convertir la tasa dada a tasa efectiva por período de capitalización
            $tasaEfectivaPorPeriodo = $this->obtenerTasaEfectivaPorPeriodo();

            // Número total de períodos de capitalización
            $n = $tiempoTotal * $this->capitalizacion_C;

            // Fórmula: M = P * (1 + i)^n
            $this->result = $this->capitalInicial_C * pow(1 + $tasaEfectivaPorPeriodo, $n);
            $this->resultMessage = '$' . number_format($this->result, 2);
            return;
        }

        // Calcular tasa de interés
        if (empty($this->tasaInteres_C) && !empty($this->capitalInicial_C) && !empty($this->montoFinal_C) ) {

            // Número total de períodos de capitalización
            $n = $tiempoTotal * $this->capitalizacion_C;

            // Calcular tasa efectiva por período de capitalización
            // Fórmula: i = (M/P)^(1/n) - 1
            $tasaEfectivaPorPeriodo = pow($this->montoFinal_C / $this->capitalInicial_C, 1 / $n) - 1;

            // Convertir a la periodicidad deseada
            $this->result = $this->convertirTasaAPeriodicidadDeseada($tasaEfectivaPorPeriodo);
            $this->resultMessage = number_format($this->result, 3) . '%';
            return;
        }

        // Calcular tiempo
        if (empty($this->tiempo_C) && !empty($this->capitalInicial_C) && !empty($this->montoFinal_C) && !empty($this->tasaInteres_C)) {

            // Convertir la tasa dada a tasa efectiva por período de capitalización
            $tasaEfectivaPorPeriodo = $this->obtenerTasaEfectivaPorPeriodo();

            // Fórmula: n = ln(M/P) / ln(1 + i)
            $n_total = log($this->montoFinal_C / $this->capitalInicial_C) / log(1 + $tasaEfectivaPorPeriodo);

            // Convertir a años (o la unidad de tiempo base)
            $this->result = $n_total / $this->capitalizacion_C;

            $unidad = $this->getUnidadTiempo();
            $this->resultMessage = number_format($this->result, 2) . ' ' . $unidad;
            return;
        }

        $this->result = 0;
        $this->resultMessage = 'Faltan datos para el cálculo';
    }

    /**
     * Convierte la tasa dada a tasa efectiva por período de capitalización
     */
    private function obtenerTasaEfectivaPorPeriodo()
    {
        // Primero convertir la tasa a anual si no lo está
        $tasaAnual = $this->tasaInteres_C;
        if ($this->tipoTasa_C != 1) {
            $tasaAnual = $this->tasaInteres_C * $this->tipoTasa_C;
        }

        // Convertir a decimal
        $tasaAnualDecimal = $tasaAnual / 100;

        // Convertir a tasa efectiva por período de capitalización
        $tasaEfectivaPorPeriodo = $tasaAnualDecimal / $this->capitalizacion_C;

        return $tasaEfectivaPorPeriodo;
    }

    /**
     * Convierte la tasa efectiva por período de capitalización a la periodicidad deseada
     */
    private function convertirTasaAPeriodicidadDeseada($tasaEfectivaPorPeriodo)
    {
        // Convertir a tasa anual
        $tasaAnual = $tasaEfectivaPorPeriodo * $this->capitalizacion_C;

        // Convertir a la periodicidad deseada
        $tasaEnPeriodicidadDeseada = $tasaAnual / $this->tipoTasa_C;

        // Convertir a porcentaje
        return $tasaEnPeriodicidadDeseada * 100;
    }

    private function getUnidadTiempo()
    {
        switch ($this->capitalizacion_C) {
            case 1:
                return 'años';
            case 2:
                return 'años';
            case 4:
                return 'años';
            case 12:
                return 'años';
            case 365:
                return 'años';
            default:
                return 'períodos';
        }
    }
}
