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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                <h2 class="text-5xl md:text-7xl font-extrabold uppercase tracking-tight"><span class="reveal-text">BUILD MUSCLE</span><br><span class="reveal-text text-accent">BUILD MENTALITY</span></h2>
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
                 <h3 class="text-4xl font-bold text-white">Our Membership Plans</h3>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">Choose the plan that best fits your fitness journey.</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-8 border border-gray-700 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                        <h4 class="text-2xl font-bold text-white">Regular Plan</h4>
                        <p class="mt-2 text-gray-400">Full access to all facilities, any time.</p>
                        <p class="text-4xl font-bold text-accent mt-4">Rp 198.000<span class="text-lg text-gray-400">/month</span></p>
                        <a href="{{ route('register') }}" class="btn-primary mt-6 inline-block">Get Started</a>
                    </div>
                    <div class="p-8 border-2 border-accent rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                        <h4 class="text-2xl font-bold text-white">Student Plan</h4>
                        <p class="mt-2 text-gray-400">Special rates for students with valid ID.</p>
                        <p class="text-4xl font-bold text-accent mt-4">Rp 185.000<span class="text-lg text-gray-400">/month</span></p>
                        <a href="{{ route('register') }}" class="btn-primary mt-6 inline-block">Get Started</a>
                    </div>
                </div>
                <a href="{{ route('packages.index') }}" class="text-accent mt-8 inline-block hover:underline">View All Plans</a>
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
                        <img src="https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="rounded-lg w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cardio Workouts</h4></div>                      <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><h4 class="text-2xl font-bold text-white">Cardio Workouts</h4></div>
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

        <section class="py-20 bg-black text-white text-center" data-aos="zoom-in">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-4xl font-bold mb-6">Ready to Transform Your Body?</h3>
                <p class="text-lg text-gray-300 mb-8">Join Bodyfit Tengah Sawah today and start your journey towards a healthier, stronger you!</p>
                <a href="{{ route('register') }}" class="btn-primary inline-block">Register Now!</a>
            </div>
        </section>

        <section class="py-20 bg-dark-primary" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-4xl font-bold text-white mb-12">Find Us Here!</h3>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">Visit us at our state-of-the-art facility.</p>
                <div class="mt-12 w-full max-w-4xl mx-auto">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6000000000005!2d106.82000000000001!3d-6.175392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQwJzQ3LjQiUyAxMDbCsDQ5JzEyLjUiRQ!5e0!3m2!1sen!2sid!4m6!3m5!1s0x0%3A0x0!2zMTPCsDQwJzQ3LjQiUyAxMDbCsDQ5JzEyLjUiRQ!4m1!1e0!5m1!1e0" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="mt-8 text-gray-300">
                    <p class="font-semibold">Address:</p>
                    <p>Jl. Contoh Alamat Gym No. 123, Kota Contoh, Negara Contoh</p>
                    <p class="font-semibold mt-4">Operating Hours:</p>
                    <p>Mon - Fri: 6:00 AM - 10:00 PM</p>
                    <p>Sat - Sun: 8:00 AM - 8:00 PM</p>
                </div>
            </div>
        </section>

        <footer class="bg-dark-primary py-6">
            <div class="text-center text-gray-500">
                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                </div>
                &copy; 2025 Bodyfit Tengah Sawah. All Rights Reserved.
            </div>
        </footer>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>