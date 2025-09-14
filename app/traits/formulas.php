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
        $tasa = null;
        // Si la tasa está en periodicidad diferente a anual, convertirla
        if (!empty($this->tasaInteres_C)) {
            $tasaAnual = $this->tasaInteres_C;
            if ($this->tipoTasa_C != 1) {
                // Convertir de la periodicidad dada a anual
                $tasaAnual = $this->tasaInteres_C * $this->tipoTasa_C;
            }
            $tasa = $tasaAnual / 100;
        }

        // Calcular capital inicial
        if (empty($this->capitalInicial_C) && $this->montoFinal_C && $this->tasaInteres_C && $this->tiempo_C && $this->capitalizacion_C && $this->tipoTasa_C) {

            // Convertir tasa anual a tasa por período de capitalización
            //$i = ($this->tasaInteres_C * $this->tipoTasa_C) / 100;

            // Número total de períodos de capitalización
            $n = $this->tiempo_C * $this->capitalizacion_C;

            $this->result = $this->montoFinal_C / pow(1 + ($tasa / $this->capitalizacion_C), $n);
            $this->resultMessage = '$' . number_format($this->result, 2);
            return;
        }

        // Calcular monto final
        if (empty($this->montoFinal_C) && $this->capitalInicial_C && $this->tasaInteres_C && $this->tiempo_C && $this->capitalizacion_C) {

            // Convertir tasa anual a tasa por período de capitalización
            //$i = ($this->tasaInteres_C / 100); // $this->capitalizacion_C;

            // Número total de períodos de capitalización
            $n = $this->tiempo_C * $this->capitalizacion_C;
            // dd($tasa);
            $this->result = $this->capitalInicial_C * pow(1 + $tasa, $n);
            $this->resultMessage = '$' . number_format($this->result, 2);
            return;
        }

        // Calcular tasa de interés
        if (empty($this->tasaInteres_C) && $this->capitalInicial_C && $this->montoFinal_C && $this->tiempo_C && $this->capitalizacion_C && $this->tipoTasa_C) {

            // Número total de períodos de capitalización
            $n = $this->tiempo_C * $this->capitalizacion_C;

            // Tasa por período de capitalización
            $i = pow(($this->montoFinal_C / $this->capitalInicial_C), 1 / $n) - 1;

            // Convertir a tasa anual
            $this->result = ($i * $this->tipoTasa_C) * 100;
            $this->resultMessage = number_format($this->result, 2) . '%';
            return;
        }

        // Calcular tiempo
        if (empty($this->tiempo_C) && $this->capitalInicial_C && $this->montoFinal_C && $this->tasaInteres_C && $this->capitalizacion_C) {

            // Convertir tasa anual a tasa por período de capitalización
            //$i = ($this->tasaInteres_C / 100); // $this->capitalizacion_C;

            // Número total de períodos de capitalización
            $n_total = log($this->montoFinal_C / $this->capitalInicial_C) / log(1 + $tasa);

            // Convertir a años
            $this->result = $n_total / $this->capitalizacion_C;

            // Determinar unidad de tiempo
            $unidad = $this->getUnidadTiempo();
            $this->resultMessage = number_format($this->result, 2) . ' ' . $unidad;
            return;
        }

        $this->result = 0;
        $this->resultMessage = 'Faltan datos para el cálculo';
    }

    private function getUnidadTiempo(): string
    {
        switch ($this->capitalizacion_C) {
            case 1:
                return 'años';
            case 2:
                return 'años (semestres)';
            case 3:
                return 'años (trimestres)';
            case 12:
                return 'años (meses)';
            case 365:
                return 'años (días)';
            default:
                return 'períodos';
        }
    }
}
