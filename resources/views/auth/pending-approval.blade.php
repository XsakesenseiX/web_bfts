<!-- resources/views/auth/pending-approval.blade.php -->
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Terima kasih telah mendaftar! Akun Anda sedang menunggu persetujuan dari admin. Anda akan menerima email setelah akun Anda disetujui.
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