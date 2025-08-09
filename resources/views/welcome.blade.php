<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bodyfit Tengah Sawah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
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

        <section class="hero-section h-screen flex items-center justify-center text-white relative overflow-hidden">
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                <source src="{{ asset('assets/videos/cinematic.mp4') }}" type="video/mp4">
                <!-- Anda bisa menambahkan format video lain seperti WebM untuk kompatibilitas yang lebih baik -->
                <!-- <source src="{{ asset('assets/videos/cinematic.webm') }}" type="video/webm"> -->
                Your browser does not support the video tag.
            </video>
            <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Overlay untuk teks agar lebih mudah dibaca -->
            <div class="text-center max-w-2xl px-4 relative z-10">
                <h2 class="text-5xl md:text-7xl font-extrabold uppercase tracking-tight">BUILD MUSCLE <br><span class="text-accent">BUILD MENTALITY</span> TODAY!</h2>
                <p class="mt-6 text-lg text-gray-300">Join our gym for expert training, state-of-the-art equipment, and a supportive community that pushes you to succeed.</p>
                <a href="{{ route('register') }}" class="btn-primary mt-8 inline-block">Join Club Now!</a>
                <a href="https://wa.me/6281234567890" class="btn-primary mt-8 inline-block ml-4 bg-green-500 hover:bg-green-600" target="_blank">Contact Us</a>
            </div>
        </section>

        <section class="py-20 bg-dark-primary" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold text-white">Why choose us?</h3>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">We are committed to helping you achieve your fitness goals with state-of-the-art facilities and expert support.</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 border border-gray-700 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                        <h4 class="text-xl font-semibold text-accent">Expert Trainers</h4>
                        <p class="mt-2 text-gray-400">Our certified trainers are here to guide you.</p>
                    </div>
                    <div class="p-8 border-2 border-accent rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                        <h4 class="text-xl font-semibold text-accent">State-of-the-art Equipment</h4>
                        <p class="mt-2 text-gray-400">Technogym & Hammer Strength machines.</p>
                    </div>
                    <div class="p-8 border border-gray-700 rounded-lg" data-aos="fade-up" data-aos-delay="300">
                        <h4 class="text-xl font-semibold text-accent">Supportive Community</h4>
                        <p class="mt-2 text-gray-400">Join a community that motivates and inspires.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-black" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                 <h3 class="text-4xl font-bold text-white">Our Available Activities</h3>
                 <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative group" data-aos="zoom-in" data-aos-delay="100">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Strength Training</h4></div>
                    </div>
                     <div class="relative group" data-aos="zoom-in" data-aos-delay="200">
                        <img src="https://images.unsplash.com/photo-1548690312-e3b511d1e121?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cardio Workouts</h4></div>
                    </div>
                     <div class="relative group" data-aos="zoom-in" data-aos-delay="300">
                        <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cross Training</h4></div>
                    </div>
                     <div class="relative group" data-aos="zoom-in" data-aos-delay="400">
                        <img src="https://images.unsplash.com/photo-1552196563-55cd4e45efb3?auto=format&fit=crop&w=800&q=60" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Personal Training</h4></div>
                    </div>
                 </div>
            </div>
        </section>

        <section class="py-20 bg-dark-primary" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold text-white mb-12">Our Gym Gallery</h3>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <!-- Placeholder Images for Gallery -->
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1571019613454-1cb2fcdb4679?auto=format&fit=crop&w=800&q=60" alt="Gym Image 1" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1593079831471-280a545c4176?auto=format&fit=crop&w=800&q=60" alt="Gym Image 2" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1584829189639-954195e38ad6?auto=format&fit=crop&w=800&q=60" alt="Gym Image 3" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1546483875-ad928f05292e?auto=format&fit=crop&w=800&q=60" alt="Gym Image 4" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1517963628600-89017d60b517?auto=format&fit=crop&w=800&q=60" alt="Gym Image 5" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1574680096145-d05b47f210e1?auto=format&fit=crop&w=800&q=60" alt="Gym Image 6" class="rounded-lg w-full h-96 object-cover shadow-lg"></div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <footer class="bg-dark-primary py-6">
            <div class="text-center text-gray-500">
                &copy; 2025 Bodyfit Tengah Sawah. All Rights Reserved.
            </div>
        </footer>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            // navigation: {
            //     nextEl: ".swiper-button-next",
            //     prevEl: ".swiper-button-prev",
            // },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 50,
                },
            },
        });
    </script>
</body>
</html>