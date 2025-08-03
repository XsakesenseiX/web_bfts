<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($packages as $package)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex flex-col">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-bold text-lg">{{ $package->name }}</h3>
                    <p class="text-3xl font-extrabold my-4">Rp {{ number_format($package->price) }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Durasi: {{ $package->duration_days }} hari</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $package->description }}</p>
                </div>
                <div class="p-6 bg-gray-50 dark:bg-gray-700/50 mt-auto">
                    <a href="{{ \App\Filament\Pages\PurchasePackage::getUrl(['package' => $package->id]) }}" class="w-full text-center block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Pilih Paket
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>