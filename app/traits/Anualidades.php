<?php

namespace App\Traits;

trait Anualidades
{
    public ?float $result = null;
    public ?float $tasaInteres_S = null;
    public ?float $tiempo_S = null;
    public int $frecuencia_S = 1;
    // Propiedades específicas de Anualidades
    public ?float $anualidad = null;
    public ?float $valorFuturoAnualidad = null;
    public ?float $valorPresenteAnualidad = null;

    public function calcularAnualidades()
    {
        try {
            $camposVacios = $this->detectarCamposVaciosAnualidad();
            if (count($camposVacios) != 1) {
                throw new \InvalidArgumentException("Debe dejar exactamente UN campo vacío para calcular. Campos vacíos encontrados: " . count($camposVacios));
            }

            $campoACalcular = $camposVacios[0];

            // Convertir tiempo según la frecuencia si es necesario
            $tiempo = $this->tiempo_S;
            if ($this->frecuencia_S > 1 && $tiempo) {
                $tiempo = $tiempo; // Para anualidades, n ya representa los períodos
            }

            // Convertir tasa de interés a decimal si es necesario
            $tasaInteres = $this->tasaInteres_S ? $this->tasaInteres_S / 100 : null;

            // Ajustar tasa según frecuencia
            if ($tasaInteres && $this->frecuencia_S > 1) {
                $tasaInteres = $tasaInteres / $this->frecuencia_S;
            }

            // Calcular según la fórmula seleccionada y el campo vacío
            if ($this->formulaSeleccionada === 'valor_futuro') {
                $this->calcularFormulaValorFuturo($campoACalcular, $tasaInteres, $tiempo);
            } else {
                $this->calcularFormulaValorPresente($campoACalcular, $tasaInteres, $tiempo);
            }
        } catch (\Exception $e) {
            $this->result = null;
            $this->valorFuturoAnualidad = null;
            $this->valorPresenteAnualidad = null;
            throw new \InvalidArgumentException("Error en el cálculo: " . $e->getMessage());
        }
    }

    private function detectarCamposVaciosAnualidad()
    {
        $camposVacios = [];

        if ($this->formulaSeleccionada === 'valor_futuro') {
            // Fórmula VF = A x [(1+i)^n - 1] / i
            if (is_null($this->valorFuturoAnualidad) || $this->valorFuturoAnualidad === '') $camposVacios[] = 'valorFuturoAnualidad';
            if (is_null($this->anualidad) || $this->anualidad === '') $camposVacios[] = 'anualidad';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        } else {
            // Fórmula VA = A x [1 - (1+i)^-n] / i
            if (is_null($this->valorPresenteAnualidad) || $this->valorPresenteAnualidad === '') $camposVacios[] = 'valorPresenteAnualidad';
            if (is_null($this->anualidad) || $this->anualidad === '') $camposVacios[] = 'anualidad';
            if (is_null($this->tasaInteres_S) || $this->tasaInteres_S === '') $camposVacios[] = 'tasaInteres_S';
            if (is_null($this->tiempo_S) || $this->tiempo_S === '') $camposVacios[] = 'tiempo_S';
        }

        return $camposVacios;
    }

    private function calcularFormulaValorFuturo($campoACalcular, $tasaInteres, $tiempo)
    {
        // Fórmula: VF = A x [(1+i)^n - 1] / i
        switch ($campoACalcular) {
            case 'valorFuturoAnualidad':
                if (is_null($this->anualidad) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el valor futuro.");
                }
                if ($tasaInteres == 0) {
                    $this->result = $this->anualidad * $tiempo;
                } else {
                    $factor = (pow(1 + $tasaInteres, $tiempo) - 1) / $tasaInteres;
                    $this->result = $this->anualidad * $factor;
                }
                $this->valorFuturoAnualidad = $this->result;
                break;

            case 'anualidad':
                if (is_null($this->valorFuturoAnualidad) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la anualidad.");
                }
                if ($tasaInteres == 0) {
                    if ($tiempo == 0) {
                        throw new \InvalidArgumentException("El tiempo debe ser mayor a cero.");
                    }
                    $this->result = $this->valorFuturoAnualidad / $tiempo;
                } else {
                    $denominador = (pow(1 + $tasaInteres, $tiempo) - 1) / $tasaInteres;
                    if ($denominador == 0) {
                        throw new \InvalidArgumentException("Error: denominador cero en el cálculo.");
                    }
                    $this->result = $this->valorFuturoAnualidad / $denominador;
                }
                break;

            case 'tasaInteres_S':
                if (is_null($this->valorFuturoAnualidad) || is_null($this->anualidad) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la tasa de interés.");
                }
                $this->result = $this->calcularTasaIterativa('valor_futuro') * 100;
                break;

            case 'tiempo_S':
                if (is_null($this->valorFuturoAnualidad) || is_null($this->anualidad) || is_null($tasaInteres)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el tiempo.");
                }
                if ($tasaInteres == 0) {
                    if ($this->anualidad == 0) {
                        throw new \InvalidArgumentException("La anualidad debe ser mayor a cero.");
                    }
                    $this->result = $this->valorFuturoAnualidad / $this->anualidad;
                } else {
                    if ($this->anualidad == 0) {
                        throw new \InvalidArgumentException("La anualidad debe ser mayor a cero.");
                    }
                    $argumento = ($this->valorFuturoAnualidad * $tasaInteres / $this->anualidad) + 1;
                    if ($argumento <= 0) {
                        throw new \InvalidArgumentException("Los valores no permiten calcular un tiempo válido.");
                    }
                    $this->result = log($argumento) / log(1 + $tasaInteres);
                }
                break;
        }
    }

