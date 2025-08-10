<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personal Trainers & Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Our Personal Trainers</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @foreach ($trainers as $trainer)
                            <div class="bg-custom-gray p-6 rounded-lg shadow-md border border-lime shadow-lg shadow-lime-500/50 text-white">
                                <h4 class="font-bold text-lg mb-2">{{ $trainer->name }}</h4>
                                <p>Specialties: {{ $trainer->specialties }}</p>
                                <p>Contact: {{ $trainer->contact_info }}</p>
                                {{-- You can add trainer photo here if available --}}
                            </div>
                        @endforeach
                    </div>

                    <h3 class="font-bold text-lg mb-4">Personal Trainer Packages</h3>
                    @if ($personalTrainerPackages->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-white">
                            @foreach ($personalTrainerPackages as $package)
                                <div class="border border-lime p-4 rounded-lg bg-custom-gray shadow-md shadow-lime-500/50">
                                    <h5 class="font-semibold text-lg">{{ $package->name }}</h5>
                                    <p>Harga: Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                    <p>Durasi: {{ $package->duration_days }} hari</p>
                                    <p class="text-sm mt-2">{{ $package->description }}</p>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-sm text-gray-700">Untuk pembelian paket personal trainer, silakan kunjungi gym kami.</p>
                    @else
                        <p class="text-gray-600">Belum ada paket personal trainer yang tersedia saat ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>