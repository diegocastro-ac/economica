<?php

namespace App\Livewire;

use App\traits\Gradientes;
use Livewire\Component;

class CalculadoraGradientes extends Component
{
    use Gradientes;

    public $tipoGradiente = 'aritmetico_vencido'; // Opciones: aritmetico_vencido, aritmetico_anticipado, geometrico_vencido, geometrico_anticipado

    // Opciones disponibles para el selector de tipo de gradiente
    public function getTiposGradienteOptions()
    {
        return [
            'aritmetico_vencido' => 'Gradiente Aritmético Vencido',
            'aritmetico_anticipado' => 'Gradiente Aritmético Anticipado',
            'geometrico_vencido' => 'Gradiente Geométrico Vencido',
            'geometrico_anticipado' => 'Gradiente Geométrico Anticipado'
        ];
    }

    // Método que se ejecuta cuando cambia el tipo de gradiente
    public function updatedTipoGradiente()
    {
        // Limpiar todos los campos al cambiar de tipo
        $this->reset([
            'valorPresente_G',
            'valorFuturo_G',
            'tasaInteres_G',
            'numeroPeriodos_G',
            'pagoBase_A',
            'gradienteAritmetico_A',
            'pagoInicial_Geo',
            'tasaCrecimiento_Geo',
            'result',
            'resultVP',
            'resultVF'
        ]);
    }

    // Método principal de cálculo
    public function calcular()
    {
        // Limpiar resultados anteriores
        $this->result = null;
        $this->resultVP = null;
        $this->resultVF = null;

        $esAritmético = str_starts_with($this->tipoGradiente, 'aritmetico');
        $esAnticipado = str_ends_with($this->tipoGradiente, 'anticipado');

        if ($esAritmético) {
            $this->calcularGradienteAritmetico($esAnticipado);
        } else {
            $this->calcularGradienteGeometrico($esAnticipado);
        }
    }

    // Obtener configuración de campos según el tipo de gradiente
    public function getCamposFormula()
    {
        $camposComunes = [
            'tasaInteres_G' => [
                'label' => 'Tasa de Interés (i) %',
                'placeholder' => '5.5',
                'required' => true,
                'help' => 'Tasa de interés por período'
            ],
            'numeroPeriodos_G' => [
                'label' => 'Número de Períodos (n)',
                'placeholder' => '10',
                'required' => true,
                'help' => 'Cantidad total de períodos'
            ]
        ];

        $esAritmético = str_starts_with($this->tipoGradiente, 'aritmetico');

        if ($esAritmético) {
            return array_merge($camposComunes, [
                'valorPresente_G' => [
                    'label' => 'Valor Presente (VP)',
                    'placeholder' => '10,000',
                    'help' => 'Valor actual de la serie de pagos. Dejar vacío para calcularlo.'
                ],
                'valorFuturo_G' => [
                    'label' => 'Valor Futuro (VF)',
                    'placeholder' => '15,000',
                    'help' => 'Valor futuro de la serie de pagos. Dejar vacío para calcularlo.'
                ],
                'pagoBase_A' => [
                    'label' => 'Pago Base (A)',
                    'placeholder' => '1,000',
                    'help' => 'Pago inicial o base de la serie'
                ],
                'gradienteAritmetico_A' => [
                    'label' => 'Gradiente Aritmético (G)',
                    'placeholder' => '100',
                    'help' => 'Incremento constante por período (puede ser negativo)'
                ]
            ]);
        } else { // geometrico
            return array_merge($camposComunes, [
                'valorPresente_G' => [
                    'label' => 'Valor Presente (VP)',
                    'placeholder' => '10,000',
                    'help' => 'Valor actual de la serie de pagos. Dejar vacío para calcularlo.'
                ],
                'valorFuturo_G' => [
                    'label' => 'Valor Futuro (VF)',
                    'placeholder' => '15,000',
                    'help' => 'Valor futuro de la serie de pagos. Dejar vacío para calcularlo.'
                ],
                'pagoInicial_Geo' => [
                    'label' => 'Pago Inicial (P1)',
                    'placeholder' => '1,000',
                    'help' => 'Primer pago de la serie'
                ],
                'tasaCrecimiento_Geo' => [
                    'label' => 'Tasa de Crecimiento (g) %',
                    'placeholder' => '3.0',
                    'help' => 'Tasa de crecimiento geométrico por período'
                ]
            ]);
        }
    }

