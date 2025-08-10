<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Personal Trainer Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom-gray overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="font-bold text-lg mb-6 text-white">Available Personal Trainer Packages</h3>
                    @if ($personalTrainerPackages->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($personalTrainerPackages as $package)
                                <div class="bg-custom-gray p-6 rounded-lg shadow-md border border-lime shadow-lg shadow-lime-500/50 text-white">
                                    <h5 class="font-semibold text-lg">{{ $package->name }}</h5>
                                    <p class="text-white">Harga: Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                    <p class="text-white">Durasi: {{ $package->duration_days }} hari</p>
                                    <p class="text-white text-sm mt-2">{{ $package->description }}</p>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-white">Belum ada paket personal trainer yang tersedia saat ini.</p>
                    @endif

                    <div class="mt-8 text-center">
                        <p class="mt-4 text-sm text-white">Untuk pembelian paket personal trainer, silakan kunjungi gym kami.</p>
                        <p class="text-white mb-4">Jika ada pertanyaan lebih lanjut bisa menekan tombol ini</p>
                        <a href="https://wa.me/6281234567890" class="inline-block bg-lime hover:bg-lime hover:shadow-lg hover:shadow-lime-500/50 text-black font-bold py-2 px-4 rounded" target="_blank">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>