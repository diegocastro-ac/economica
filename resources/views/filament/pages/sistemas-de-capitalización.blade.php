<x-filament-panels::page>
    <div class="flex min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Sistemas de Capitalización
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        La capitalización es el proceso mediante el cual el dinero aumenta de valor con el tiempo gracias a los intereses.
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">
                        Comprende cómo crece tu dinero en el tiempo con diferentes métodos de capitalización
                    </p>
                    <div class="flex flex-wrap justify-center gap-2 mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            Interés y Capitalización
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            Crecimiento del Capital
                        </span>
                    </div>
                </div>

                <!-- Selector -->
                <div class="mb-8">
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/30 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800">
                        <label class="block text-lg font-bold text-indigo-900 dark:text-indigo-200 mb-4">
                            Selecciona el Tipo de Capitalización
                        </label>
                        <select wire:model.live="tipoCapitalizacion"
                            class="w-full px-4 py-3 rounded-lg border border-indigo-300 dark:border-indigo-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">-- Selecciona una opción --</option>
                            <option value="simple">Capitalización Simple</option>
                            <option value="compuesta">Capitalización Compuesta</option>
                            <option value="continua">Capitalización Continua</option>
                        </select>
                    </div>
                </div>

                <!-- Contenido Dinámico -->
                @if($tipoCapitalizacion === 'simple')
                <div class="space-y-6 ">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/30 rounded-xl p-6 border border-green-200 dark:border-green-800">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-200 mb-3">¿Qué es la Capitalización Simple?</h3>
                        <p class="text-base text-green-800 dark:text-green-300 mb-3">
                            Los <strong>interes</strong> que se generan en un periodo cualquiera son proporcionales a la duración del periodo y al capital inicial. Esta modalidad se suele usar para periodos de tiempo inferiores a un año. Debido a esto, no se capitaliza los intereses generados.
                        </p>
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-4">
                            <p class="text-base font-semibold mb-2">Fórmula:</p>
                            <code class="block bg-green-100 dark:bg-green-900/20 p-3 rounded font-mono text-base dark:text-green-900">M = C × (1 + i × n)</code>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold mb-4">Componentes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                    <p class="font-bold">Capital Inicial (C)</p>
                                    <p class="text-sm">Monto inicial invertido</p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                    <p class="font-bold">Monto Final (M)</p>
                                    <p class="text-sm">Monto final obtenido</p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                    <p class="font-bold">Tasa de Interés (i)</p>
                                    <p class="text-sm">Porcentaje por período</p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                    <p class="font-bold">Numero de periodos (n)</p>
                                    <p class="text-sm">Cantidad de períodos donde se genera intereses.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/30 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                            <h3 class="text-lg font-bold mb-4">📊 Ejemplo Práctico</h3>
                            <p class="text-sm mb-3"><strong>Inviertes $10,000 al 5% anual durante 3 años</strong></p>
                            <div class="space-y-2 text-sm">
                                <p>• Año 1: $10,000 + $500 = <strong>$10,500</strong></p>
                                <p>• Año 2: $10,000 + $500 = <strong>$11,000</strong></p>
                                <p>• Año 3: $10,000 + $500 = <strong>$11,500</strong></p>
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <p class="text-lg font-bold">Monto Final: $11,500</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calculator section -->
                    <section id="calculadora"
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <livewire:calculadora-capitalizacion-simple />
                    </section>
                </div>

                @elseif($tipoCapitalizacion === 'compuesta')
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/30 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-200 mb-3">¿Qué es la Capitalización Compuesta?</h3>
                        <p class="text-base text-purple-800 dark:text-purple-300 mb-3">
                            Los <strong>intereses</strong> generados en un periodo se acumulan al capital inicial para el periodo siguiente. En este caso lo intereses si son capitalizados, justo al contrario que la simple. Por ello, esta modalidad se suele usar para periodos superiores a un año. Por tanto, aquí los intereses generan más intereses. Para el caso de operaciones superiores al año, este tipo de capitalización generará mayor importe final que la simple.
                        </p>
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-4">
                            <p class="text-base font-semibold mb-2">Fórmula:</p>
                            <code class="block bg-purple-100 dark:bg-purple-900/20 p-3 rounded font-mono dark:text-purple-900 text-base">M = C × (1 + i)ⁿ</code>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold mb-4">Componentes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                    <p class="font-bold">Capital Inicial (C)</p>
                                    <p class="text-sm">Base para calcular intereses</p>
                                </div>
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                    <p class="font-bold">Monto Final (M)</p>
                                    <p class="text-sm">Monto final obtenido</p>
                                </div>
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                    <p class="font-bold">Tasa de Interés (i)</p>
                                    <p class="text-sm">Se aplica sobre capital + intereses</p>
                                </div>
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                    <p class="font-bold">Numero de periodos (n)</p>
                                    <p class="text-sm">Cantidad de períodos donde se genera intereses.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/30 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                            <h3 class="text-lg font-bold mb-4">📊 Ejemplo Práctico</h3>
                            <p class="text-sm mb-3"><strong>Inviertes $10,000 al 5% anual durante 3 años</strong></p>
                            <div class="space-y-2 text-sm">
                                <p>• Año 1: $10,000 × 1.05 = <strong>$10,500</strong></p>
                                <p>• Año 2: $10,500 × 1.05 = <strong>$11,025</strong></p>
                                <p>• Año 3: $11,025 × 1.05 = <strong>$11,576.25</strong></p>
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <p class="text-lg font-bold">Monto Final: $11,576.25</p>
                                <p class="text-xs">Ganancia adicional de $76.25 vs simple</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calculator section -->
                    <section id="calculadora"
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <livewire:calculadora-capitalizacion-compuesta />
                    </section>
                </div>

                @elseif($tipoCapitalizacion === 'continua')
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/30 rounded-xl p-6 border border-teal-200 dark:border-teal-800">
                        <h3 class="text-xl font-bold text-teal-900 dark:text-teal-200 mb-3">¿Qué es la Capitalización Continua?</h3>
                        <p class="text-base text-teal-800 dark:text-teal-300 mb-3">
                            En la capitalización continua, los intereses se acumulan de manera constante, sin esperar a que termine un período determinado. En este caso, la capitalización ocurre infinitas veces en un mismo intervalo de tiempo, lo que hace que el crecimiento del capital sea más preciso y ligeramente superior al de la capitalización compuesta. Se usa principalmente en contextos financieros avanzados y en cálculos matemáticos donde se requiere mayor exactitud. Usa el número <strong>e (≈ 2.71828)</strong>.
                        </p>
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-4">
                            <p class="text-base font-semibold mb-2">Fórmula:</p>
                            <code class="block bg-teal-100 dark:bg-teal-900/40 p-3 rounded font-mono text-base">M = C × e^(i×n)</code>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold mb-4">Componentes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4">
                                    <p class="font-bold">Capital Inicial (C)</p>
                                    <p class="text-sm">Base para calcular intereses</p>
                                </div>
                                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4">
                                    <p class="font-bold">Monto Final (M)</p>
                                    <p class="text-sm">Monto final obtenido</p>
                                </div>
                                <div class="bg-teal-50 dark:bg-teal-900/30 rounded-lg p-4">
                                    <p class="font-bold">Constante e</p>
                                    <p class="text-sm">Número de Euler (2.71828...)</p>
                                </div>
                                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4">
                                    <p class="font-bold">Tasa de Interés (i)</p>
                                    <p class="text-sm">Tasa anual en decimal</p>
                                </div>
                                <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4">
                                    <p class="font-bold">Numero de periodos (n)</p>
                                    <p class="text-sm">Cantidad de períodos donde se genera intereses.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/30 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                            <h3 class="text-lg font-bold mb-4">📊 Ejemplo Práctico</h3>
                            <p class="text-sm mb-3"><strong>Inviertes $10,000 al 5% anual durante 3 años</strong></p>
                            <div class="space-y-2 text-sm">
                                <p>• M = $10,000 × e^(0.05 × 3)</p>
                                <p>• M = $10,000 × e^0.15</p>
                                <p>• M = $10,000 × 1.1618</p>
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <p class="text-lg font-bold">Monto Final: $11,618.34</p>
                                <p class="text-xs">Máxima ganancia posible</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calculator section -->
                    <section id="calculadora"
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <livewire:calculadora-capitalizacion-continua />
                    </section>
                </div>

                @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Selecciona un Tipo de Capitalización
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Elige una opción del menú desplegable para ver información detallada
                    </p>
                </div>
                @endif

                <!-- Tabla Comparativa -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Comparación Rápida</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-indigo-100 dark:bg-indigo-900/40">
                                    <th class="px-4 py-3 text-left">Característica</th>
                                    <th class="px-4 py-3 text-center">Simple</th>
                                    <th class="px-4 py-3 text-center">Compuesta</th>
                                    <th class="px-4 py-3 text-center">Continua</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 font-semibold">Intereses se reinvierten</td>
                                    <td class="px-4 py-3 text-center text-red-600">❌ No</td>
                                    <td class="px-4 py-3 text-center text-green-600">✅ Sí</td>
                                    <td class="px-4 py-3 text-center text-green-600">✅ Continuamente</td>
                                </tr>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 font-semibold">Tipo de crecimiento</td>
                                    <td class="px-4 py-3 text-center">Lineal</td>
                                    <td class="px-4 py-3 text-center">Exponencial</td>
                                    <td class="px-4 py-3 text-center">Exponencial continuo</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-semibold">Rendimiento</td>
                                    <td class="px-4 py-3 text-center">Menor</td>
                                    <td class="px-4 py-3 text-center text-blue-600">Mayor</td>
                                    <td class="px-4 py-3 text-center text-green-600 font-bold">Máximo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>