<!-- resources/views/auth/pending-approval.blade.php -->
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        @if (session('success'))
            <div class="font-medium text-sm text-green-600 dark:text-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (!session('success'))
            Terima kasih telah mendaftar! Akun Anda sedang menunggu persetujuan dari admin. Anda akan menerima email setelah akun Anda disetujui.
        @endif
        <p class="mt-4">Status Anda akan diperbarui setelah admin meninjau permintaan Anda.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                fetch('{{ route("check.approval.status") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_approved) {
                            window.location.href = '{{ route("dashboard") }}';
                        }
                    });
            }, 5000); // Check every 5 seconds
        });
    </script>
</x-guest-layout>