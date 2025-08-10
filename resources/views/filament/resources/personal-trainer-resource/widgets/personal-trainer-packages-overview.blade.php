<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Personal Trainer Packages</h2>

        @if($this->getPersonalTrainerPackages()->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($this->getPersonalTrainerPackages() as $package)
                    <div class="border p-2 rounded-lg">
                        <h3 class="text-lg font-semibold">{{ $package->name }}</h3>
                        <p class="text-gray-600">Price: Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        <p class="text-gray-600">Duration: {{ $package->duration_days }} days</p>
                        <p class="text-gray-600 text-sm">{{ $package->description }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-gray-700">Untuk pembelian paket personal trainer, silakan kunjungi gym kami.</p>
        @else
            <p class="text-gray-600">No personal trainer packages available at the moment.</p>
        @endif
    </x-filament::card>
</x-filament::widget>