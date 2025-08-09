<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bodyfit Tengah Sawah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen">
        <header class="absolute top-0 left-0 w-full z-10 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
            <img src="{{ asset('assets/images/font-btfs.png') }}" alt="BodyFit Tenbah Sawah" class="h-30 md:h-36">                <nav class="hidden md:flex items-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-300 hover:text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 bg-accent text-black font-semibold py-2 px-4 rounded-md hover:opacity-90">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <section class="hero-section h-screen flex items-center justify-center text-white">
            <div class="text-center max-w-2xl px-4">
                <h2 class="text-5xl md:text-7xl font-extrabold uppercase tracking-tight">BUILD MUSCLE <br><span class="text-accent">BUILD MENTALITY</span> TODAY!</h2>
                <p class="mt-6 text-lg text-gray-300">Join our gym for expert training, state-of-the-art equipment, and a supportive community that pushes you to succeed.</p>
                <a href="{{ route('register') }}" class="btn-primary mt-8 inline-block">Join Club Now!</a>
            </div>
        </section>

        <section class="py-20 bg-dark-primary">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold text-white">Why choose us?</h3>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">We are committed to helping you achieve your fitness goals with state-of-the-art facilities and expert support.</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 border border-gray-700 rounded-lg">
                        <h4 class="text-xl font-semibold text-accent">Expert Trainers</h4>
                        <p class="mt-2 text-gray-400">Our certified trainers are here to guide you.</p>
                    </div>
                    <div class="p-8 border-2 border-accent rounded-lg shadow-lg">
                        <h4 class="text-xl font-semibold text-accent">State-of-the-art Equipment</h4>
                        <p class="mt-2 text-gray-400">Technogym & Hammer Strength machines.</p>
                    </div>
                    <div class="p-8 border border-gray-700 rounded-lg">
                        <h4 class="text-xl font-semibold text-accent">Supportive Community</h4>
                        <p class="mt-2 text-gray-400">Join a community that motivates and inspires.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                 <h3 class="text-4xl font-bold text-white">Our Available Activities</h3>
                 <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative group">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Strength Training</h4></div>
                    </div>
                     <div class="relative group">
                        <img src="https://images.unsplash.com/photo-1548690312-e3b511d1e121?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cardio Workouts</h4></div>
                    </div>
                     <div class="relative group">
                        <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cross Training</h4></div>
                    </div>
                     <div class="relative group">
                        <img src="https://images.unsplash.com/photo-1552196563-55cd4e45efb3?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Personal Training</h4></div>
                    </div>
                 </div>
            </div>
        </section>

        <footer class="bg-dark-primary py-6">
            <div class="text-center text-gray-500">
                &copy; 2025 Bodyfit Tengah Sawah. All Rights Reserved.
            </div>
        </footer>
    </div>
</body>
</html>