<x-filament-panels::page>
    <div class="flex h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <!-- Calculator Area -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8 text-center">

                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Calculadora de Gradientes
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">
                        Calcula valores presentes y futuros de series con incrementos aritméticos o geométricos
                    </p>

                    <!-- Info badges -->
                    <div class="flex flex-wrap justify-center gap-2 mt-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                            Gradiente Aritmético
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                            Gradiente Geométrico
                        </span>

                    </div>
                </div>

                <!-- Conceptos explicativos -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gradiente Aritmético -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 rounded-xl p-5 border border-purple-200 dark:border-purple-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg bg-purple-200 dark:bg-purple-800 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-purple-900 dark:text-purple-200 mb-1">
                                    Gradiente Aritmético
                                </h3>
                                <p class="text-xs text-purple-800 dark:text-purple-300">
                                    Los pagos aumentan o disminuyen en una <strong>cantidad constante</strong> cada
                                    período.
                                </p>
                                <p class="text-xs text-purple-700 dark:text-purple-400 mt-2 italic">
                                    Ejemplo: $1,000 -> $1,100 -> $1,200 (G = +$100)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Gradiente Geométrico -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-200 dark:bg-blue-800 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">
                                    Gradiente Geométrico
                                </h3>
                                <p class="text-xs text-blue-800 dark:text-blue-300">
                                    Los pagos aumentan o disminuyen en un <strong>porcentaje constante</strong> cada
                                    período.
                                </p>
                                <p class="text-xs text-blue-700 dark:text-blue-400 mt-2 italic">
                                    Ejemplo: $1,000 -> $1,050 -> $1,102.5 (g = +5%)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calculator Section -->
                <section id="calculadora"
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                    <livewire:calculadora-gradientes />
                </section>

            </div>
        </div>
    </div>
</x-filament-panels::page>
