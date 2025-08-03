<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h3 class="text-lg font-bold mb-4">Ringkasan Pembayaran</h3>
            <div class="border dark:border-gray-700 p-4 rounded-lg space-y-2">
                <div class="flex justify-between">
                    <span>Paket {{ $package->name }}:</span>
                    <span class="font-semibold">Rp {{ number_format($package->price) }}</span>
                </div>

                @if($additionalFee > 0)
                <div class="flex justify-between text-red-500">
                    <span>Biaya Pendaftaran Ulang:</span>
                    <span class="font-semibold">Rp {{ number_format($additionalFee) }}</span>
                </div>
                @endif
                
                <hr class="!my-3 dark:border-gray-700">
                
                <div class="flex justify-between text-xl">
                    <span class="font-bold">Total Bayar:</span>
                    <span class="font-bold text-primary-600">Rp {{ number_format($totalPrice) }}</span>
                </div>
            </div>

            <h3 class="text-lg font-bold mt-6 mb-4">Instruksi Pembayaran</h3>
            <div class="border dark:border-gray-700 p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                <p class="font-semibold">Silakan lakukan transfer ke rekening berikut:</p>
                <p class="mt-2">Bank BCA: <strong class="text-lg">1234-5678-90</strong><br>a/n: PT. Gym Sejahtera</p>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold mb-4">Unggah Bukti Transfer</h3>
            <form wire:submit="purchase">
                {{ $this->form }}
                <button type="submit" class="fi-btn fi-btn-color-primary w-full mt-6 font-bold">
                    Konfirmasi Pembelian
                </button>
            </form>
        </div>
    </div>
</x-filament-panels::page>