<x-filament-panels::page>
    <div class="text-center">
        <p class="mb-4">Arahkan kamera ke QR Code yang tersedia di meja kasir.</p>
        <div id="qr-reader" style="width: 100%; max-width: 500px; margin: auto;"></div>
        <div id="qr-reader-results" class="mt-4"></div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            const expectedQrCode = "GYM-CHECKIN-CODE-RAHASIA";

            if (decodedText === expectedQrCode) {
                html5QrcodeScanner.clear();
                document.getElementById('qr-reader-results').innerHTML = `<div class="font-bold text-green-600">QR Code Valid! Memproses...</div>`;

                // Panggil method di backend menggunakan Livewire/Filament
                @this.call('recordCheckIn').then((result) => {
                    if(result.success) {
                        alert(result.message);
                        window.location.href = '{{ \App\Filament\Member\Pages\MemberDashboard::getUrl() }}';
                    }
                });
            } else {
                document.getElementById('qr-reader-results').innerHTML = `<div class="font-bold text-red-600">QR Code tidak valid.</div>`;
            }
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            {
                fps: 10,
                qrbox: {width: 250, height: 250},
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            },
            false);

        html5QrcodeScanner.render(onScanSuccess, (error) => {});
    </script>
</x-filament-panels::page>