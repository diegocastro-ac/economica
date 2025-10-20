<x-filament-panels::page>
    <div class="flex min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <!-- Calculator Area -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Calculadora de TIR
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">
                        Tasa Interna de Retorno - Evalúa la rentabilidad de tus proyectos de inversión
                    </p>

                    <!-- Info badges -->
                    <div class="flex flex-wrap justify-center gap-2 mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            Evaluación de Proyectos
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            Decisiones de Inversión
                        </span>
                    </div>
                </div>

                <!-- Concepto explicativo -->
                <div class="mb-8">
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/30 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-200 mb-3">
                                    ¿Qué es la TIR?
                                </h3>
                                <p class="text-sm text-indigo-800 dark:text-indigo-300 mb-3">
                                    La <strong>Tasa Interna de Retorno (TIR)</strong> es la tasa de descuento que hace que el Valor Presente Neto (VPN) de un proyecto sea igual a cero. En otras palabras, es la rentabilidad que ofrece una inversión.
                                </p>
                                <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-4 mb-3">
                                    <p class="text-sm text-indigo-900 dark:text-indigo-200 font-semibold mb-2">
                                        Criterio de decisión:
                                    </p>
                                    <ul class="text-xs text-indigo-800 dark:text-indigo-300 space-y-1.5">
                                        <li class="flex items-start">
                                            <span class="text-green-600 dark:text-green-400 mr-2">✓</span>
                                            <span><strong>TIR > Tasa Requerida:</strong> El proyecto es rentable y debe aceptarse</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-red-600 dark:text-red-400 mr-2">✗</span>
                                            <span><strong>TIR < Tasa Requerida:</strong> El proyecto no es rentable y debe rechazarse</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-yellow-600 dark:text-yellow-400 mr-2">≈</span>
                                            <span><strong>TIR = Tasa Requerida:</strong> El proyecto está en el punto de equilibrio</span>
                                        </li>
                                    </ul>
                                </div>
                                <p class="text-xs text-indigo-700 dark:text-indigo-400 italic">
                                    💡 Nota: Una TIR más alta indica una mayor rentabilidad del proyecto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aplicaciones Prácticas y Ejemplos -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        Aplicaciones Prácticas y Ejemplos
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Ejemplo 1: Proyecto de Inversión Simple -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/30 rounded-xl p-6 border border-green-200 dark:border-green-800">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-lg bg-green-200 dark:bg-green-800 flex items-center justify-center mr-3">
                                    <span class="text-lg font-bold text-green-700 dark:text-green-300">📊</span>
                                </div>
                                <h4 class="text-lg font-bold text-green-900 dark:text-green-200">
                                    Proyecto de Inversión Simple
                                </h4>
                            </div>

                            <div class="bg-white/70 dark:bg-gray-800/70 rounded-lg p-4 mb-4">
                                <p class="text-sm font-semibold text-green-900 dark:text-green-200 mb-3">
                                    Flujos de Caja
                                </p>
                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="flex justify-between">
                                        <span>Año 0: -$10,000</span>
                                        <span class="text-red-600 dark:text-red-400">(Inversión)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Año 1: +$2,500</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Año 2: +$3,000</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Año 3: +$3,500</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Año 4: +$4,000</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Año 6: +$4,500</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-green-100 dark:bg-green-900/40 rounded-lg p-3 text-center">
                                    <p class="text-xs text-green-700 dark:text-green-900 mb-1">TIR</p>
                                    <p class="text-2xl font-bold text-green-900 dark:text-green-800">19.71%</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-900/40 rounded-lg p-3 text-center">
                                    <p class="text-xs text-blue-700 dark:text-blue-900 mb-1">Tasa Requerida</p>
                                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-800">12%</p>
                                </div>
                            </div>

                            <div class="bg-green-200 dark:bg-green-900/60 rounded-lg p-4 text-center">
                                <p class="text-sm font-bold text-green-900 dark:text-green-900 mb-1">
                                    DECISIÓN: ACEPTAR
                                </p>
                                <p class="text-xs text-green-800 dark:text-green-800">
                                    TIR (19.71%) > Tasa Requerida (12%)
                                </p>
                            </div>
                        </div>

                        <!-- Ejemplo 2: Comparación de Proyectos -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/30 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-lg bg-purple-200 dark:bg-purple-800 flex items-center justify-center mr-3">
                                    <span class="text-lg font-bold text-purple-700 dark:text-purple-300">🔄</span>
                                </div>
                                <h4 class="text-lg font-bold text-purple-900 dark:text-purple-200">
                                    Comparación de Proyectos Mutuamente Excluyentes
                                </h4>
                            </div>

                            <div class="overflow-x-auto mb-4">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-purple-100 dark:bg-purple-900/40">
                                            <th class="px-3 py-2 text-left text-purple-900 dark:text-purple-900 font-semibold">Proyecto</th>
                                            <th class="px-3 py-2 text-center text-purple-900 dark:text-purpl900 font-semibold">Inversión</th>
                                            <th class="px-3 py-2 text-center text-purple-900 dark:text-purple-900 font-semibold">TIR</th>
                                            <th class="px-3 py-2 text-center text-purple-900 dark:text-purple-900 font-semibold">VPN @12%</th>
                                            <th class="px-3 py-2 text-center text-purple-900 dark:text-purple-900 font-semibold">Decisión TIR</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white/70 dark:bg-gray-800/70">
                                        <tr class="border-b border-purple-100 dark:border-purple-800">
                                            <td class="px-3 py-2 font-semibold text-gray-900 dark:text-gray-100">A</td>
                                            <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">$10,000</td>
                                            <td class="px-3 py-2 text-center text-green-600 dark:text-green-400 font-bold">22%</td>
                                            <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">$2,500</td>
                                            <td class="px-3 py-2 text-center text-green-600 dark:text-green-400 font-semibold">Aceptar</td>
                                        </tr>
                                        <tr>
                                            <td class="px-3 py-2 font-semibold text-gray-900 dark:text-gray-100">B</td>
                                            <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">$25,000</td>
                                            <td class="px-3 py-2 text-center text-blue-600 dark:text-blue-400 font-bold">18%</td>
                                            <td class="px-3 py-2 text-center text-gray-700 dark:text-gray-300">$4,800</td>
                                            <td class="px-3 py-2 text-center text-green-600 dark:text-green-400 font-semibold">Aceptar</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="bg-yellow-100 dark:bg-yellow-900/30 rounded-lg p-4 mb-4">
                                <p class="text-sm font-semibold text-yellow-900 dark:text-yellow-200 mb-2">
                                    ⚠️ Conflicto TIR vs VPN:
                                </p>
                                <p class="text-xs text-yellow-800 dark:text-yellow-300">
                                    Proyecto A tiene mayor TIR (22% vs 18%) pero Proyecto B crea más valor ($4,800 vs $2,500).
                                </p>
                            </div>

                            <div class="bg-purple-200 dark:bg-purple-900/60 rounded-lg p-4 text-center">
                                <p class="text-sm font-bold text-purple-900 dark:text-purple-800 mb-1">
                                    Solución: Usar VPN para maximizar valor
                                </p>
                                <p class="text-xs text-purple-800 dark:text-purple-700">
                                    En este caso, elegir Proyecto B
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Ventajas y Limitaciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/30 rounded-xl p-6 border border-green-200 dark:border-green-800">
                        <h4 class="text-lg font-bold text-green-900 dark:text-green-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Ventajas de la TIR
                        </h4>
                        <ul class="space-y-2 text-sm text-green-800 dark:text-green-300">
                            <li class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 mr-2 mt-0.5">✓</span>
                                <span>Fácil de entender e interpretar como porcentaje de rentabilidad</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 mr-2 mt-0.5">✓</span>
                                <span>Considera todos los flujos de caja del proyecto</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 mr-2 mt-0.5">✓</span>
                                <span>Toma en cuenta el valor del dinero en el tiempo</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 mr-2 mt-0.5">✓</span>
                                <span>Útil para comparar proyectos de diferentes tamaños</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-red-50 dark:bg-red-950/50 rounded-xl p-6 border border-red-300 dark:border-red-700">
                        <h4 class="text-lg font-bold text-red-900 dark:text-red-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Limitaciones de la TIR
                        </h4>
                        <ul class="space-y-2 text-sm text-red-800 dark:text-red-900">
                            <li class="flex items-start">
                                <span class="text-red-600 dark:text-red-400 mr-2 mt-0.5">⚠</span>
                                <span>Puede dar múltiples TIR si hay cambios de signo en los flujos</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-600 dark:text-red-400 mr-2 mt-0.5">⚠</span>
                                <span>Asume reinversión de flujos a la misma TIR (poco realista)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-600 dark:text-red-400 mr-2 mt-0.5">⚠</span>
                                <span>Puede dar resultados contradictorios vs VPN en proyectos mutuamente excluyentes</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-600 dark:text-red-400 mr-2 mt-0.5">⚠</span>
                                <span>No considera la escala de inversión ni el valor absoluto creado</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Footer con consejos -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/30 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Consejos para Usar la TIR
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">1.</span>
                            <p>Siempre combina el análisis de TIR con el VPN para tomar mejores decisiones</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">2.</span>
                            <p>Verifica que los flujos de caja tengan solo un cambio de signo para evitar múltiples TIR</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">3.</span>
                            <p>En proyectos mutuamente excluyentes, da preferencia al criterio del VPN</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">4.</span>
                            <p>Realiza análisis de sensibilidad para evaluar el riesgo del proyecto</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculator Section -->
                <section id="calculadora"
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <livewire:tir />
                </section>
</x-filament-panels::page>