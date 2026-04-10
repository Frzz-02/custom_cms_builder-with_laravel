<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('page_title', $settings->site_title ?? 'MitraCom - Coming Soon')</title>
    <meta name="title" content="@yield('meta_title', $settings->site_title ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="description" content="@yield('meta_description', $settings->site_description ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="keywords" content="@yield('meta_keywords', $settings->site_keywords ?? 'MitraCom')">
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($settings->favicon ?? 'favicon.png')) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Gradient Animation */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
        }
        
        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }
        .delay-4 { animation-delay: 0.8s; opacity: 0; }
        
        /* Pulse Animation */
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        
        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black animate-gradient min-h-screen flex items-center justify-center p-4 overflow-hidden">

    

    <!-- Background Overlay Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dots)"/>
        </svg>
    </div>

    <div class="relative z-10 text-center max-w-5xl mx-auto px-4">
        
        <!-- Logo -->
        @if(isset($settings->logo))
        <div class="fade-in-up mb-12">
            <img src="{{ asset('storage/' . $settings->logo) }}" 
                 alt="{{ $settings->site_title }}" 
                 class="h-16 md:h-20 w-auto mx-auto">
        </div>
        @endif

        <!-- Main Heading -->
        <div class="fade-in-up delay-1 mb-6">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white mb-4 tracking-tight">
                SEGERA HADIR
            </h1>
            <div class="h-1 w-24 md:w-32 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto"></div>
        </div>

        <!-- Description -->
        <div class="fade-in-up delay-2 mb-16">
            <p class="text-lg md:text-xl lg:text-2xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Kami sedang mempersiapkan sesuatu yang luar biasa untuk Anda.
                <br class="hidden md:block">
                Segera hadir dengan pengalaman yang lebih baik!
            </p>
        </div>

        <!-- Countdown Timer -->
        <div class="fade-in-up delay-3 mb-16">
            <div id="countdown" class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto">
                <!-- Days -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 md:p-8 hover:bg-white/20 transition-all duration-300">
                    <div id="days" class="text-4xl md:text-6xl font-bold text-white mb-2">00</div>
                    <div class="text-sm md:text-base text-gray-400 uppercase tracking-widest">Hari</div>
                </div>
                
                <!-- Hours -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 md:p-8 hover:bg-white/20 transition-all duration-300">
                    <div id="hours" class="text-4xl md:text-6xl font-bold text-white mb-2">00</div>
                    <div class="text-sm md:text-base text-gray-400 uppercase tracking-widest">Jam</div>
                </div>
                
                <!-- Minutes -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 md:p-8 hover:bg-white/20 transition-all duration-300">
                    <div id="minutes" class="text-4xl md:text-6xl font-bold text-white mb-2">00</div>
                    <div class="text-sm md:text-base text-gray-400 uppercase tracking-widest">Menit</div>
                </div>
                
                <!-- Seconds -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 md:p-8 hover:bg-white/20 transition-all duration-300">
                    <div id="seconds" class="text-4xl md:text-6xl font-bold text-white mb-2">00</div>
                    <div class="text-sm md:text-base text-gray-400 uppercase tracking-widest">Detik</div>
                </div>
            </div>
        </div>

        <!-- Notify Me Form -->
        <div class="fade-in-up delay-4 mb-12">
            <p class="text-gray-400 mb-4 text-sm md:text-base">Dapatkan notifikasi saat kami launching!</p>
            <form id="notifyForm" class="max-w-md mx-auto flex flex-col sm:flex-row gap-3">
                <input type="email" 
                       id="emailInput"
                       placeholder="Email Anda" 
                       required
                       class="flex-1 px-6 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-white/40 transition-colors">
                <button type="submit" 
                        class="px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-105 whitespace-nowrap">
                    Beritahu Saya
                </button>
            </form>
            <p id="formMessage" class="mt-4 text-sm text-green-400 hidden"></p>
        </div>

        <!-- Social Links -->
        <div class="fade-in-up delay-4">
            <p class="text-gray-400 mb-4 text-sm">Ikuti kami di social media:</p>
            <div class="flex justify-center gap-4">
                @if(isset($settings->facebook_url))
                <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" 
                   class="w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-full hover:bg-white/20 transition-all duration-300 text-white hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                @endif
                
                @if(isset($settings->instagram_url))
                <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" 
                   class="w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-full hover:bg-white/20 transition-all duration-300 text-white hover:scale-110">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                @endif
                
                @if(isset($settings->twitter_url))
                <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer" 
                   class="w-12 h-12 flex items-center justify-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-full hover:bg-white/20 transition-all duration-300 text-white hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- WhatsApp Button -->
    @if(isset($whatsappButton) && $whatsappButton->status == 'active')
    <script>
    (function() {
        var waBtn = document.createElement('a');
        waBtn.href = 'https://api.whatsapp.com/send/?phone={{ $whatsappButton->phone_number }}&text={{ urlencode($whatsappButton->message ?? 'Halo') }}&type=phone_number&app_absent=0';
        waBtn.target = '_blank';
        waBtn.rel = 'noopener noreferrer';
        waBtn.setAttribute('aria-label', 'Chat WhatsApp');
        waBtn.innerHTML = '<svg viewBox="0 0 24 24" style="width:28px;height:28px;fill:white;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
        
        var position = '{{ $whatsappButton->position ?? "right" }}' === 'left' ? 'left' : 'right';
        var offsetX = '{{ $whatsappButton->offset_x ?? 20 }}';
        var offsetY = '{{ $whatsappButton->offset_y ?? 20 }}';
        
        waBtn.style.cssText = 'position:fixed;bottom:' + offsetY + 'px;' + position + ':' + offsetX + 'px;z-index:9999;width:56px;height:56px;background-color:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.3);text-decoration:none;transition:all 0.2s ease;';

        waBtn.onmouseover = function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 6px 20px rgba(37,211,102,0.5)';
        };
        waBtn.onmouseout = function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
        };

        document.documentElement.appendChild(waBtn);
    })();
    </script>
    @endif

    <!-- Countdown Timer Script -->
    <script>
    (function() {
        // Set launch date (30 days from now - customize this)
        const launchDate = new Date();
        launchDate.setDate(launchDate.getDate() + 30);
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = launchDate.getTime() - now;
            
            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<div class="col-span-4 text-white text-2xl">We are Live!</div>';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        // Handle notify form
        const form = document.getElementById('notifyForm');
        const message = document.getElementById('formMessage');
        const emailInput = document.getElementById('emailInput');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = emailInput.value;
            
            // Here you would typically send this to your backend
            // For now, just show a success message
            message.textContent = 'Terima kasih! Kami akan mengirim notifikasi ke ' + email;
            message.classList.remove('hidden');
            emailInput.value = '';
            
            setTimeout(() => {
                message.classList.add('hidden');
            }, 5000);
        });
    })();
    </script>

