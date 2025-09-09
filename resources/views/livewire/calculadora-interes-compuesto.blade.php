<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div>
        {{-- El Master no habla, actúa. --}}
        <form class="space-y-8" wire:submit.prevent="calcular('interesCompuesto')">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Capital Inicial ($)</label>
                    <input wire:model="capitalInicial_C" type="number"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="10,000">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Monto Final ($)</label>
                    <input wire:model="montoFinal_C" type="number"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="15,000">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Tasa de Interés (%)</label>
                    <input wire:model="tasaInteres_C" type="number"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="5.5"
                        step="0.1">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Tiempo (Períodos)</label>
                    <input wire:model="tiempo_C" type="number"
                        class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400"
                        placeholder="2" step="0.1">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Capitalización</label>
                    <select wire:model="capitalizacion_C" class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 transition-colors focus:outline-none focus:border-gray-900 dark:focus:border-gray-400">
                        <option value="1">Anual</option>
                        <option value="2">Semestral</option>
                        <option value="3">Trimestral</option>
                        <option value="12">Mensual</option>
                        <option value="365">Diario</option>
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

                <div class="text-3xl font-bold text-blue dark:text-green-400 mb-2">{{$this->result ?? "no calculado"}}</div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Monto final después de 5 períodos con interés compuesto
                </p>
            </div>

            <div class="pt-5">
                <div class="grid grid-cols-3 gap-5 text-center">
                    <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-8 py-6">
                        <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">5</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Interés Total</div>
                    </div>
                    <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-8 py-6">
                        <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">5</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Ganancia Total</div>
                    </div>
                    <div class="rounded-2xl bg-gray-100 dark:bg-gray-900 px-8 py-6">
                        <div class="text-xl font-semibold text-gray-900 dark:text-gray-100">5</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Rendimiento Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>