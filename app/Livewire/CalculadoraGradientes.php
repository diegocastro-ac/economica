<?php

namespace App\Livewire;

use App\traits\Gradientes;
use Livewire\Component;

class CalculadoraGradientes extends Component
{
    use Gradientes;

    public $formulaSeleccionada = 'vp_aritmetico_vencido'; // Fórmula por defecto

    // Opciones disponibles para el combobox de fórmulas
    public function getFormulasOptions()
    {
        return [
            'vp_aritmetico_vencido' => 'VP Gradiente Aritmético Vencido',
            'vp_aritmetico_anticipado' => 'VP Gradiente Aritmético Anticipado',
            'vf_aritmetico_vencido' => 'VF Gradiente Aritmético Vencido',
            'vf_aritmetico_anticipado' => 'VF Gradiente Aritmético Anticipado',
            'vp_geometrico_vencido' => 'VP Gradiente Geométrico Vencido',
            'vp_geometrico_anticipado' => 'VP Gradiente Geométrico Anticipado',
            'vf_geometrico_vencido' => 'VF Gradiente Geométrico Vencido',
            'vf_geometrico_anticipado' => 'VF Gradiente Geométrico Anticipado',
        ];
    }

    // Método que se ejecuta cuando cambia la fórmula seleccionada
    public function updatedFormulaSeleccionada()
    {
        // Limpiar resultados cuando cambie la fórmula
        $this->reset(['result']);
    }

    // Override del método calcular
    public function calcular()
    {
        $this->calcularGradientes();
    }

    // Determinar qué campos mostrar según la fórmula seleccionada
    public function getCamposFormula()
    {
        $esValorPresente = $this->esFormulaValorPresente();
        $esGeometrico = $this->esGradienteGeometrico();

        $campos = [];

        // Valor Presente o Valor Futuro
        if ($esValorPresente) {
            $campos['valorPresente_G'] = [
                'label' => 'Valor Presente (P)',
                'placeholder' => '10,000',
                'description' => 'Valor presente de la serie de pagos'
            ];
        } else {
            $campos['valorFuturo_G'] = [
                'label' => 'Valor Futuro (F)',
                'placeholder' => '15,000',
                'description' => 'Valor futuro de la serie de pagos'
            ];
        }

        // Pago Base
        $campos['pagoBase_G'] = [
            'label' => 'Pago Base (A)',
            'placeholder' => '1,000',
            'description' => 'Primer pago de la serie'
        ];

        // Gradiente
        if ($esGeometrico) {
            $campos['gradiente_G'] = [
                'label' => 'Gradiente Geométrico (G) %',
                'placeholder' => '5.0',
                'description' => 'Tasa de crecimiento constante de los pagos'
            ];
        } else {
            $campos['gradiente_G'] = [
                'label' => 'Gradiente Aritmético (G)',
                'placeholder' => '100',
                'description' => 'Incremento constante en cada período'
            ];
        }

        // Tasa de Interés
        $campos['tasaInteres_G'] = [
            'label' => 'Tasa de Interés (i) %',
            'placeholder' => '8.0',
            'description' => 'Tasa de interés por período'
        ];

        // Número de Períodos
        $campos['numeroPeriodos_G'] = [
            'label' => 'Número de Períodos (n)',
            'placeholder' => '12',
            'description' => 'Cantidad de pagos en la serie'
        ];

        return $campos;
    }

