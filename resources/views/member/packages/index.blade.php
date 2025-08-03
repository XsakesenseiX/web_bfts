<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Pilih Paket Membership Anda
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($packages as $package)
                    <div class="bg-custom-gray overflow-hidden shadow-md sm:rounded-lg flex flex-col">
                        <div class="p-6 text-white flex-grow">
                            <h3 class="font-bold text-lg text-white">{{ $package->name }}</h3>
                            <p class="text-3xl text-white font-extrabold my-4">Rp {{ number_format($package->price) }}</p>
                            <p class="text-sm">Durasi: {{ $package->duration_days }} hari</p>
                        </div>
                        <div class="p-6 bg-black bg-opacity-20 mt-auto">
                            <a href="{{ route('packages.show', $package) }}" class="w-full text-center block bg-lime hover:bg-lime/90 text-black font-bold py-2 px-4 rounded">
                                Pilih Paket
                            </a>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full bg-custom-gray p-6 rounded-lg shadow-md text-center">
                        <p class="text-white">Saat ini belum ada paket membership yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>