<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { background: white; border: 1px solid #ccc; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .btn { background: #9BFD14; color: black; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .status { background: #9BFD14; color: black; padding: 4px 8px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <h1>Member Dashboard</h1>
    
    <p><strong>User:</strong> {{ Auth::user()->name ?? 'Guest' }}</p>
    <p><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
    
    <div class="grid">
        <div class="card">
            <h3>Informasi Membership</h3>
            
            @if ($membership && $membership->status == 'active')
                <p><strong>Tipe:</strong> {{ $membership->package->name }}</p>
                <p><strong>Status:</strong> <span class="status">Aktif</span></p>
                <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y') }}</p>
            @elseif ($membership && $membership->status == 'pending')
                <p style="color: orange;">Pembelian Anda sedang menunggu verifikasi.</p>
            @else
                <p>Anda belum memiliki paket membership aktif.</p>
                <a href="/member/view-packages" class="btn">Lihat Paket Membership</a>
            @endif
        </div>

        <div class="card">
            <h3>Riwayat Presensi Terakhir</h3>
            
            @if($checkInHistory && count($checkInHistory) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Loker</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkInHistory as $checkIn)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($checkIn->created_at)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($checkIn->created_at)->format('H:i:s') }}</td>
                                <td>{{ $checkIn->locker_number ?? 'Tidak' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Belum ada riwayat check-in.</p>
            @endif
        </div>
    </div>
</body>
</html>
