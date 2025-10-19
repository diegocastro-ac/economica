<div>
    <form class="space-y-8" wire:submit.prevent="calcular()">

        <!-- Selector de fórmula -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
            <label class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-3 block">
                Selecciona el tipo de gradiente y cálculo:
            </label>
            <select wire:model.live="formulaSeleccionada"
                class="w-full px-4 py-3 border border-blue-300 dark:border-blue-600 rounded-md text-base text-blue-900 dark:text-blue-100 bg-white dark:bg-blue-800 transition-colors focus:outline-none focus:border-blue-600 dark:focus:border-blue-400">
                @foreach ($formulasOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <!-- Descripción de la fórmula seleccionada -->
            <div class="mt-4 p-4 bg-white dark:bg-blue-800/50 rounded-md border border-blue-200 dark:border-blue-700">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">
                            {{ $descripcionFormula['tipo'] }}
                        </p>
                        <p class="text-xs text-blue-800 dark:text-blue-200 mb-2">
                            {{ $descripcionFormula['explicacion'] }}
                        </p>
                        <div class="bg-blue-100 dark:bg-blue-900/50 rounded px-3 py-2 overflow-x-auto">
                            <code class="text-xs font-mono text-blue-900 dark:text-blue-100 whitespace-nowrap">
                                {{ $descripcionFormula['formula'] }}
                            </code>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 p-3 bg-blue-100 dark:bg-blue-800 rounded-md">
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    <strong>Instrucciones:</strong> Completa todos los campos excepto el que quieres calcular.
                    Deja vacío únicamente el valor que deseas obtener.
                </p>
            </div>
        </div>

        <!-- Advertencia especial para G = i -->
        @if ($advertenciaGIgualI)
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-900 dark:text-amber-100">
                            Caso especial detectado: G = i
                        </p>
                        <p class="text-xs text-amber-800 dark:text-amber-200 mt-1">
                            El sistema utilizará la fórmula simplificada para este caso particular.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Campos dinámicos según la fórmula -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach ($camposFormula as $campo => $config)
                <div class="flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $config['label'] }}
                        </label>
                        @if (isset($variablesInfo[explode('(', explode(' ', $config['label'])[count(explode(' ', $config['label'])) - 1])[0]]))
                            <button type="button" 
                                title="{{ $variablesInfo[explode('(', explode(' ', $config['label'])[count(explode(' ', $config['label'])) - 1])[0]] }}"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <input wire:model="{{ $campo }}" 
                        type="number" 
                        step="0.01"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="{{ $config['placeholder'] }}">
                    @if (isset($config['description']))
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $config['description'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Información sobre variables -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Glosario de variables:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach ($variablesInfo as $variable => $descripcion)
                    <div class="flex items-start space-x-2">
                        <span class="font-mono text-xs font-bold text-blue-600 dark:text-blue-400">{{ $variable }}:</span>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $descripcion }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit"
            class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 dark:from-blue-700 dark:to-indigo-700 dark:hover:from-blue-600 dark:hover:to-indigo-600 text-white border-0 rounded-2xl text-base font-semibold cursor-pointer transition-all duration-200 active:scale-[0.98] transform shadow-lg hover:shadow-xl">
            <span class="flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span>Calcular Campo Vacío</span>
            </span>
        </button>
    </form>

    <!-- Result Card -->
    @if ($result !== null)
        <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl p-8 mt-6 shadow-lg transition-all duration-300 transform hover:shadow-2xl">
            <div class="rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 px-8 py-6 border border-green-200 dark:border-green-800">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 dark:bg-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Resultado</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $descripcionFormula['tipo'] }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-mono text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 py-1 rounded">
                        {{ $campoCalculado }}
                    </span>
                </div>

                <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-3 break-all">
                    {{ $resultadoFormateado }}
                </div>

                <div class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $campoCalculado }} calculado exitosamente</span>
                </div>

            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mt-4 animate-pulse">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold text-red-800 dark:text-red-200">Error en el cálculo</p>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>