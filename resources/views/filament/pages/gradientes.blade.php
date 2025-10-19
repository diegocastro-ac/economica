<x-filament-panels::page>
    <div class="flex h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <!-- Calculator Area -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Calculadora de Gradientes
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        Calcula valores presentes y futuros de series con gradientes aritméticos y geométricos
                    </p>
                </div>

                <section id="calculadora">
                    <livewire:calculadora-gradientes />
                </section>
            </div>
        </div>
    </div>
</x-filament-panels::page>
