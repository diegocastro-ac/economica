<?php

namespace App\traits;

trait formulas
{
    public float $tasaInteres_S;
    public float $capitalInicial_S;
    public float $montoFinal_S;
    public int $frecuencia_S = 1;
    public float $tiempo_S;
    public float $result;
    public float $interesSimple_S;

    public function calcular(String $tipo) {
        if ($tipo = "interesSimple") {
            $this->interesSimple();

        }
        else if ($tipo = "interesCompuesto") {
            $this->interesCompuesto();
        }
        else 
            $this->anualidad();
    }

    private function interesSimple() {
        if (!empty($this->tiempo_S)) {
            $tiempo=$this->tiempo_S/$this->frecuencia_S;
        }
        
        //dd($tiempo);

        if (!empty($this->tasaInteres_S)) {
            $tasaInteres=$this->tasaInteres_S/100;  
        }

        //calcular monto final
        if (empty($this->montoFinal_S) && $this->capitalInicial_S && $this->tasaInteres_S && $this->tiempo_S) {
            $this->result = $this->capitalInicial_S * (1 + $tasaInteres * $tiempo);

            $this->interesSimple_S = $this->result - $this->capitalInicial_S;
        }

        //calcular capital inicial
        else if (empty($this->capitalInicial_S) && $this->montoFinal_S && $this->tasaInteres_S && $this->tiempo_S)  {
        $this->result = $this->montoFinal_S / (1 + $tasaInteres * $tiempo);
        }

        //calcular tasa de interes
        else if (empty($this->tasaInteres_S) && $this->montoFinal_S && $this->capitalInicial_S && $this->tiempo_S) {
        $this->result = ($this->montoFinal_S - $this->capitalInicial_S) / ($this->capitalInicial_S * $tiempo)*100;
        }
        else if (empty($this->tiempo_S) && $this->montoFinal_S && $this->capitalInicial_S && $this->tasaInteres_S) {
        $this->result = ($this->montoFinal_S - $this->capitalInicial_S) 
                        / ($this->capitalInicial_S * $this->tasaInteres_S);
        }
        else {
        throw new \InvalidArgumentException("No se pudo determinar qué calcular en interés simple.");
        }
    }
    
    private function interesCompuesto() {
        
    }
    
    private function anualidad() {
        
    }

    private function a() {
        
    }

    private function aa() {
        
    }
}
