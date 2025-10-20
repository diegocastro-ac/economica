<div>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        🧮 Calculadora de Capitalización Continua
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
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Tasa de Interés Anual (%)
                </label>
                <input 
                    type="number" 
                    wire:model.live="tasaInteres"
                    step="0.1"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
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
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>

            <!-- Info sobre e -->
            <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4 border border-teal-200 dark:border-teal-800">
                <p class="text-sm text-teal-800 dark:text-teal-300">
                    <strong>ℹ️ Número de Euler (e):</strong> 2.71828...
                </p>
                <p class="text-xs text-teal-700 dark:text-teal-400 mt-1">
                    Esta constante matemática se usa para capitalización continua
                </p>
            </div>
        </div>

        <!-- Resultados -->
        <div class="space-y-4 grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/30 dark:to-cyan-900/40 rounded-xl p-6 border border-teal-200 dark:border-teal-800">
                <p class="text-sm text-teal-700 dark:text-teal-300 mb-2">Monto Final</p>
                <p class="text-4xl font-bold text-teal-900 dark:text-teal-100">
                    ${{ number_format($montoFinal, 2) }}
                </p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/40 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-2">Interés Total Ganado</p>
                <p class="text-4xl font-bold text-blue-900 dark:text-blue-100">
                    ${{ number_format($interesTotal, 2) }}
                </p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/40 rounded-xl p-6 border border-green-200 dark:border-green-800">
                <p class="text-sm text-green-700 dark:text-green-300 mb-2">Desglose por Año</p>
                <div class="space-y-2 text-sm">
                    @for($i = 1; $i <= $tiempo; $i++)
                        @php
                            $montoAnio = $capital * exp(($tasaInteres / 100) * $i);
                        @endphp
                        <div class="flex justify-between text-green-800 dark:text-green-200">
                            <span>Año {{ $i }}:</span>
                            <span class="font-bold">${{ number_format($montoAnio, 2) }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Comparación con compuesta -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/30 dark:to-orange-900/40 rounded-xl p-4 border border-yellow-200 dark:border-yellow-800">
                @php
                    $montoCompuesta = $capital * pow((1 + ($tasaInteres / 100)), $tiempo);
                    $diferencia = $montoFinal - $montoCompuesta;
                @endphp
                <p class="text-sm text-yellow-800 dark:text-yellow-200 mb-2">
                    <strong>💡 vs Capitalización Compuesta Anual:</strong>
                </p>
                <p class="text-xs text-yellow-700 dark:text-yellow-300">
                    Ganancia adicional: ${{ number_format($diferencia, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Fórmula -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📐 Fórmula utilizada:</p>
        <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm">
            M = {{ number_format($capital, 2) }} × e^({{ $tasaInteres / 100 }} × {{ $tiempo }}) = ${{ number_format($montoFinal, 2) }}
        </code>
    </div>
</div>
