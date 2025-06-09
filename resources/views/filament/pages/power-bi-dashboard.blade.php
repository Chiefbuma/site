<div>
    <x-filament-panels::page>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold tracking-tight">{{ $this->getHeading() }}</h2>
                <button onclick="refreshWidgets()" 
                        class="fi-btn flex items-center gap-2 px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    Refresh Dashboard
                </button>
            </div>
        </x-slot>

        <div class="space-y-6 p-4">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    @livewire(\App\Filament\Widgets\StatusDistributionDonutChart::class, key('status-widget'))
                </div>
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    @livewire(\App\Filament\Widgets\AgeDistributionDonutChart::class, key('age-widget'))
                </div>
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    @livewire(\App\Filament\Widgets\GenderDistributionDonutChart::class, key('gender-widget'))
                </div>
            </div>
            
            <!-- Add more widget rows here if needed -->
            <!-- <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                Additional widgets...
            </div> -->
        </div>
    </x-filament-panels::page>

    <script>
        function refreshWidgets() {
            const btn = event.currentTarget;
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Refreshing...
            `;
            
            // Force refresh all Livewire components
            Livewire.emit('refreshStatusDistributionDonutChart');
            Livewire.emit('refreshAgeDistributionDonutChart');
            Livewire.emit('refreshGenderDistributionDonutChart');
            
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                    Refresh Dashboard
                `;
            }, 3000);
        }
    </script>
</div>