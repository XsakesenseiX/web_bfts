<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-lime bg-opacity-20 border border-lime text-lime px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                 <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-custom-gray p-6 rounded-lg shadow-md border border-lime shadow-lg shadow-lime-500/50">
                    <h4 class="font-bold text-lg mb-4 text-lime">Informasi Membership</h4>
                    @if ($membership && $membership->status == 'active')
                         <div class="space-y-2 text-white">
                            <p><strong>Tipe:</strong> {{ $user->status === 'mahasiswa' ? 'Mahasiswa' : 'Umum' }}</p>
                            <p><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold text-white bg-lime rounded-full">Aktif</span></p>
                            <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y') }}</p>
                            @php
                                $daysRemaining = now()->diffInDays($membership->end_date, false);
                            @endphp
                            <p><strong>Sisa Hari:</strong> {{ intval($daysRemaining) }} hari</p>

                            @if ($membership->package->type === 'loyalty')
                                <p class="mt-4"><strong>Check-in Tersisa:</strong> {{ $membership->package->check_in_limit - $membership->check_ins_made }} / {{ $membership->package->check_in_limit }}</p>
                                <div class="flex space-x-1 mt-2">
                                    @for ($i = 0; $i < $membership->package->check_in_limit; $i++)
                                        <div class="w-4 h-4 rounded-full
                                            {{ $i < $membership->check_ins_made ? 'bg-lime' : 'bg-gray-700' }}">
                                        </div>
                                    @endfor
                                </div>
                            @else
                                @php
                                    $totalDuration = $membership->package->duration_days;
                                    $daysPassed = $totalDuration - $daysRemaining;
                                    $percentage = ($daysPassed / $totalDuration) * 100;
                                    $percentage = max(0, min(100, $percentage));
                                @endphp
                                <div class="w-full bg-lime rounded-full h-2.5 mt-2">
                                    <div class="bg-gray-700 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center">
                            <p class="mb-4 text-white">Anda belum memiliki paket membership aktif.</p>
<a href="{{ route('packages.index') }}" class="inline-block bg-lime hover:bg-lime hover:shadow-lg hover:shadow-lime-500/50 text-black font-bold py-2 px-4 rounded">
                                Lihat Paket Membership
                            </a>
                        </div>
                    @endif
                </div>
<div class="bg-custom-gray p-6 rounded-lg shadow-md border border-lime shadow-lg shadow-lime-500/50">
                    <h4 class="font-bold text-lg mb-4 text-lime">Riwayat Check-in</h4>
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