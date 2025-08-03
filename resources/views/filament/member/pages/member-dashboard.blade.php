<style>
/* SUPER AGGRESSIVE inline styling override */
body, html, .fi-layout, .fi-main, .fi-body, .min-h-screen, .fi-page, .fi-dashboard-page { 
    background-color: #000000 !important; 
    background: #000000 !important; 
}

.fi-card, .fi-section-card, div[class*="card"], .filament-card, .rounded-xl, .shadow, .border { 
    background-color: #909090 !important; 
    background: #909090 !important; 
    color: #000000 !important; 
    border: 1px solid #808080 !important; 
}

.fi-card *, .fi-section-card *, div[class*="card"] * { 
    color: #000000 !important; 
}

button, .fi-btn, .fi-btn-primary, .bg-blue-600, .bg-green-600, .bg-indigo-600, a[class*="bg-blue"], input[type="submit"] { 
    background-color: #9BFD14 !important; 
    background: #9BFD14 !important; 
    color: #000000 !important; 
    border-color: #9BFD14 !important; 
}

button:hover, .fi-btn:hover, .fi-btn-primary:hover, .bg-blue-600:hover { 
    background-color: #8ae812 !important; 
    background: #8ae812 !important; 
    color: #000000 !important; 
}

.fi-sidebar { 
    background-color: #1a1a1a !important; 
    background: #1a1a1a !important; 
}

.fi-sidebar-nav-item a { 
    color: #909090 !important; 
}

.fi-sidebar-nav-item:hover a { 
    color: #FBBF24 !important; 
}

.fi-header { 
    background-color: #909090 !important; 
    background: #909090 !important; 
}

table, table th, table td { 
    color: #000000 !important; 
    border-color: #808080 !important; 
}

.text-white, .text-gray-900, .text-gray-800 { 
    color: #000000 !important; 
}

.bg-white, .bg-gray-50, .bg-gray-100 { 
    background-color: #909090 !important; 
    background: #909090 !important; 
}
</style>

<script>
// Force styling with JavaScript after page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        // Force black background
        document.body.style.setProperty('background-color', '#000000', 'important');
        document.documentElement.style.setProperty('background-color', '#000000', 'important');
        
        // Force all main containers to black
        const mainContainers = document.querySelectorAll('.fi-layout, .fi-main, .fi-body, .min-h-screen, .fi-page, .fi-dashboard-page');
        mainContainers.forEach(el => {
            el.style.setProperty('background-color', '#000000', 'important');
            el.style.setProperty('background', '#000000', 'important');
        });
        
        // Force all cards to gray
        const cards = document.querySelectorAll('.fi-card, .fi-section-card, [class*="card"], .filament-card, .rounded-xl, .shadow, .border');
        cards.forEach(el => {
            el.style.setProperty('background-color', '#909090', 'important');
            el.style.setProperty('background', '#909090', 'important');
            el.style.setProperty('color', '#000000', 'important');
            el.style.setProperty('border', '1px solid #808080', 'important');
        });
        
        // Force all text in cards to black
        const cardTexts = document.querySelectorAll('.fi-card *, .fi-section-card *, [class*="card"] *');
        cardTexts.forEach(el => {
            el.style.setProperty('color', '#000000', 'important');
        });
        
        // Force all buttons to green
        const buttons = document.querySelectorAll('button, .fi-btn, .fi-btn-primary, .bg-blue-600, .bg-green-600, .bg-indigo-600, a[class*="bg-blue"], input[type="submit"]');
        buttons.forEach(el => {
            el.style.setProperty('background-color', '#9BFD14', 'important');
            el.style.setProperty('background', '#9BFD14', 'important');
            el.style.setProperty('color', '#000000', 'important');
            el.style.setProperty('border-color', '#9BFD14', 'important');
        });
        
        // Force sidebar
        const sidebar = document.querySelector('.fi-sidebar');
        if (sidebar) {
            sidebar.style.setProperty('background-color', '#1a1a1a', 'important');
            sidebar.style.setProperty('background', '#1a1a1a', 'important');
        }
        
        // Force header
        const header = document.querySelector('.fi-header');
        if (header) {
            header.style.setProperty('background-color', '#909090', 'important');
            header.style.setProperty('background', '#909090', 'important');
        }
        
        console.log('Member dashboard styling forced with JavaScript');
    }, 100);
});
</script>

<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-filament::card>
            <h4 class="font-bold text-lg mb-4">Informasi Membership</h4>
            @if ($membership && $membership->status == 'active')
                <div class="space-y-2">
                    <p><strong>Tipe:</strong> {{ $membership->package->name }}</p>
                    <p><strong>Status:</strong> <span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Aktif</span></p>
                    <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y') }}</p>
                </div>
            @elseif ($membership && $membership->status == 'pending')
                <p class="text-yellow-600">Pembelian Anda sedang menunggu verifikasi.</p>
            @else
                <div class="text-center">
                    <p class="mb-4">Anda belum memiliki paket membership aktif.</p>
                    <a href="{{ \App\Filament\Member\Pages\ViewPackages::getUrl() }}" class="w-full text-center block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
