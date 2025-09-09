

<x-filament-panels::page>

    <div class="flex h-screen bg-white dark:bg-gray-900 transition-colors duration-300 rounded-2xl">
        <!-- Calculator Area -->
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-2xl mx-auto">
                <!-- Dark Mode Toggle -->


                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Calculadora de Interés Simple</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Calcula el interés simple y cualquier variable de sus fórmulas</p>
                </div>

                <section id="calculadora">
                    <livewire:calculadora-interes-simple/>
                </section>

            </div>
        </div>


    </div>

</x-filament-panels::page>

