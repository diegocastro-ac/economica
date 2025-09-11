<div>
    <form class="space-y-8" wire:submit.prevent="calcular()">

        <!-- Selector de fórmula -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-6">
            <label class="text-sm font-medium text-green-900 dark:text-green-100 mb-3 block">
                Selecciona la fórmula de anualidad a utilizar:
            </label>
            <select wire:model.live="formulaSeleccionada"
                class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-md text-base text-green-900 dark:text-green-100 bg-white dark:bg-green-800 transition-colors focus:outline-none focus:border-green-600 dark:focus:border-green-400">
                @foreach ($formulasOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <div class="mt-3 p-3 bg-green-100 dark:bg-green-800 rounded-md">
                <p class="text-sm text-green-800 dark:text-green-200">
                    <strong>Instrucciones:</strong> Las anualidades son pagos periódicos iguales.
                    Completa todos los campos excepto el que quieres calcular.
                    Deja vacío únicamente el valor que deseas obtener.
                </p>
            </div>
        </div>

        <!-- Campos dinámicos según la fórmula -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @foreach ($camposFormula as $campo => $config)
                @if ($campo === 'frecuencia_S')
                    <!-- Campo especial para frecuencia -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            {{ $config['label'] }}
                        </label>
                        <select wire:model="frecuencia_S"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400">
                            <option value="1">Anual</option>
                            <option value="12">Mensual</option>
                            <option value="4">Trimestral</option>
                            <option value="2">Semestral</option>
                        </select>
                    </div>
                @elseif ($campo === 'tiempo')
                    <!-- Campo especial para períodos -->
                    <div class="flex flex-col md:col-span-2">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $config['label'] }}
                            </label>
                        </div>

                        @if (!$modoTiempoDetallado)
                            <!-- Entrada simple de períodos -->
                            <input wire:model="tiempo_S" type="number" step="1" min="1"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                                placeholder="{{ $config['placeholder'] }}">
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Número de períodos de pago según la frecuencia seleccionada
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Campos numéricos normales -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            {{ $config['label'] }}
                        </label>
                        <input wire:model="{{ $campo }}" type="number" step="0.01"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                            placeholder="{{ $config['placeholder'] }}">
                    </div>
                @endif
            @endforeach

        </div>

        <!-- Información sobre la fórmula actual -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <strong>Fórmula seleccionada:</strong>
                <span class="font-mono text-lg text-gray-900 dark:text-gray-100">
                    @if ($formulaSeleccionada === 'valor_futuro')
                        VF = A x [(1+i)ⁿ - 1] / i
                    @else
                        VP = A x [1 - (1+i)⁻ⁿ] / i
                    @endif
                </span>
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Donde:
                @if ($formulaSeleccionada === 'valor_futuro')
                    VF=Valor Futuro, A=Anualidad, i=Tasa de interés por período, n=Número de períodos
                @else
                    VP=Valor Presente, A=Anualidad, i=Tasa de interés por período, n=Número de períodos
                @endif
            </p>
        </div>

        <button type="submit"
            class="w-full m-2 py-4 bg-gray-900 dark:bg-gray-700 text-white border-0 rounded-2xl text-base font-semibold cursor-pointer transition-all duration-200 hover:bg-gray-700 dark:hover:bg-gray-600 active:scale-[0.98] transform">
            Calcular Campo Vacío
        </button>
    </form>

    <!-- Result Card -->
    @if ($result !== null)
        <div
            class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl p-8 mt-6 shadow-sm transition-colors duration-300">
            <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-8 py-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Resultado</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400 font-mono">
                        @if ($formulaSeleccionada === 'valor_futuro')
                            VF = A x [(1+i)ⁿ - 1] / i
                        @else
                            VP = A x [1 - (1+i)⁻ⁿ] / i
                        @endif
                    </span>
                </div>

                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                    @php
                        // Determinar qué campo se calculó basándose en cuál estaba vacío
                        $camposVacios = [];
                        if ($formulaSeleccionada === 'valor_futuro') {
                            if (is_null($valorFuturoAnualidad)) {
                                $camposVacios[] = 'Valor Futuro';
                            }
                            if (is_null($anualidad)) {
                                $camposVacios[] = 'Anualidad';
                            }
                            if (is_null($tasaInteres_S)) {
                                $camposVacios[] = 'Tasa de Interés';
                            }
                            if (is_null($tiempo_S) && !$modoTiempoDetallado) {
                                $camposVacios[] = 'Número de Períodos';
                            }
                            if (
                                $modoTiempoDetallado &&
                                is_null($tiempo_anos) &&
                                is_null($tiempo_meses) &&
                                is_null($tiempo_dias)
                            ) {
                                $camposVacios[] = 'Número de Períodos';
                            }
                        } else {
                            if (is_null($valorPresenteAnualidad)) {
                                $camposVacios[] = 'Valor Presente';
                            }
                            if (is_null($anualidad)) {
                                $camposVacios[] = 'Anualidad';
                            }
                            if (is_null($tasaInteres_S)) {
                                $camposVacios[] = 'Tasa de Interés';
                            }
                            if (is_null($tiempo_S) && !$modoTiempoDetallado) {
                                $camposVacios[] = 'Número de Períodos';
                            }
                            if (
                                $modoTiempoDetallado &&
                                is_null($tiempo_anos) &&
                                is_null($tiempo_meses) &&
                                is_null($tiempo_dias)
                            ) {
                                $camposVacios[] = 'Número de Períodos';
                            }
                        }

                        $campoCalculado = count($camposVacios) === 1 ? $camposVacios[0] : 'Resultado';
                    @endphp

                    @if (str_contains($campoCalculado, 'Tasa'))
                        {{ number_format($result, 4) }}%
                    @elseif(str_contains($campoCalculado, 'Períodos'))
                        {{ number_format($result, 0) }}
                        @if ($frecuencia_S == 12)
                            períodos mensuales
                        @elseif($frecuencia_S == 4)
                            períodos trimestrales
                        @elseif($frecuencia_S == 2)
                            períodos semestrales
                        @else
                            períodos anuales
                        @endif
                    @else
                        ${{ number_format($result, 2) }}
                    @endif
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $campoCalculado }} calculado exitosamente
                    @if (str_contains($campoCalculado, 'Períodos') && $modoTiempoDetallado)
                        <br><small>(Calculado desde entrada detallada)</small>
                    @endif
                </p>
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mt-4">
            <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    @endif
</div>
