<div class="p-4">
    <h3 class="text-lg font-bold mb-4">Detail Membership</h3>
    <p><strong>Paket:</strong> {{ $membership->package->name }}</p>
    <p><strong>Berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membership->end_date)->format('d F Y H:i:s') }}</p>
    <p><strong>Sisa Hari:</strong> {{ intval($remainingDays) }} hari</p>
</div>