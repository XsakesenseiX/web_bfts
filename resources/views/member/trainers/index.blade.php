<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Personal Trainer Kami
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($trainers as $trainer)
                    <div class="bg-custom-gray overflow-hidden shadow-md sm:rounded-lg text-center p-6 text-white">
                        <img src="{{ $trainer->photo ? asset('storage/' . $trainer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($trainer->name) . '&color=FFFFFF&background=1F2937' }}" alt="{{ $trainer->name }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-700">
                        <h3 class="font-bold text-lg text-white">{{ $trainer->name }}, {{ $trainer->age }} th</h3>
                        <p class="text-sm my-2">{{ $trainer->specialties }}</p>
                        
                        <a href="https://wa.me/62{{ ltrim($trainer->contact_info, '0') }}" target="_blank" class="mt-4 inline-flex items-center justify-center gap-2 bg-lime hover:bg-lime/90 text-black font-bold py-2 px-4 rounded transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.886-.001 2.269.654 4.505 1.905 6.344l-1.225 4.485 4.535-1.191z" /></svg>
                            <span>Hubungi via WhatsApp</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-custom-gray p-6 rounded-lg shadow-md text-center">
                        <p class="text-white">Saat ini belum ada data personal trainer.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>