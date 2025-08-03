<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Konfirmasi Kehadiran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-custom-gray overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-center text-white">
                    <p class="mb-4">Arahkan kamera ke QR Code yang tersedia di meja kasir.</p>
                    
                    {{-- Area untuk menampilkan pemindai kamera --}}
                    <div id="qr-reader" style="width: 100%;" class="border border-lime rounded-lg overflow-hidden"></div>
                    
                    <div id="qr-reader-results" class="mt-4 h-6"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk menjalankan QR Scanner --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            const expectedQrCode = "GYM-CHECKIN-CODE-RAHASIA";

            if (decodedText === expectedQrCode) {
                html5QrcodeScanner.clear();
                document.getElementById('qr-reader-results').innerHTML = `<div class="font-bold text-green-500">QR Code Valid! Memproses...</div>`;

                fetch('{{ route("checkin.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.href = '{{ route("dashboard") }}';
                    } else {
                        alert('Error: ' + data.message);
                        window.location.href = '{{ route("dashboard") }}';
                    }
                });
            } else {
                 document.getElementById('qr-reader-results').innerHTML = `<div class="font-bold text-red-500">QR Code tidak valid.</div>`;
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
</x-app-layout>