    // Obtener información sobre la fórmula actual
    public function getFormulaInfo()
    {
        $esAritmético = str_starts_with($this->tipoGradiente, 'aritmetico');
        $esAnticipado = str_ends_with($this->tipoGradiente, 'anticipado');

        if ($esAritmético) {
            if ($esAnticipado) {
                return [
                    'titulo' => 'Gradiente Aritmético Anticipado',
                    'descripcion' => 'Serie de pagos anticipados que aumentan/disminuyen en una cantidad constante',
                    'formula_vp' => 'P = [A[(1+i)ⁿ - 1]/[i(1+i)ⁿ] + (G/i)[(1+i)ⁿ - in - 1]/[i²(1+i)ⁿ]] x (1+i)',
                    'formula_vf' => 'F = [A[(1+i)ⁿ - 1]/i + (G/i)[((1+i)ⁿ - 1)/i - n]] x (1+i)',
                    'variables' => 'A = Pago base, G = Gradiente, i = Tasa, n = Períodos',
                    'ejemplo' => 'Ej: Pagos al inicio de cada período: $1,000, $1,100, $1,200... (G = $100)'
                ];
            } else {
                return [
                    'titulo' => 'Gradiente Aritmético Vencido',
                    'descripcion' => 'Serie de pagos vencidos que aumentan/disminuyen en una cantidad constante',
                    'formula_vp' => 'P = A[(1+i)ⁿ - 1]/[i(1+i)ⁿ] + (G/i)[(1+i)ⁿ - in - 1]/[i²(1+i)ⁿ]',
                    'formula_vf' => 'F = A[(1+i)ⁿ - 1]/i + (G/i)[((1+i)ⁿ - 1)/i - n]',
                    'variables' => 'A = Pago base, G = Gradiente, i = Tasa, n = Períodos',
                    'ejemplo' => 'Ej: Pagos al final de cada período: $1,000, $1,100, $1,200... (G = $100)'
                ];
            }
        } else {
            if ($esAnticipado) {
                return [
                    'titulo' => 'Gradiente Geométrico Anticipado',
                    'descripcion' => 'Serie de pagos anticipados que aumentan/disminuyen en un porcentaje constante',
                    'formula_vp' => 'P = [A(1+G)ⁿ(1+i)⁻ⁿ - 1]/(G-i) x (1+i), cuando G ≠ i',
                    'formula_vp_especial' => 'Si G = i: P = nA x (1+i)',
                    'formula_vf' => 'F = [A(1+G)ⁿ - (1+i)ⁿ]/(G-i) x (1+i), cuando G ≠ i',
                    'formula_vf_especial' => 'Si G = i: F = nA(1+i)ⁿ',
                    'variables' => 'A = Pago inicial, G = Tasa de crecimiento, i = Tasa, n = Períodos',
                    'ejemplo' => 'Ej: Pagos al inicio: $1,000, $1,050, $1,102.50... (G = 5%)'
                ];
            } else {
                return [
                    'titulo' => 'Gradiente Geométrico Vencido',
                    'descripcion' => 'Serie de pagos vencidos que aumentan/disminuyen en un porcentaje constante',
                    'formula_vp' => 'P = A(1+G)ⁿ(1+i)⁻ⁿ - 1]/(G-i), cuando G ≠ i',
                    'formula_vp_especial' => 'Si G = i: P = nA/(1+i)',
                    'formula_vf' => 'F = A[(1+G)ⁿ - (1+i)ⁿ]/(G-i), cuando G ≠ i',
                    'formula_vf_especial' => 'Si G = i: F = nA(1+i)ⁿ',
                    'variables' => 'A = Pago inicial, G = Tasa de crecimiento, i = Tasa, n = Períodos',
                    'ejemplo' => 'Ej: Pagos al final: $1,000, $1,050, $1,102.50... (G = 5%)'
                ];
            }
        }
    }

    // Obtener el nombre del campo calculado
    public function getCampoCalculado()
    {
        // Si se calcularon VP y VF simultáneamente
        if (!is_null($this->resultVP) && !is_null($this->resultVF)) {
            return 'VP y VF';
        }

        $camposVacios = [];
        $esAritmético = str_starts_with($this->tipoGradiente, 'aritmetico');

        if ($esAritmético) {
            if (is_null($this->valorPresente_G) || $this->valorPresente_G === '')
                $camposVacios[] = 'Valor Presente';
            if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '')
                $camposVacios[] = 'Valor Futuro';
            if (is_null($this->pagoBase_A) || $this->pagoBase_A === '')
                $camposVacios[] = 'Pago Base';
            if (is_null($this->gradienteAritmetico_A) || $this->gradienteAritmetico_A === '')
                $camposVacios[] = 'Gradiente Aritmético';
        } else {
            if (is_null($this->valorPresente_G) || $this->valorPresente_G === '')
                $camposVacios[] = 'Valor Presente';
            if (is_null($this->valorFuturo_G) || $this->valorFuturo_G === '')
                $camposVacios[] = 'Valor Futuro';
            if (is_null($this->pagoInicial_Geo) || $this->pagoInicial_Geo === '')
                $camposVacios[] = 'Pago Inicial';
            if (is_null($this->tasaCrecimiento_Geo) || $this->tasaCrecimiento_Geo === '')
                $camposVacios[] = 'Tasa de Crecimiento';
        }

        return count($camposVacios) === 1 ? $camposVacios[0] : 'Resultado';
    }

    // Determinar el formato del resultado
    public function getFormatoResultado()
    {
        $campo = $this->getCampoCalculado();

        if (str_contains($campo, 'Tasa') || str_contains($campo, 'Crecimiento')) {
            return ['tipo' => 'porcentaje', 'decimales' => 4];
        } else {
            return ['tipo' => 'moneda', 'decimales' => 2];
        }
    }

    // Obtener el tipo de gradiente formateado
    public function getTipoGradienteFormato()
    {
        $tipos = [
            'aritmetico_vencido' => 'Aritmético Vencido',
            'aritmetico_anticipado' => 'Aritmético Anticipado',
            'geometrico_vencido' => 'Geométrico Vencido',
            'geometrico_anticipado' => 'Geométrico Anticipado'
        ];

        return $tipos[$this->tipoGradiente] ?? 'Desconocido';
    }

    public function render()
    {
        return view('livewire.calculadora-gradientes', [
            'tiposGradienteOptions' => $this->getTiposGradienteOptions(),
            'camposFormula' => $this->getCamposFormula(),
            'formulaInfo' => $this->getFormulaInfo()
        ]);
    }
}
