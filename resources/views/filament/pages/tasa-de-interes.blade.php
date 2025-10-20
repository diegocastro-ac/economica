<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6">
                <x-heroicon-o-arrow-trending-up class="w-10 h-10 text-white" />
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Tasas de Interés
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 text-justify">
                La <strong>tasa de interés</strong> es un indicador financiero que expresa, en forma de porcentaje, el valor que tiene el dinero en el tiempo. Puede representar el costo adicional que se debe pagar al solicitar un préstamo o la ganancia obtenida al invertir o guardar dinero en una entidad financiera.
            </p>
            <p class="text-xl text-gray-600 dark:text-gray-300 text-justify">
                Es un elemento clave en operaciones como créditos, ahorros e inversiones, ya que determina cuánto se paga o se gana al usar el dinero durante un período determinado.
            </p>
        </div>



        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Tipos de Tasas --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <x-heroicon-o-list-bullet class="w-5 h-5 mr-2 text-blue-500" />
                    Tipos de Tasas de Interés
                </h2>
                
                <div class="space-y-8">
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Tasa Nominal</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tasa de interés anual sin ajustar por capitalización</p>
                    </div>
                    
                    <div class="border-l-4 border-green-500 pl-4 py-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Tasa Efectiva</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tasa de interés anual que incluye el efecto de la capitalización</p>
                    </div>
                    
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Tasa Real</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tasa ajustada por inflación</p>
                    </div>
                </div>
            </div>

            {{-- Factores de Influencia --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5 mr-2 text-green-500" />
                    Factores que Influyen
                </h2>
                
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Política Monetaria</span>
                    </div>
                    
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Inflación</span>
                    </div>
                    
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Crecimiento Económico</span>
                    </div>
                    
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Riesgo País</span>
                    </div>
                    
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Demanda de Crédito</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards Explicativas de cada Tipo --}}
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">
                Explicación Detallada con Ejemplos
            </h2>
            
            {{-- Tasa Nominal --}}
            <div id="tasa-nominal" class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl shadow-sm border border-blue-200 dark:border-blue-700 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-500 rounded-lg mr-4">
                        <x-heroicon-o-calculator class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tasa Nominal</h3>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Es la tasa de interés expresada anualmente que <strong>no considera la capitalización</strong> ni los efectos de la inflación. 
                    Es la tasa básica que se anuncia en los contratos financieros.
                </p>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-blue-500">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Ejemplo:</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Un banco ofrece un CDT al 12% nominal anual. Si inviertes $1,000,000:
                        <br>• <strong>Interés simple anual:</strong> $1,000,000 × 12% = $120,000
                        <br>• <strong>Total al final del año:</strong> $1,120,000
                    </p>
                </div>
            </div>

            {{-- Tasa Efectiva --}}
            <div id="tasa-efectiva" class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl shadow-sm border border-green-200 dark:border-green-700 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-green-500 rounded-lg mr-4">
                        <x-heroicon-o-arrow-path class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tasa Efectiva</h3>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Considera el efecto de la <strong>capitalización de intereses</strong>. Es decir, los intereses generan más intereses. 
                    Refleja el verdadero costo o rendimiento de una operación financiera.
                </p>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-green-500">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Ejemplo:</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Mismo CDT del 12% nominal, pero con capitalización mensual:
                        <br>• <strong>Tasa mensual:</strong> 12% ÷ 12 = 1% mensual
                        <br>• <strong>Tasa efectiva anual:</strong> (1 + 0.01)¹² - 1 = 12.68%
                        <br>• <strong>Total final:</strong> $1,000,000 × 1.1268 = $1,126,800
                    </p>
                </div>
            </div>

            {{-- Tasa Real --}}
            <div id="tasa-real" class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl shadow-sm border border-purple-200 dark:border-purple-700 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-purple-500 rounded-lg mr-4">
                        <x-heroicon-o-chart-pie class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tasa Real</h3>
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Es la tasa de interés <strong>ajustada por la inflación</strong>. Muestra el verdadero poder adquisitivo 
                    que ganas o pierdes. Se calcula: Tasa Real = (Tasa Nominal - Inflación) ÷ (1 + Inflación).
                </p>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border-l-4 border-purple-500">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💡 Ejemplo:</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        CDT al 12% nominal con inflación del 8% anual:
                        <br>• <strong>Cálculo:</strong> (12% - 8%) ÷ (1 + 8%) = 4% ÷ 1.08 = 3.70%
                        <br>• <strong>Interpretación:</strong> Tu dinero realmente crece 3.70% en poder de compra
                        <br>• <strong>Ganancia real:</strong> $1,000,000 × 3.70% = $37,000 en términos reales
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer Info --}}
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                💡 <strong>Nota:</strong> La información mostrada es de carácter informativo. 
                Las tasas pueden variar según la entidad financiera y el tipo de operación.
            </p>
        </div>
    </div>
</x-filament-panels::page>