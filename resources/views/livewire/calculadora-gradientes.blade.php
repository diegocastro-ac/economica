<div>
    <form class="space-y-8" wire:submit.prevent="calcular()">

        <!-- Selector de tipo de gradiente -->
        <div
            class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-6 mb-6">
            <label class="text-sm font-medium text-purple-900 dark:text-purple-100 mb-3 block">
                Selecciona el tipo de gradiente:
            </label>
            <select wire:model.live="tipoGradiente"
                class="w-full px-4 py-3 border border-purple-300 dark:border-purple-600 rounded-md text-base text-purple-900 dark:text-purple-100 bg-white dark:bg-purple-800 transition-colors focus:outline-none focus:border-purple-600 dark:focus:border-purple-400">
                @foreach ($tiposGradienteOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <div class="mt-4 p-4 bg-purple-100 dark:bg-purple-800 rounded-md">
                <p class="text-sm text-purple-800 dark:text-purple-200 font-semibold mb-2">
                    {{ $formulaInfo['titulo'] }}
                </p>
                <p class="text-sm text-purple-700 dark:text-purple-300 mb-3">
                    {{ $formulaInfo['descripcion'] }}
                </p>
                <p class="text-xs text-purple-600 dark:text-purple-400 italic">
                    {{ $formulaInfo['ejemplo'] }}
                </p>
            </div>

            <div class="mt-3 p-3 bg-purple-100 dark:bg-purple-800 rounded-md border-l-4 border-purple-500">
                <p class="text-sm text-purple-800 dark:text-purple-200">
                    <strong>Instrucciones:</strong> Completa todos los campos excepto el que quieres calcular.
                    Deja vacío únicamente el valor que deseas obtener. Los campos de tasa de interés y número de
                    períodos son siempre obligatorios.
                    El único caso que se pueden dejar dos campos vacíos es VP y VF, que se pueden calcular ambos a la
                    vez.
                </p>
            </div>
        </div>

        <!-- Campos dinámicos según el tipo de gradiente -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @foreach ($camposFormula as $campo => $config)
                <div class="flex flex-col @if (isset($config['required']) && $config['required']) md:col-span-2 @endif">
                    <label
                        class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2 flex items-center justify-between">
                        <span>
                            {{ $config['label'] }}
                            @if (isset($config['required']) && $config['required'])
                                <span class="text-red-500 ml-1">*</span>
                            @endif
                        </span>

                        @if (isset($config['help']))
                            <span class="text-xs text-gray-500 dark:text-gray-400 italic ml-2"
                                title="{{ $config['help'] }}">
                                ℹ️
                            </span>
                        @endif
                    </label>

                    @if ($campo === 'numeroPeriodos_G')
                        <!-- Campo especial para períodos (solo enteros) -->
                        <input wire:model="{{ $campo }}" type="number" step="1" min="1"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400 @if (isset($config['required']) && $config['required']) ring-2 ring-purple-200 dark:ring-purple-700 @endif"
                            placeholder="{{ $config['placeholder'] }}"
                            @if (isset($config['required']) && $config['required']) required @endif>
                    @else
                        <!-- Campos numéricos normales -->
                        <input wire:model="{{ $campo }}" type="number" step="0.01"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400 @if (isset($config['required']) && $config['required']) ring-2 ring-purple-200 dark:ring-purple-700 @endif"
                            placeholder="{{ $config['placeholder'] }}"
                            @if (isset($config['required']) && $config['required']) required @endif>
                    @endif

                    @if (isset($config['help']))
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $config['help'] }}
                        </p>
                    @endif
                </div>
            @endforeach

        </div>

        <!-- Información sobre las fórmulas -->
        <div
            class="bg-gradient-to-r from-gray-50 to-purple-50 dark:from-gray-800 dark:to-purple-900/30 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 mt-1">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Fórmulas utilizadas:
                    </p>
                    <div class="space-y-2">
                        <div
                            class="bg-white dark:bg-gray-900 rounded px-3 py-2 font-mono text-xs text-gray-800 dark:text-gray-200 overflow-x-auto">
                            {{ $formulaInfo['formula_vp'] }}
                        </div>
                        @if (isset($formulaInfo['formula_vp_especial']))
                            <div
                                class="bg-yellow-50 dark:bg-yellow-900/20 rounded px-3 py-2 font-mono text-xs text-yellow-800 dark:text-yellow-200 overflow-x-auto border border-yellow-300 dark:border-yellow-700">
                                <span class="font-semibold">Caso especial:</span>
                                {{ $formulaInfo['formula_vp_especial'] }}
                            </div>
                        @endif
                        <div
                            class="bg-white dark:bg-gray-900 rounded px-3 py-2 font-mono text-xs text-gray-800 dark:text-gray-200 overflow-x-auto">
                            {{ $formulaInfo['formula_vf'] }}
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-3">
                        <strong>Donde:</strong> {{ $formulaInfo['variables'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Botón de cálculo -->
        <button type="submit"
            class="w-full py-4 bg-gradient-to-r from-purple-600 to-purple-800 dark:from-purple-700 dark:to-purple-900 text-white border-0 rounded-2xl text-base font-semibold cursor-pointer transition-all duration-200 hover:from-purple-700 hover:to-purple-900 dark:hover:from-purple-600 dark:hover:to-purple-800 active:scale-[0.98] transform shadow-lg hover:shadow-xl">
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Calcular Campo Vacío
            </span>
        </button>
    </form>

    <!-- Result Card -->
    @if ($result !== null || ($resultVP !== null && $resultVF !== null))
        <div
            class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl p-8 mt-6 shadow-lg transition-all duration-300 animate-fadeIn">
            <div
                class="rounded-2xl bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/30 dark:to-blue-900/30 px-8 py-6 border border-purple-200 dark:border-purple-700">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Resultado del Cálculo
                    </h3>
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-200">
                        {{ $this->getTipoGradienteFormato() }}
                    </span>
                </div>

                @php
                    $campoCalculado = $this->getCampoCalculado();
                    $formato = $this->getFormatoResultado();
                @endphp

                <!-- Caso: Ambos VP y VF calculados -->
                @if ($resultVP !== null && $resultVF !== null)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- VP -->
                        <div
                            class="text-center py-6 bg-white dark:bg-gray-900 rounded-xl border border-purple-200 dark:border-purple-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Valor Presente
                            </p>
                            <div
                                class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-purple-400 dark:from-purple-400 dark:to-purple-300 bg-clip-text text-transparent mb-2">
                                ${{ number_format($resultVP, 2) }}
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                VP calculado
                            </p>
                        </div>

                        <!-- VF -->
                        <div
                            class="text-center py-6 bg-white dark:bg-gray-900 rounded-xl border border-blue-200 dark:border-blue-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Valor Futuro
                            </p>
                            <div
                                class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 dark:from-blue-400 dark:to-blue-300 bg-clip-text text-transparent mb-2">
                                ${{ number_format($resultVF, 2) }}
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                VF calculado
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                        <p><strong>Ambos valores calculados exitosamente</strong></p>
                    </div>
                @else
                    <!-- Caso: Un solo campo calculado -->
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            {{ $campoCalculado }}
                        </p>
                        <div
                            class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 bg-clip-text text-transparent mb-2">
                            @if ($formato['tipo'] === 'porcentaje')
                                {{ number_format($result, $formato['decimales']) }}%
                            @else
                                ${{ number_format($result, $formato['decimales']) }}
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Calculado exitosamente
                        </p>
                    </div>
                @endif

                <!-- Detalles del cálculo -->
                <div class="mt-6 pt-4 border-t border-purple-200 dark:border-purple-700">
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Parámetros utilizados:
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        @if ($tasaInteres_G !== null)
                            <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tasa de Interés</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ number_format($tasaInteres_G, 2) }}%</p>
                            </div>
                        @endif

                        @if ($numeroPeriodos_G !== null)
                            <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Períodos</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $numeroPeriodos_G }}</p>
                            </div>
                        @endif

                        @if ($tipoGradiente === 'aritmetico')
                            @if ($pagoBase_A !== null && $campoCalculado !== 'Pago Base')
                                <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pago Base</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($pagoBase_A, 2) }}</p>
                                </div>
                            @endif

                            @if ($gradienteAritmetico_A !== null && $campoCalculado !== 'Gradiente Aritmético')
                                <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Gradiente</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $gradienteAritmetico_A >= 0 ? '+' : '' }}${{ number_format($gradienteAritmetico_A, 2) }}
                                    </p>
                                </div>
                            @endif
                        @else
                            @if ($pagoInicial_Geo !== null && $campoCalculado !== 'Pago Inicial')
                                <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pago Inicial</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($pagoInicial_Geo, 2) }}</p>
                                </div>
                            @endif

                            @if ($tasaCrecimiento_Geo !== null && $campoCalculado !== 'Tasa de Crecimiento')
                                <div class="bg-white dark:bg-gray-900 rounded-lg px-3 py-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Tasa Crecimiento</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ number_format($tasaCrecimiento_Geo, 2) }}%</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Interpretación del resultado -->
                <div
                    class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700">
                    <p class="text-xs text-blue-800 dark:text-blue-200">
                        <strong>💡 Interpretación:</strong>
                        @if (str_contains($campoCalculado, 'Valor Presente'))
                            El valor actual de la serie de pagos
                            {{ $tipoGradiente === 'aritmetico' ? 'con incremento aritmético' : 'con crecimiento geométrico' }}
                            es de
                            <strong>${{ number_format($result, 2) }}</strong>.
                        @elseif(str_contains($campoCalculado, 'Valor Futuro'))
                            El valor futuro de la serie de pagos
                            {{ $tipoGradiente === 'aritmetico' ? 'con incremento aritmético' : 'con crecimiento geométrico' }}
                            será de
                            <strong>${{ number_format($result, 2) }}</strong>.
                        @elseif(str_contains($campoCalculado, 'Pago'))
                            El {{ $tipoGradiente === 'aritmetico' ? 'pago base' : 'pago inicial' }} necesario es de
                            <strong>${{ number_format($result, 2) }}</strong>.
                        @elseif(str_contains($campoCalculado, 'Gradiente'))
                            El incremento {{ $result >= 0 ? 'positivo' : 'negativo' }} por período es de
                            <strong>${{ number_format(abs($result), 2) }}</strong>.
                        @elseif(str_contains($campoCalculado, 'Crecimiento'))
                            La tasa de crecimiento geométrico es de
                            <strong>{{ number_format($result, 4) }}%</strong> por período.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 rounded-lg p-4 mt-6 shadow-md animate-shake">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500 dark:text-red-400 mt-0.5" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Error en el cálculo</h3>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Estilos CSS en línea para animaciones -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }
    </style>
</div>
