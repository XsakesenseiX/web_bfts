<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-filament::card>
            <h4 class="font-bold text-lg mb-4">Informasi Membership</h4>
            @if ($membership && $membership->status == 'active')
                <div class="space-y-2">
                    <p><strong>Tipe:</strong> {{ $membership->package->name }}</p>
                    <p><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold text-black rounded-full" style="background-color: #9BFD14;">Aktif</span></p>
                    <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y') }}</p>
                </div>
            @elseif ($membership && $membership->status == 'pending')
                <p class="text-yellow-600">Pembelian Anda sedang menunggu verifikasi.</p>
            @else
                {{-- Tombol Beli Paket untuk member lama/expired --}}
                <div class="text-center">
                    <p class="mb-4">Anda belum memiliki paket membership aktif.</p>
                    <a href="{{ \App\Filament\Member\Pages\ViewPackages::getUrl() }}" class="w-full text-center block bg-[#9BFD14] hover:opacity-90 text-black font-bold py-2 px-4 rounded">
                        Lihat Paket Membership
                    </a>
                </div>
            @endif
        </x-filament::card>

        <x-filament::card>
             <h4 class="font-bold text-lg mb-4">Riwayat Presensi Terakhir</h4>
             <table class="w-full text-sm">
                <thead><tr class="border-b"><th class="text-left pb-2">Tanggal</th><th class="text-left pb-2">Waktu</th><th class="text-left pb-2">Loker</th></tr></thead>
                <tbody>
                     @forelse ($checkInHistory as $checkIn)
                        <tr class="border-b"><td class="py-2">{{ \Carbon\Carbon::parse($checkIn->created_at)->format('d M Y') }}</td><td class="py-2">{{ \Carbon\Carbon::parse($checkIn->created_at)->format('H:i:s') }}</td><td class="py-2">{{ $checkIn->locker_number ?? 'Tidak' }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-center text-gray-500">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
             </table>
        </x-filament::card>
    </div>
</x-filament-panels::page>
