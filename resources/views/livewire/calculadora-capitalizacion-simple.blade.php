<div>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        🧮 Calculadora de Capitalización Simple
    </h3>

    <div class="">
        <!-- Mensajes de alerta -->
        @if (session()->has('success'))
        <div class="mb-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <p class="text-sm text-green-700 dark:text-green-300">✓ {{ session('success') }}</p>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="mb-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <p class="text-sm text-red-700 dark:text-red-300">✕ {{ session('error') }}</p>
        </div>
        @endif

        @if (session()->has('info'))
        <div class="mb-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-sm text-blue-700 dark:text-blue-300">ℹ {{ session('info') }}</p>
        </div>
        @endif

        <!-- Mensaje informativo -->
        <div class="mb-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-sm text-blue-700 dark:text-blue-300">
                💡 <strong>¿Cómo usar?</strong> Llena 3 campos y deja vacío el que deseas calcular. Luego presiona "Calcular".
            </p>
        </div>

        <!-- Formulario de entrada -->
        <div class="space-y-4">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Capital Inicial -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Capital Inicial ($)
                        @if($campoACalcular === 'capital' && $resultadoCalculado)
                        <span class="text-green-600 dark:text-green-400 ml-2">✓ Calculado</span>
                        @endif
                    </label>
                    <input
                        type="number"
                        wire:model="capital"
                        step="0.01"
                        class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'capital' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ej: 10000"
                        @if($resultadoCalculado) readonly @endif>
                </div>

                <!-- Tasa de Interés -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Tasa de Interés (%)
                        @if($campoACalcular === 'tasaInteres' && $resultadoCalculado)
                        <span class="text-green-600 dark:text-green-400 ml-2">✓ Calculado</span>
                        @endif
                    </label>
                    <input
                        type="number"
                        wire:model="tasaInteres"
                        step="0.01"
                        class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'tasaInteres' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ej: 5"
                        @if($resultadoCalculado) readonly @endif>
                </div>
            </div>

            <!-- Tiempo - Años, Meses y Días -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Tiempo
                    @if($campoACalcular === 'tiempo' && $resultadoCalculado)
                    <span class="text-green-600 dark:text-green-400 ml-2">✓ Calculado</span>
                    @endif
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <input
                            type="number"
                            wire:model="tiempoAnios"
                            step="1"
                            min="0"
                            class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'tiempo' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Años"
                            @if($resultadoCalculado) readonly @endif>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-center">Años</p>
                    </div>
                    <div>
                        <input
                            type="number"
                            wire:model="tiempoMeses"
                            step="1"
                            min="0"
                            max="11"
                            class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'tiempo' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Meses"
                            @if($resultadoCalculado) readonly @endif>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-center">Meses</p>
                    </div>
                    <div>
                        <input
                            type="number"
                            wire:model="tiempoDias"
                            step="1"
                            min="0"
                            max="29"
                            class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'tiempo' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Días"
                            @if($resultadoCalculado) readonly @endif>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-center">Días</p>
                    </div>
                </div>
                @if(($tiempoAnios > 0 || $tiempoMeses > 0 || $tiempoDias > 0) && $tiempo > 0)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    ≈ {{ number_format($tiempo, 6) }} años decimales
                </p>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Frecuencia de Capitalización -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Frecuencia de Capitalización
                    </label>
                    <select
                        wire:model="frecuencia"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        @if($resultadoCalculado) disabled @endif>
                        <option value="anual">Anual</option>
                        <option value="semestral">Semestral</option>
                        <option value="trimestral">Trimestral</option>
                        <option value="mensual">Mensual</option>
                        <option value="diaria">Diaria (base 360)</option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Selecciona cómo se aplicará el interés
                    </p>
                </div>

                <!-- Monto Final -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Monto Final ($)
                        @if($campoACalcular === 'montoFinal' && $resultadoCalculado)
                        <span class="text-green-600 dark:text-green-400 ml-2">✓ Calculado</span>
                        @endif
                    </label>
                    <input
                        type="number"
                        wire:model="montoFinal"
                        step="0.01"
                        class="w-full px-4 py-3 rounded-lg border {{ $campoACalcular === 'montoFinal' && $resultadoCalculado ? 'border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800' }} text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ej: 11500"
                        @if($resultadoCalculado) readonly @endif>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4 justify-center mt-6">
                <button
                    wire:click="calcular"
                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    🧮 Calcular
                </button>

                <button
                    wire:click="limpiarTodo"
                    class="px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    🗑️ Limpiar Todo
                </button>
            </div>
        </div>

        <!-- Resultados -->
        @if($resultadoCalculado && $campoACalcular)
        <div class="mt-8">
            <!-- Tarjetas de Resultados -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <!-- Primera Tarjeta: Variable Calculada -->
                <div class="bg-gradient-to-br from-green-600 to-emerald-800 dark:from-green-700 dark:to-emerald-900 rounded-xl p-6 shadow-lg">
                    <p class="text-purple-200 dark:text-purple-300 text-sm mb-2">
                        @if($campoACalcular === 'capital')
                        Capital Inicial
                        @elseif($campoACalcular === 'montoFinal')
                        Monto Final
                        @elseif($campoACalcular === 'tasaInteres')
                        Tasa de Interés
                        @elseif($campoACalcular === 'tiempo')
                        Tiempo
                        @endif
                    </p>
                    <p class="text-white text-4xl font-bold">
                        @if($campoACalcular === 'capital')
                        ${{ number_format($capital, 2) }}
                        @elseif($campoACalcular === 'montoFinal')
                        ${{ number_format($montoFinal, 2) }}
                        @elseif($campoACalcular === 'tasaInteres')
                        {{ number_format($tasaInteres, 2) }}%
                        @elseif($campoACalcular === 'tiempo')
                        @if($tiempoAnios > 0) {{ $tiempoAnios }}a @endif
                        @if($tiempoMeses > 0) {{ $tiempoMeses }}m @endif
                        @if($tiempoDias > 0) {{ $tiempoDias }}d @endif
                        @endif
                    </p>
                </div>

                <!-- Segunda Tarjeta: Interés Total -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 rounded-xl p-6 shadow-lg">
                    <p class="text-blue-200 dark:text-blue-300 text-sm mb-2">Interés Total Ganado</p>
                    <p class="text-white text-4xl font-bold">
                        ${{ number_format($interesTotal, 2) }}
                    </p>
                </div>

                <!-- Tercera Tarjeta: Desglose por Año -->
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 dark:from-slate-800 dark:to-slate-950 rounded-xl p-6 shadow-lg">
                    <p class="text-slate-300 dark:text-slate-400 text-sm mb-3">Desglose por Año</p>
                    <div class="space-y-2 max-h-32 overflow-y-auto">
                        @if($capital && $tasaInteres && $tiempo > 0)
                        @for($i = 1; $i <= min(floor($tiempo), 10); $i++)
                            @php
                            $montoAnio=$capital * (1 + (($tasaInteres / 100) * $i));
                            @endphp
                            <div class="flex justify-between text-white text-sm">
                            <span>Año {{ $i }}:</span>
                            <span class="font-semibold">${{ number_format($montoAnio, 2) }}</span>
                    </div>
                    @endfor

                    @if(floor($tiempo) >= 1 && ($tiempoMeses > 0 || $tiempoDias > 0))
                    <div class="flex justify-between text-white text-sm border-t border-slate-600 pt-2 mt-2">
                        <span>Año {{ floor($tiempo) }}
                            @if($tiempoMeses > 0)+{{ $tiempoMeses }}m @endif
                            @if($tiempoDias > 0)+{{ $tiempoDias }}d @endif:
                        </span>
                        <span class="font-semibold">${{ number_format($montoFinal, 2) }}</span>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

        </div>

        <!-- Información Adicional -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Capital Inicial:</p>
                    <p class="text-gray-900 dark:text-gray-100 font-semibold">${{ number_format($capital, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Monto Final:</p>
                    <p class="text-gray-900 dark:text-gray-100 font-semibold">${{ number_format($montoFinal, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Tasa de Interés:</p>
                    <p class="text-gray-900 dark:text-gray-100 font-semibold">{{ number_format($tasaInteres, 2) }}% anual</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Tiempo:</p>
                    <p class="text-gray-900 dark:text-gray-100 font-semibold">
                        @if($tiempoAnios > 0) {{ $tiempoAnios }} {{ $tiempoAnios == 1 ? 'año' : 'años' }} @endif
                        @if($tiempoMeses > 0) {{ $tiempoMeses }} {{ $tiempoMeses == 1 ? 'mes' : 'meses' }} @endif
                        @if($tiempoDias > 0) {{ $tiempoDias }} {{ $tiempoDias == 1 ? 'día' : 'días' }} @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Frecuencia:</p>
                    <p class="text-gray-900 dark:text-gray-100 font-semibold">
                        @switch($frecuencia)
                        @case('diaria') Diaria @break
                        @case('mensual') Mensual @break
                        @case('trimestral') Trimestral @break
                        @case('semestral') Semestral @break
                        @case('anual') Anual @break
                        @endswitch
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400">Campo Calculado:</p>
                    <p class="text-green-600 dark:text-green-400 font-semibold">
                        @if($campoACalcular === 'capital') Capital Inicial
                        @elseif($campoACalcular === 'montoFinal') Monto Final
                        @elseif($campoACalcular === 'tasaInteres') Tasa de Interés
                        @elseif($campoACalcular === 'tiempo') Tiempo
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Fórmula utilizada -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📐 Fórmula utilizada (Interés Simple):</p>
            @if($campoACalcular === 'montoFinal')
            <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm overflow-x-auto">
                M = C × (1 + i × t)<br>
                M = {{ number_format($capital, 2) }} × (1 + {{ number_format($tasaInteres / 100, 6) }} × {{ number_format($tiempo, 6) }})<br>
                M = ${{ number_format($montoFinal, 2) }}
            </code>
            @elseif($campoACalcular === 'capital')
            <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm overflow-x-auto">
                C = M / (1 + i × t)<br>
                C = {{ number_format($montoFinal, 2) }} / (1 + {{ number_format($tasaInteres / 100, 6) }} × {{ number_format($tiempo, 6) }})<br>
                C = ${{ number_format($capital, 2) }}
            </code>
            @elseif($campoACalcular === 'tasaInteres')
            <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm overflow-x-auto">
                i = [(M/C) - 1] / t<br>
                i = [({{ number_format($montoFinal, 2) }}/{{ number_format($capital, 2) }}) - 1] / {{ number_format($tiempo, 6) }}<br>
                i = {{ number_format($tasaInteres, 6) }}%
            </code>
            @elseif($campoACalcular === 'tiempo')
            <code class="block bg-white dark:bg-gray-900 p-3 rounded text-gray-900 dark:text-gray-100 font-mono text-sm overflow-x-auto">
                t = [(M/C) - 1] / i<br>
                t = [({{ number_format($montoFinal, 2) }}/{{ number_format($capital, 2) }}) - 1] / {{ number_format($tasaInteres / 100, 6) }}<br>
                t = {{ number_format($tiempo, 6) }} años
            </code>
            @endif
        </div>
    </div>
    @endif
</div>
</div>

</div>