<div>
    <form class="space-y-8" wire:submit.prevent="calcular()">

        <!-- Selector de sistema -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-6">
            <label class="text-sm font-medium text-green-900 dark:text-green-100 mb-3 block">
                Selecciona el sistema de amortización:
            </label>
            <select wire:model.live="sistemaSeleccionado"
                class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-md text-base text-green-900 dark:text-green-100 bg-white dark:bg-green-800 transition-colors focus:outline-none focus:border-green-600 dark:focus:border-green-400">
                @foreach ($sistemasOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>



            <div class="mt-3 p-3 bg-green-100 dark:bg-green-800 rounded-md border-l-4 border-green-500">
                <p class="text-sm text-green-800 dark:text-green-200">
                    <strong>Instrucciones:</strong> Completa los tres campos obligatorios (Capital, Tasa, Períodos)
                    y presiona calcular para generar la tabla de amortización.
                </p>
            </div>
        </div>

        <!-- Campos de entrada -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($camposFormula as $campo => $config)
                <div class="flex flex-col">
                    <label
                        class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2 flex items-center justify-between">
                        <span>
                            {{ $config['label'] }}
                            @if ($config['required'])
                                <span class="text-red-500 ml-1">*</span>
                            @endif
                        </span>

                    </label>

                    @if ($campo === 'numeroPeriodos_A')
                        <input wire:model="{{ $campo }}" type="number" step="1" min="1"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400 ring-2 ring-green-200 dark:ring-green-700"
                            placeholder="{{ $config['placeholder'] }}" required>
                    @else
                        <input wire:model="{{ $campo }}" type="number" step="0.01" min="0"
                            class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400 ring-2 ring-green-200 dark:ring-green-700"
                            placeholder="{{ $config['placeholder'] }}" required>
                    @endif

                    @if (isset($config['help']))
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $config['help'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Validación de errores -->
        @if ($erroresValidacion)
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border-l-4 border-yellow-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            {{ $erroresValidacion }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Botón de cálculo -->
        <button type="submit"
            class="w-full py-4 bg-gradient-to-r from-green-600 to-green-800 dark:from-green-700 dark:to-green-900 text-white border-0 rounded-2xl text-base font-semibold cursor-pointer transition-all duration-200 hover:from-green-700 hover:to-green-900 dark:hover:from-green-600 dark:hover:to-green-800 active:scale-[0.98] transform shadow-lg hover:shadow-xl">
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Generar Tabla de Amortización
            </span>
        </button>
    </form>

    <!-- Tabla de amortización -->
    @if (!empty($tabla))
        <div
            class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
            <div
                class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-900/20 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Tabla de Amortización - {{ $descripcionSistema['nombre'] }}
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 border-b-2 border-gray-300 dark:border-gray-600">
                            <th class="px-4 py-3 text-left font-semibold text-gray-900 dark:text-gray-100">
                                Período
                            </th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                Capital Inicial
                            </th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                Amortización
                            </th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                Intereses
                            </th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                Cuota
                            </th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                Capital Pendiente
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tabla as $fila)
                            @if (isset($fila['es_total']) && $fila['es_total'])
                                <tr
                                    class="bg-green-50 dark:bg-green-900/20 border-t-2 border-green-300 dark:border-green-700 font-bold">
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $fila['periodo'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-600 dark:text-gray-400">
                                        -
                                    </td>
                                    <td class="px-4 py-3 text-right text-green-700 dark:text-green-300">
                                        {{ $formatoMoneda($fila['amortizacion']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-green-700 dark:text-green-300">
                                        {{ $formatoMoneda($fila['interes']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-green-700 dark:text-green-300">
                                        {{ $formatoMoneda($fila['cuota']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-600 dark:text-gray-400">
                                        -
                                    </td>
                                </tr>
                            @else
                                <tr
                                    class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $fila['periodo'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $formatoMoneda($fila['capital_inicial']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400 font-mono">
                                        {{ $formatoMoneda($fila['amortizacion']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-purple-600 dark:text-purple-400 font-mono">
                                        {{ $formatoMoneda($fila['interes']) }}
                                    </td>
                                    <td
                                        class="px-4 py-3 text-right text-green-600 dark:text-green-400 font-mono font-bold">
                                        {{ $formatoMoneda($fila['cuota']) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-red-600 dark:text-red-400 font-mono">
                                        {{ $formatoMoneda($fila['capital_pendiente']) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div
            class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 rounded-lg p-4 mt-6 shadow-md animate-shake">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500 dark:text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
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

    <style>
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

        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }
    </style>
</div>
