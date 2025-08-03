<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Status -->
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-black dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="umum">Umum</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
        </div>

        <!-- Student ID Card -->
        <div class="mt-4" id="student-id-card-wrapper" @if(old('status') !== 'mahasiswa') style="display: none;" @endif>
            <x-input-label for="student_id_card" :value="__('Kartu Tanda Mahasiswa (JPG, PNG, maks. 2MB)')" />
            <x-text-input id="student_id_card" class="block mt-1 w-full" type="file" name="student_id_card" />
            <x-input-error :messages="$errors->get('student_id_card')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-lime hover:text-lime/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const studentIdCardWrapper = document.getElementById('student-id-card-wrapper');
            const studentIdCardInput = document.getElementById('student_id_card');

            function toggleStudentIdCardField() {
                if (statusSelect.value === 'mahasiswa') {
                    studentIdCardWrapper.style.display = 'block';
                    studentIdCardInput.setAttribute('required', 'required');
                } else {
                    studentIdCardWrapper.style.display = 'none';
                    studentIdCardInput.removeAttribute('required');
                }
            }

            // Panggil fungsi saat halaman dimuat untuk menangani kasus old('status')
            toggleStudentIdCardField();

            // Panggil fungsi saat nilai dropdown berubah
            statusSelect.addEventListener('change', toggleStudentIdCardField);
        });
    </script>
</x-guest-layout>