    // Obtener descripción de la fórmula actual
    public function getDescripcionFormula()
    {
        $descripciones = [
            'vp_aritmetico_vencido' => [
                'formula' => 'P = [A[1-(1+i)⁻ⁿ]/i] + (G/i)[[1-(1+i)⁻ⁿ]/i - n/(1+i)ⁿ]',
                'tipo' => 'Aritmético Vencido',
                'explicacion' => 'Pagos que aumentan una cantidad constante (G) al final de cada período.'
            ],
            'vp_aritmetico_anticipado' => [
                'formula' => 'P = {[A[1-(1+i)⁻ⁿ]/i] + (G/i)[[1-(1+i)⁻ⁿ]/i - n/(1+i)ⁿ]} × (1+i)',
                'tipo' => 'Aritmético Anticipado',
                'explicacion' => 'Pagos que aumentan una cantidad constante (G) al inicio de cada período.'
            ],
            'vf_aritmetico_vencido' => [
                'formula' => 'F = [A[(1+i)ⁿ-1]/i] + (G/i)[[(1+i)ⁿ-1]/i - n]',
                'tipo' => 'Aritmético Vencido',
                'explicacion' => 'Valor futuro de pagos que aumentan una cantidad constante al final de cada período.'
            ],
            'vf_aritmetico_anticipado' => [
                'formula' => 'F = {[A[(1+i)ⁿ-1]/i] + (G/i)[[(1+i)ⁿ-1]/i - n]} × (1+i)',
                'tipo' => 'Aritmético Anticipado',
                'explicacion' => 'Valor futuro de pagos que aumentan una cantidad constante al inicio de cada período.'
            ],
            'vp_geometrico_vencido' => [
                'formula' => 'P = A[(1+G)ⁿ(1+i)⁻ⁿ - 1]/(G-i) [si G≠i] | P = nA/(1+i) [si G=i]',
                'tipo' => 'Geométrico Vencido',
                'explicacion' => 'Pagos que crecen a una tasa porcentual constante (G) al final de cada período.'
            ],
            'vp_geometrico_anticipado' => [
                'formula' => 'P = A[(1+G)ⁿ(1+i)⁻ⁿ - 1](1+i)/(G-i) [si G≠i] | P = nA [si G=i]',
                'tipo' => 'Geométrico Anticipado',
                'explicacion' => 'Pagos que crecen a una tasa porcentual constante (G) al inicio de cada período.'
            ],
            'vf_geometrico_vencido' => [
                'formula' => 'F = A[(1+G)ⁿ - (1+i)ⁿ]/(G-i) [si G≠i] | F = nA(1+i)ⁿ⁻¹ [si G=i]',
                'tipo' => 'Geométrico Vencido',
                'explicacion' => 'Valor futuro de pagos que crecen porcentualmente al final de cada período.'
            ],
            'vf_geometrico_anticipado' => [
                'formula' => 'F = A[(1+G)ⁿ - (1+i)ⁿ](1+i)/(G-i) [si G≠i] | F = nA(1+i)ⁿ [si G=i]',
                'tipo' => 'Geométrico Anticipado',
                'explicacion' => 'Valor futuro de pagos que crecen porcentualmente al inicio de cada período.'
            ],
        ];

        return $descripciones[$this->formulaSeleccionada] ?? [
            'formula' => '',
            'tipo' => '',
            'explicacion' => ''
        ];
    }

    // Obtener información de variables para el tooltip
    public function getVariablesInfo()
    {
        $esGeometrico = $this->esGradienteGeometrico();
        $esValorPresente = $this->esFormulaValorPresente();

        $info = [];

        if ($esValorPresente) {
            $info['P'] = 'Valor Presente: valor actual de todos los pagos futuros';
        } else {
            $info['F'] = 'Valor Futuro: valor acumulado al final de todos los períodos';
        }

        $info['A'] = 'Pago Base: primer pago de la serie';

        if ($esGeometrico) {
            $info['G'] = 'Gradiente Geométrico: tasa de crecimiento porcentual entre pagos consecutivos';
        } else {
            $info['G'] = 'Gradiente Aritmético: cantidad fija que se suma en cada período';
        }

        $info['i'] = 'Tasa de Interés: costo del dinero por período (en porcentaje)';
        $info['n'] = 'Número de Períodos: cantidad total de pagos en la serie';

        return $info;
    }

