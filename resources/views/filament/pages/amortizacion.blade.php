<x-filament-panels::page>
    <div class="flex h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <!-- Calculator Area -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8 text-center">

                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Calculadora de Sistemas de Amortización
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">
                        Calcula tablas de amortización para los tres sistemas principales: Francés, Alemán y Americano
                    </p>


                </div>

                <!-- Conceptos explicativos -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Sistema Francés -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/30 rounded-xl p-5 border border-green-200 dark:border-green-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg bg-green-200 dark:bg-green-800 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-green-900 dark:text-green-200 mb-1">
                                    Francés
                                </h3>
                                <p class="text-xs text-green-800 dark:text-green-300 mb-2">
                                    Cuota <strong>constante</strong>, amortización creciente, intereses decrecientes.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Sistema Alemán -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-200 dark:bg-blue-800 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">
                                    Alemán
                                </h3>
                                <p class="text-xs text-blue-800 dark:text-blue-300 mb-2">
                                    Amortización <strong>fija</strong>, cuotas decrecientes, intereses decrecientes.
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Sistema Americano -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 rounded-xl p-5 border border-purple-200 dark:border-purple-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg bg-purple-200 dark:bg-purple-800 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-1">
                                    Americano
                                </h3>
                                <p class="text-xs text-purple-800 dark:text-purple-300 mb-2">
                                    Solo <strong>intereses</strong>, capital al final, cuota final diferente.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calculator Section -->
                <section id="calculadora"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 mb-8">
                    <livewire:calculadora-amortizacion />
                </section>

            </div>
        </div>
    </div>
</x-filament-panels::page>