</body>
</html>


    <meta property="og:type"        content="website">
    <meta property="og:title"       content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', '')">

    <title>@yield('title', 'Coming Soon — ' . config('app.name'))</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/apex favicon.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Tailwind & App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'DM Sans', sans-serif; }

        /* Page fade-in */
        body { opacity: 0; transition: opacity 0.5s ease; }
        body.ready { opacity: 1; }

        /* Animated gradient background */
        .bg-animated {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0c1445 65%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradientShift 14s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particle dots */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            animation: floatUp linear infinite;
        }
        @keyframes floatUp {
            0%   { transform: translateY(110vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-120px) scale(1); opacity: 0; }
        }

        /* Countdown flip pulse */
        .cd-pulse {
            animation: countPulse 0.18s ease-out;
        }
        @keyframes countPulse {
            0%   { transform: scale(1.2); opacity: 0.6; }
            100% { transform: scale(1);   opacity: 1; }
        }

        /* Staggered slide-up reveal */
        .slide-up {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .slide-up.visible { opacity: 1; transform: translateY(0); }
    </style>

    @stack('styles')
</head>

<body class="bg-animated min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Floating Particles (injected by JS) -->
    <div id="particles-container" class="absolute inset-0 pointer-events-none overflow-hidden"></div>

    <!-- Glowing orbs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Content -->
    <div class="relative z-10 w-full text-center px-6 max-w-3xl mx-auto py-10">

        {{-- Child view can completely override via @section('content'),
             or add extra content below the default hero via @section('extra_content') --}}
        @hasSection('content')
            @yield('content')
        @else
            <!-- Brand / Logo -->
            <div class="slide-up mb-8">
                <p class="text-xs tracking-[0.45em] text-indigo-300 uppercase mb-3">Coming Soon</p>
                <h1 class="text-5xl sm:text-7xl font-bold text-white tracking-tight leading-none">
                    {{ config('app.name') }}
                </h1>
                <div class="w-16 h-px bg-indigo-400 mx-auto mt-6"></div>
            </div>

            <!-- Tagline -->
            <p class="slide-up text-lg sm:text-xl text-gray-300 leading-relaxed mb-12"
               data-delay="150">
                Kami sedang mempersiapkan sesuatu yang luar biasa.<br class="hidden sm:block">
                Nantikan peluncurannya!
            </p>

            <!-- Countdown -->
            <div class="slide-up mb-12" data-delay="300">
                <div id="countdown" class="flex justify-center gap-3 sm:gap-8">
                    <div class="text-center">
                        <div id="cd-days"    class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Hari</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-hours"   class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Jam</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-minutes" class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Menit</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-seconds" class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Detik</p>
                    </div>
                </div>
            </div>

            <!-- Email notify form -->
            <div class="slide-up" data-delay="450">
                <p class="text-sm text-gray-500 mb-4">Beritahu saya saat website live</p>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto"
                      onsubmit="handleNotify(event)">
                    <input type="email"
                           placeholder="email@anda.com"
                           class="w-full sm:flex-1 bg-white/10 border border-white/20 text-white placeholder-gray-600 px-5 py-3 text-sm focus:outline-none focus:border-indigo-400 transition-colors backdrop-blur-sm"
                           required>
                    <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold tracking-wider px-8 py-3 transition-colors">
                        NOTIFY ME
                    </button>
                </form>
                <p id="notify-msg" class="mt-3 text-sm text-green-400 hidden">
                    ✓ Terima kasih! Kami akan menghubungi Anda.
                </p>
            </div>
        @endif

        @yield('extra_content')
    </div>

    <!-- Alpine.js (for child views that may need it) -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Pure JS: Page reveal + Particles + Countdown -->
    <script>
    // ── Page reveal ────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('ready');

        // Staggered slide-up
        var slides = document.querySelectorAll('.slide-up');
        slides.forEach(function (el, i) {
            setTimeout(function () {
                el.classList.add('visible');
            }, 120 + i * 150);
        });

        // ── Floating particles ───────────────────────────────────────────────
        var container = document.getElementById('particles-container');
        if (container) {
            for (var i = 0; i < 28; i++) {
                (function () {
                    var p   = document.createElement('div');
                    p.className = 'particle';
                    var sz  = Math.random() * 7 + 3;
                    p.style.width    = sz + 'px';
                    p.style.height   = sz + 'px';
                    p.style.left     = Math.random() * 100 + '%';
                    p.style.animationDuration  = (Math.random() * 18 + 10) + 's';
                    p.style.animationDelay     = (Math.random() * 14) + 's';
                    container.appendChild(p);
                })();
            }
        }
    });

    // ── Countdown Timer ────────────────────────────────────────────────────────
    (function () {
        var launchDate = new Date('@yield("launch_date", "2026-09-01T00:00:00")').getTime();
        if (isNaN(launchDate)) { launchDate = new Date('2026-09-01T00:00:00').getTime(); }

        function pad(n) { return String(n).padStart(2, '0'); }

        function pulse(id, val) {
            var el = document.getElementById(id);
            if (!el) return;
            var fmt = pad(val);
            if (el.textContent !== fmt) {
                el.textContent = fmt;
                el.classList.remove('cd-pulse');
                void el.offsetWidth;
                el.classList.add('cd-pulse');
            }
        }

        function tick() {
            var diff = launchDate - Date.now();
            if (diff < 0) diff = 0;
            pulse('cd-days',    Math.floor(diff / 86400000));
            pulse('cd-hours',   Math.floor((diff % 86400000) / 3600000));
            pulse('cd-minutes', Math.floor((diff % 3600000) / 60000));
            pulse('cd-seconds', Math.floor((diff % 60000) / 1000));
        }

        tick();
        setInterval(tick, 1000);
    })();

    // ── Notify form ────────────────────────────────────────────────────────────
    function handleNotify(e) {
        e.preventDefault();
        var msg = document.getElementById('notify-msg');
        if (msg) { msg.classList.remove('hidden'); e.target.reset(); }
    }
    </script>


    
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
    </script>    
    

    @stack('scripts')
</body>

</html>
