<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div>
        {{-- El Master no habla, actúa. --}}
        <form class="space-y-8" wire:submit.prevent="calcular('interesCompuesto')">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Capital Inicial ($)</label>
                    <input wire:model="capitalInicial_C" type="number" step="0.01"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="10,000">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Monto Final ($)</label>
                    <input wire:model="montoFinal_C" type="number" step="0.01"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="50,000,000">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Tasa de Interés </label>
                    <input wire:model="tasaInteres_C" type="number" step="0.01"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="9"
                        step="0.1">
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Tipo de Tasa</label>
                    <select wire:model="tipoTasa_C" class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400">
                        <option value="1">Anual (1 vez por año)</option>
                        <option value="2">Semestral (2 veces por año)</option>
                        <option value="3">Trimestral (4 veces por año)</option>
                        <option value="12">Mensual (12 veces por año)</option>
                        <option value="365">Diario (365 veces por año)</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Tiempo (Años)</label>
                    <input wire:model="tiempo_C" type="number" step="0.01"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="6" step="0.1">
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Frecuencia de Capitalización</label>
                    <select wire:model="capitalizacion_C" class="px-4 py-3 border w-82 border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400">
                        <option value="1">Anual (1 vez por año)</option>
                        <option value="2">Semestral (2 veces por año)</option>
                        <option value="3">Trimestral (4 veces por año)</option>
                        <option value="12">Mensual (12 veces por año)</option>
                        <option value="365">Diario (365 veces por año)</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                class="w-full m-2 py-4 bg-gray-900 dark:bg-gray-700 text-white border-0 rounded-2xl text-base font-semibold cursor-pointer transition-all duration-200 hover:bg-gray-700 dark:hover:bg-gray-600 active:scale-[0.98] transform">
                Calcular Interés Compuesto
            </button>
        </form>

        <!-- Result Card -->
        <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl p-8 mt-6 shadow-sm transition-colors duration-300">
            <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-8 py-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Resultado</h3>
                </div>

                <div class="text-3xl font-bold text-blue-600 dark:text-green-400 mb-2">
                    {{ $this->resultMessage ?? "No calculado" }}
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ $this->getDescripcionResultado() }}
                </p>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6 mt-6">
            <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">Fórmula del Interés Compuesto</h4>
            <p class="text-blue-700 dark:text-blue-300 text-sm mb-2">
                <strong>M = C × (1 + i)^n</strong>
            </p>
            <ul class="text-blue-600 dark:text-blue-400 text-xs space-y-1">
                <li>M = Monto final</li>
                <li>C = Capital inicial</li>
                <li>i = Tasa de interés por período de capitalización</li>
                <li>n = Número total de períodos de capitalización</li>
            </ul>
        </div>
    </div>
</div>