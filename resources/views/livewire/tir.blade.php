<div class=" mx-auto">

    {{-- Fórmulas de referencia --}}
    <div class="mt-8 bg-gray-50 dark:bg-gray-900 rounded-xl p-6 border border-gray-300 dark:border-gray-600 mb-8">
        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
            <span class="mr-2">📐</span>
            Fórmulas de Apoyo
        </h4>
        <div class="space-y-3 text-xs text-gray-400 dark:text-gray-100">
            <div class="bg-white dark:bg-gray-700 p-3 rounded-lg">
                <p class="font-semibold mb-1 dark:text-blue-500">Ecuación Fundamental (VPN):</p>
                <p class="font-mono">VPN = -C₀ + Σ [FC_t / (1 + k)^t]</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-3 rounded-lg">
                <p class="font-semibold mb-1">Newton-Raphson (TIR):</p>
                <p class="font-mono">TIR_n+1 = TIR_n - VPN(TIR_n) / VPN'(TIR_n)</p>
            </div>
        </div>
    </div>

    {{-- Mensajes flash --}}
    @if (session()->has('error'))
    <div class="mb-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    @if (session()->has('success'))
    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    {{-- Selector de tipo de cálculo --}}
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        🧮 Calculadora de TIR
    </h3>
    </div>

    {{-- Inputs principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border border-gray-300 dark:border-gray-600 rounded-xl">
        {{-- Capital Inicial --}}
        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 border-2 border-gray-300 dark:border-gray-600">
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Capital Inicial
            </label>
            <input type="number" wire:model="capitalInicial" step="0.01" placeholder="Ingrese el capital inicial"
                class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        {{-- Frecuencia - Tasa K --}}
        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 border-2 border-gray-300 dark:border-gray-600">
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Tasa minima requerida - k (%)
            </label>
            <input type="number" wire:model="tasaK" step="0.01" placeholder="Ingrese la tasa"
                class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @if($calculationType === 'tir')
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 italic">
                * Opcional: ingresa tasa requerida para evaluar el proyecto
            </p>
            @endif
        </div>
    </div>

    {{-- Períodos --}}
    <div class="space-y-4 mb-6 ">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Período - Flujos de Caja
            </h3>
        </div>

        @foreach($periodos as $index => $periodo)
        <div class="bg-gray-50 dark:bg-gray-900 p-4  border border-gray-300 dark:border-gray-600 rounded-xl mb-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Período {{ $periodo['periodo'] }}
                </h4>
                @if(count($periodos) > 1)
                <button wire:click="eliminarPeriodo({{ $index }})" type="button"
                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors p-1"
                    title="Botón para borrar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
                <div>
                    <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">
                        Período {{ $index + 1 }}
                    </label>
                    <input type="text" value="{{ $periodo['periodo'] }}" disabled
                        class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">
                        Flujo de Caja
                    </label>
                    <input type="number" wire:model="periodos.{{ $index }}.flujo" step="0.01"
                        placeholder="Ingrese el flujo"
                        class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>
        @endforeach

        {{-- Botón agregar período --}}
        <button wire:click="agregarPeriodo" type="button"
            class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Período
        </button>
    </div>

    {{-- Botones de acción --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 ">
        <button wire:click="calcular" type="button"
            class="border border-gray-300 dark:border-gray-600 rounded-xl py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-dark font-bold  shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            Calcular {{ strtoupper($calculationType) }}
        </button>
        <button wire:click="limpiar" type="button"
            class="border border-gray-300 dark:border-gray-600 rounded-xl py-4 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-dark font-bold shadow-lg hover:shadow-xl transition-all duration-200">
            Limpiar
        </button>
    </div>

    {{-- Resultado - Indicadores de Rentabilidad --}}
    @if($resultado)
        <div
            class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/30 rounded-2xl p-6 border-2 border-green-300 dark:border-green-700 shadow-xl">
            <div class="flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">
                    Indicadores de Rentabilidad
                </h3>
            </div>

            {{-- Grid de indicadores --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- TIR --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 border-2 border-gray-300 dark:border-gray-600 shadow-lg">
                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2 uppercase tracking-wide">
                            TIR
                        </p>
                        <p class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">
                            {{ number_format($resultado['tir'], 2) }}%
                        </p>
                        @if(!empty($tasaK))
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                @if($resultado['tir'] > floatval($tasaK))
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-semibold">Rentable</span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                        TIR > Tasa requerida ({{ number_format($tasaK, 2) }}%)
                                    </p>
                                @else
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-semibold">No Rentable</span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                        TIR < Tasa requerida ({{ number_format($tasaK, 2) }}%)
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- VAN/VPN --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 border-2 border-gray-300 dark:border-gray-600 shadow-lg">
                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2 uppercase tracking-wide">
                            VAN
                        </p>
                        <p class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-3">
                            ${{ number_format($resultado['van'], 2) }}
                        </p>
                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                            @if($resultado['van'] > 0)
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-semibold">Crea Valor</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                    VAN positivo - Proyecto aceptable
                                </p>
                            @elseif($resultado['van'] < 0)
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-semibold">Destruye Valor</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                    VAN negativo - Proyecto rechazable
                                </p>
                            @else
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    <span class="text-xs font-semibold">Punto de Equilibrio</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                    VAN = 0 - Indiferente
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de Flujos de Caja --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border-2 border-gray-300 dark:border-gray-700 overflow-hidden mt-6">
                <div class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b-2 border-gray-300 dark:border-gray-600">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            Tabla de Flujos de Caja
                        </h3>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                        Detalle período por período de los flujos de caja y su valor presente
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-green-100 dark:bg-green-900/30 border-b-2 border-green-300 dark:border-green-700">
                                <th class="px-4 py-3 text-left text-sm font-bold text-green-900 dark:text-green-200 uppercase tracking-wider">
                                    Período
                                </th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-green-900 dark:text-green-200 uppercase tracking-wider">
                                    Flujo de Caja
                                </th>
                                <th class="px-4 py-3 text-center text-sm font-bold text-green-900 dark:text-green-200 uppercase tracking-wider">
                                    Factor de Descuento
                                </th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-green-900 dark:text-green-200 uppercase tracking-wider">
                                    Valor Presente
                                </th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-green-900 dark:text-green-200 uppercase tracking-wider">
                                    VP Acumulado
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($resultado['tablaFlujos']['filas'] as $fila)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors
                                    @if($fila['periodo'] == 0) bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 @endif
                                    @if($fila['vpAcumulado'] >= 0 && $fila['periodo'] > 0) bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 dark:border-green-400 @endif">
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $fila['periodo'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right font-medium
                                        @if($fila['flujo'] < 0) text-red-600 dark:text-red-400 @else text-green-600 dark:text-green-400 @endif">
                                        ${{ number_format($fila['flujo'], 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-700 dark:text-gray-300 font-mono">
                                        {{ number_format($fila['factorDescuento'], 6) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right font-medium
                                        @if($fila['valorPresente'] < 0) text-red-600 dark:text-red-400 @else text-gray-700 dark:text-gray-300 @endif">
                                        ${{ number_format($fila['valorPresente'], 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right font-bold
                                        @if($fila['vpAcumulado'] < 0) text-red-600 dark:text-red-400 @else text-green-600 dark:text-green-400 @endif">
                                        ${{ number_format($fila['vpAcumulado'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-green-200 dark:bg-green-900/50 border-t-2 border-green-400 dark:border-green-600">
                                <td class="px-4 py-3 text-sm font-bold text-green-900 dark:text-green-900 uppercase">
                                    TOTALES
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-bold text-green-900 dark:text-green-900">
                                    ${{ number_format($resultado['tablaFlujos']['totales']['flujos'], 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-green-900 dark:text-green-900 font-bold">
                                    --
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-bold text-green-900 dark:text-green-900">
                                    ${{ number_format($resultado['tablaFlujos']['totales']['valorPresente'], 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-right font-bold text-green-900 dark:text-green-900">
                                    ${{ number_format($resultado['tablaFlujos']['totales']['vpAcumulado'], 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div> 
        </div>
    @endif


</div>