    private function calcularFormulaValorPresente($campoACalcular, $tasaInteres, $tiempo)
    {
        // Fórmula: VA = A x [1 - (1+i)^-n] / i
        switch ($campoACalcular) {
            case 'valorPresenteAnualidad':
                if (is_null($this->anualidad) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el valor presente.");
                }
                if ($tasaInteres == 0) {
                    $this->result = $this->anualidad * $tiempo;
                } else {
                    $factor = (1 - pow(1 + $tasaInteres, -$tiempo)) / $tasaInteres;
                    $this->result = $this->anualidad * $factor;
                }
                $this->valorPresenteAnualidad = $this->result;
                break;

            case 'anualidad':
                if (is_null($this->valorPresenteAnualidad) || is_null($tasaInteres) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la anualidad.");
                }
                if ($tasaInteres == 0) {
                    if ($tiempo == 0) {
                        throw new \InvalidArgumentException("El tiempo debe ser mayor a cero.");
                    }
                    $this->result = $this->valorPresenteAnualidad / $tiempo;
                } else {
                    $denominador = (1 - pow(1 + $tasaInteres, -$tiempo)) / $tasaInteres;
                    if ($denominador == 0) {
                        throw new \InvalidArgumentException("Error: denominador cero en el cálculo.");
                    }
                    $this->result = $this->valorPresenteAnualidad / $denominador;
                }
                break;

            case 'tasaInteres_S':
                if (is_null($this->valorPresenteAnualidad) || is_null($this->anualidad) || is_null($tiempo)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular la tasa de interés.");
                }
                $this->result = $this->calcularTasaIterativa('valor_presente') * 100;
                break;

            case 'tiempo_S':
                if (is_null($this->valorPresenteAnualidad) || is_null($this->anualidad) || is_null($tasaInteres)) {
                    throw new \InvalidArgumentException("Faltan datos para calcular el tiempo.");
                }
                if ($tasaInteres == 0) {
                    if ($this->anualidad == 0) {
                        throw new \InvalidArgumentException("La anualidad debe ser mayor a cero.");
                    }
                    $this->result = $this->valorPresenteAnualidad / $this->anualidad;
                } else {
                    if ($this->anualidad == 0) {
                        throw new \InvalidArgumentException("La anualidad debe ser mayor a cero.");
                    }
                    $argumento = 1 - ($this->valorPresenteAnualidad * $tasaInteres / $this->anualidad);
                    if ($argumento <= 0) {
                        throw new \InvalidArgumentException("Los valores no permiten calcular un tiempo válido.");
                    }
                    $this->result = -log($argumento) / log(1 + $tasaInteres);
                }
                break;
        }
    }

    private function calcularTasaIterativa($tipo, $precision = 0.0001, $maxIteraciones = 100)
    {
        $tasa = 0.05; // Tasa inicial del 5%

        for ($i = 0; $i < $maxIteraciones; $i++) {
            if ($tipo === 'valor_futuro') {
                if ($tasa == 0) {
                    $vf_calculado = $this->anualidad * $this->tiempo_S;
                } else {
                    $factor = (pow(1 + $tasa, $this->tiempo_S) - 1) / $tasa;
                    $vf_calculado = $this->anualidad * $factor;
                }
                $error = $vf_calculado - $this->valorFuturoAnualidad;
            } else {
                if ($tasa == 0) {
                    $va_calculado = $this->anualidad * $this->tiempo_S;
                } else {
                    $factor = (1 - pow(1 + $tasa, -$this->tiempo_S)) / $tasa;
                    $va_calculado = $this->anualidad * $factor;
                }
                $error = $va_calculado - $this->valorPresenteAnualidad;
            }

            if (abs($error) < $precision) {
                return $tasa;
            }

            // Ajuste simple de la tasa
            $tasa = $tasa - ($error * 0.0001);

            if ($tasa < 0) {
                $tasa = 0.001; // Evitar tasas negativas
            }
        }

        return $tasa;
    }
}
