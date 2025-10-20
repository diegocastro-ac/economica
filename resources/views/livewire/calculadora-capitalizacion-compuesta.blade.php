<div>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        🧮 Calculadora de Capitalización Compuesta
    </h3>

    <div class="">
        <!-- Formulario -->
        <div class="space-y-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Capital Inicial ($)
                </label>
                <input 
                    type="number" 
                    wire:model.live="capital"
                    step="100"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Tasa de Interés Anual (%)
                </label>
                <input 
                    type="number" 
                    wire:model.live="tasaInteres"
                    step="0.1"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Tiempo (años)
                </label>
                <input 
                    type="number" 
                    wire:model.live="tiempo"
                    step="1"
                    min="1"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Frecuencia de Capitalización
                </label>
                <select 
                    wire:model.live="frecuencia"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="1">Anual (1 vez al año)</option>
                    <option value="2">Semestral (2 veces al año)</option>
                    <option value="4">Trimestral (4 veces al año)</option>
                    <option value="12">Mensual (12 veces al año)</option>
                    <option value="360">Diaria (360 veces al año)</option>
                </select>
            </div>
        </div>

        <!-- Resultados -->
        <div class="mt-6 space-y-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/40 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                <p class="text-sm text-purple-700 dark:text-purple-300 mb-2">Monto Final</p>
                <p class="text-4xl font-bold text-purple-900 dark:text-purple-100">
                    ${{ number_format($montoFinal, 2) }}
                </p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/40 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-2">Interés Total Ganado</p>
                <p class="text-4xl font-bold text-blue-900 dark:text-blue-100">
                    ${{ number_format($interesTotal, 2) }}
                </p>
            </div>

            <div class="bg-gradient-to-br from-orange-50 to-amber-50 dark:from-orange-900/30 dark:to-amber-900/40 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                <p class="text-sm text-orange-700 dark:text-orange-300 mb-2">Desglose por Año</p>
                <div class="space-y-2 text-sm">
                    @for($i = 1; $i <= $tiempo; $i++)
                        @php
                            $montoAnio = $capital * pow((1 + (($tasaInteres / 100) / $frecuencia)), ($frecuencia * $i));
                        @endphp
                        <div class="flex justify-between text-orange-800 dark:text-orange-200">
                            <span>Año {{ $i }}:</span>
                            <span class="font-bold">${{ number_format($montoAnio, 2) }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Fórmula -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📐 Fórmula utilizada:</p>
        <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm">
            M = {{ number_format($capital, 2) }} × (1 + {{ $tasaInteres / 100 }} / {{ $frecuencia }})^({{ $frecuencia }} × {{ $tiempo }}) = ${{ number_format($montoFinal, 2) }}
        </code>
    </div>
</div>
