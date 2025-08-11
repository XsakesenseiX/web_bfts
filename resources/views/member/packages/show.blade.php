<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--theme-text)] leading-tight">
            Konfirmasi Pembelian: {{ $package->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-600 text-white rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-600 text-white rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-600 text-white rounded-lg">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-[#202326] overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-8 text-[var(--theme-text)]">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-white">Ringkasan Pembayaran</h3>
                            <div class="border border-[var(--theme-border)] p-4 rounded-lg space-y-2">
                                <div class="flex justify-between"><span>Paket {{ $package->name }}:</span><span class="font-semibold">Rp {{ number_format($package->price) }}</span></div>
                                @if($additionalFee > 0)
                                    <div class="flex justify-between text-red-400"><span>Biaya Administrasi:</span><span class="font-semibold">Rp {{ number_format($additionalFee) }}</span></div>
                                @endif
                                <hr class="!my-3 border-[var(--theme-border)]">
                                <div class="flex justify-between text-xl"><span class="font-bold text-white">Total Bayar:</span><span class="font-bold" style="color: var(--theme-button);">Rp {{ number_format($totalPrice) }}</span></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-white">Unggah Bukti Transfer</h3>
                            <form method="POST" action="{{ route('packages.purchase', $package->id) }}" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="payment_proof" id="payment_proof" required class="block w-full text-sm border border-[var(--theme-border)] rounded-lg cursor-pointer bg-gray-700 text-gray-400 focus:outline-none placeholder-gray-400">
                                <button type="submit" class="w-full mt-6 bg-lime hover:bg-lime text-black font-bold py-3 px-4 rounded-lg">
                                    Konfirmasi Pembelian
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>