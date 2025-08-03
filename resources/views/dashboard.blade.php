<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                 <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-custom-gray p-6 rounded-lg shadow-md">
                    <h4 class="font-bold text-lg mb-4 text-white">Informasi Membership</h4>
                    @if ($membership && $membership->status == 'active')
                         <div class="space-y-2 text-white">
                            <p><strong>Tipe:</strong> {{ $membership->package->name }}</p>
                            <p><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Aktif</span></p>
                            <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y') }}</p>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="mb-4 text-white">Anda belum memiliki paket membership aktif.</p>
<a href="{{ route('packages.index') }}" class="inline-block bg-lime hover:bg-lime/90 text-black font-bold py-2 px-4 rounded">
                                Lihat Paket Membership
                            </a>
                        </div>
                    @endif
                </div>
<div class="bg-custom-gray p-6 rounded-lg shadow-md">
                    <h4 class="font-bold text-lg mb-4 text-white">Riwayat Presensi Terakhir</h4>
                    <table class="w-full text-sm text-white">
                        <thead><tr class="border-b border-[var(--theme-border)]"><th class="text-left pb-2">Tanggal</th><th class="text-left pb-2">Waktu</th><th class="text-left pb-2">Loker</th></tr></thead>
                        <tbody>
                            @forelse ($checkInHistory as $checkIn)
                                <tr class="border-b border-[var(--theme-border)]"><td class="py-2">{{ \Carbon\Carbon::parse($checkIn->created_at)->format('d M Y') }}</td><td class="py-2">{{ \Carbon\Carbon::parse($checkIn->created_at)->format('H:i:s') }}</td><td class="py-2">{{ $checkIn->locker_number ?? 'Tidak' }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="py-4 text-center">Belum ada riwayat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>