    // Determinar qué campo se calculó
    public function getCampoCalculado()
    {
        $camposVacios = [];

        if ($this->esFormulaValorPresente()) {
            if (is_null($this->valorPresente_G) || $this->valorPresente_G === '') {
                return 'Valor Presente (P)';
            }
        } else {
            if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '') {
                return 'Valor Futuro (F)';
            }
        }

        if (is_null($this->pagoBase_G) || $this->pagoBase_G === '') {
            return 'Pago Base (A)';
        }

        if (is_null($this->gradiente_G) || $this->gradiente_G === '') {
            if ($this->esGradienteGeometrico()) {
                return 'Gradiente Geométrico (G)';
            } else {
                return 'Gradiente Aritmético (G)';
            }
        }

        if (is_null($this->tasaInteres_G) || $this->tasaInteres_G === '') {
            return 'Tasa de Interés (i)';
        }

        if (is_null($this->numeroPeriodos_G) || $this->numeroPeriodos_G === '') {
            return 'Número de Períodos (n)';
        }

        return 'Resultado';
    }

    // Formatear el resultado según el tipo de campo calculado
    public function getResultadoFormateado()
    {
        if ($this->result === null) {
            return null;
        }

        $campoCalculado = $this->getCampoCalculado();

        // Tasa de interés y gradiente geométrico en porcentaje
        if (
            str_contains($campoCalculado, 'Tasa de Interés') ||
            (str_contains($campoCalculado, 'Gradiente') && $this->esGradienteGeometrico())
        ) {
            return number_format($this->result, 4) . '%';
        }

        // Número de períodos sin decimales (o con pocos)
        if (str_contains($campoCalculado, 'Número de Períodos')) {
            return number_format($this->result, 2) . ' períodos';
        }

        // Valores monetarios
        return '$' . number_format($this->result, 2);
    }

    // Verificar si hay caso especial G = i
    public function hayAdvertenciaGIgualI()
    {
        if (!$this->esGradienteGeometrico()) {
            return false;
        }

        $g = $this->gradiente_G ? $this->gradiente_G / 100 : null;
        $i = $this->tasaInteres_G ? $this->tasaInteres_G / 100 : null;

        if ($g !== null && $i !== null) {
            return abs($g - $i) < 0.0001;
        }

        return false;
    }

    // Obtener ejemplo de flujo de pagos
    public function getEjemploFlujo()
    {
        if (!$this->pagoBase_G || !$this->gradiente_G || !$this->numeroPeriodos_G) {
            return null;
        }

        $ejemplos = [];
        $A = $this->pagoBase_G;

        // Mostrar solo primeros 5 períodos como ejemplo
        $periodosMostrar = min(5, $this->numeroPeriodos_G);

        for ($periodo = 1; $periodo <= $periodosMostrar; $periodo++) {
            if ($this->esGradienteAritmetico()) {
                $pago = $A + ($this->gradiente_G * ($periodo - 1));
            } else {
                $g = $this->gradiente_G / 100;
                $pago = $A * pow(1 + $g, $periodo - 1);
            }

            $ejemplos[] = [
                'periodo' => $periodo,
                'pago' => $pago
            ];
        }

        return [
            'pagos' => $ejemplos,
            'hayMas' => $this->numeroPeriodos_G > 5,
            'total' => $this->numeroPeriodos_G
        ];
    }

    public function render()
    {
        return view('livewire.calculadora-gradientes', [
            'formulasOptions' => $this->getFormulasOptions(),
            'camposFormula' => $this->getCamposFormula(),
            'descripcionFormula' => $this->getDescripcionFormula(),
            'variablesInfo' => $this->getVariablesInfo(),
            'campoCalculado' => $this->getCampoCalculado(),
            'resultadoFormateado' => $this->getResultadoFormateado(),
            'advertenciaGIgualI' => $this->hayAdvertenciaGIgualI(),
            'ejemploFlujo' => $this->getEjemploFlujo()
        ]);
    }
}
