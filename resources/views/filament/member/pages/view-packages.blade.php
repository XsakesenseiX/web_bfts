<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($packages as $package)
            <x-filament::card class="flex flex-col">
                <div class="flex-grow">
                    <h3 class="font-bold text-lg">{{ $package->name }}</h3>
                    <p class="text-3xl font-extrabold my-4">Rp {{ number_format($package->price) }}</p>
                    <p class="text-sm text-gray-500">Durasi: {{ $package->duration_days }} hari</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $package->description }}</p>
                </div>
                <div class="mt-auto pt-6">
                    {{-- Pastikan baris di bawah ini tidak dibungkus oleh {{-- --}}
                    <a href="{{ \App\Filament\Member\Pages\PurchasePackage::getUrl(['package' => $package->id]) }}"
                       class="fi-btn fi-btn-color-primary w-full text-center font-bold">
                        Pilih
                    </a>
                </div>
            </x-filament::card>
        @empty
            <div class="col-span-full">
                <x-filament::card>
                    <p class="text-center text-gray-500">Saat ini belum ada paket membership yang tersedia.</p>
                </x-filament::card>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>