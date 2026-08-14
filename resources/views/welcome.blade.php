<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ASL SMS HUB - Enterprise Bulk SMS & Global OTP Gateway Platform</title>
    <meta name="description" content="ASL SMS HUB - Carrier-grade Enterprise Bulk SMS Platform. Send high-priority OTPs, transactional alerts, and promotional campaigns worldwide with 99.99% uptime and sub-second delivery.">
    <meta name="keywords" content="asl sms hub, bulk sms, sms gateway, otp gateway, transactional sms, promotional sms, dlt registration, sms portal, two way sms">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Anti-flicker Theme Initialization -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#0f172a',
                        },
                        dark: {
                            900: '#070a12',
                            800: '#0c1222',
                            700: '#11192e',
                            600: '#182442',
                            500: '#24335c',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'blob': 'blob 10s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-12px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -40px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        }
        .dark .glass-card {
            background: rgba(17, 25, 46, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: none;
        }
        .glass-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.2);
        }
        .dark .glass-card-hover:hover {
            background: rgba(24, 36, 66, 0.8);
            border-color: rgba(96, 165, 250, 0.35);
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.25);
        }
        .gradient-text {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .gradient-text {
            background: linear-gradient(135deg, #ffffff 20%, #93c5fd 60%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #0c1222;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #24335c;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.04) 1px, transparent 1px);
        }
        .dark .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
        .glow-effect {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.35;
        }
        .dark .glow-effect {
            opacity: 0.45;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-[#070a12] dark:text-slate-100 antialiased selection:bg-brand-500 selection:text-white transition-colors duration-300">

    <!-- Ambient Background Glows -->
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-blue-500/15 dark:bg-blue-600/20 rounded-full glow-effect animate-blob"></div>
    <div class="fixed top-1/3 right-10 w-96 h-96 bg-indigo-500/15 dark:bg-indigo-600/15 rounded-full glow-effect animate-blob" style="animation-delay: 3s;"></div>
    <div class="fixed bottom-10 left-1/3 w-[500px] h-[500px] bg-cyan-500/15 dark:bg-cyan-600/15 rounded-full glow-effect animate-blob" style="animation-delay: 6s;"></div>

    <!-- ========================================================================= -->
    <!-- NAVIGATION BAR -->
    <!-- ========================================================================= -->
    <header class="sticky top-0 z-50 w-full backdrop-blur-xl bg-white/80 dark:bg-[#070a12]/85 border-b border-slate-200 dark:border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand SMS Logo (ASL SMS HUB) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 via-indigo-600 to-cyan-400 p-[2px] shadow-lg shadow-brand-500/25 group-hover:shadow-brand-500/50 transition-all duration-300">
                        <div class="w-full h-full bg-white dark:bg-dark-900 rounded-[14px] flex items-center justify-center relative overflow-hidden">
                            <!-- Custom SMS Chat Bubble SVG Logo -->
                            <svg class="w-6 h-6 text-brand-600 dark:text-brand-400 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="url(#sms-nav-grad)" />
                                <circle cx="7" cy="10" r="1.5" fill="#ffffff" />
                                <circle cx="12" cy="10" r="1.5" fill="#ffffff" />
                                <circle cx="17" cy="10" r="1.5" fill="#ffffff" />
                                <defs>
                                    <linearGradient id="sms-nav-grad" x1="2" y1="2" x2="22" y2="22" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#3B82F6"/>
                                        <stop offset="1" stop-color="#06B6D4"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-1.5">
                            ASL SMS <span class="text-brand-600 dark:text-brand-400">HUB</span>
                        </span>
                        <span class="text-[10px] block font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 -mt-0.5">Carrier Gateway</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-300">
                    <a href="#features" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Features</a>
                    <a href="#simulator" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors flex items-center gap-1.5">
                        <span>Live Sandbox</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-brand-500/15 text-brand-600 dark:text-brand-300 border border-brand-500/30">Interactive</span>
                    </a>
                    <a href="#solutions" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Solutions</a>
                    <a href="#routes" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Carrier Routes</a>
                    <a href="#pricing" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Pricing</a>
                    <a href="#faq" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">FAQ</a>
                </nav>

                <!-- Actions: Theme Switcher & Login -->
                <div class="hidden sm:flex items-center gap-3">
                    
                    <!-- Dark / Light Mode Toggle Button -->
                    <button id="theme-toggle" type="button" aria-label="Toggle Light / Dark Mode" class="p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-100 hover:bg-slate-200 dark:bg-dark-800 dark:hover:bg-dark-700 text-slate-700 dark:text-slate-300 hover:text-brand-600 dark:hover:text-brand-400 transition-all flex items-center justify-center gap-2 group shadow-sm">
                        <i id="theme-toggle-dark-icon" class="fa-solid fa-moon text-indigo-400 text-sm hidden"></i>
                        <i id="theme-toggle-light-icon" class="fa-solid fa-sun text-amber-500 text-sm hidden"></i>
                        <span class="text-xs font-semibold hidden xl:inline" id="theme-label">Mode</span>
                    </button>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white text-sm font-semibold hover:from-brand-500 hover:to-indigo-500 shadow-lg shadow-brand-600/30 hover:shadow-brand-600/50 hover:scale-[1.02] transition-all">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500 text-white text-sm font-semibold hover:opacity-95 shadow-lg shadow-brand-600/30 hover:shadow-brand-600/50 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i>
                            <span>Sign In</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu & Theme Switcher Button -->
                <div class="flex lg:hidden items-center gap-2">
                    <button id="mobile-theme-btn-nav" type="button" aria-label="Toggle Theme" class="p-2.5 rounded-xl bg-slate-100 dark:bg-dark-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10">
                        <i id="mobile-nav-theme-icon" class="fa-solid fa-sun text-amber-500 text-sm"></i>
                    </button>
                    <button id="mobile-menu-toggle" type="button" aria-label="Toggle Navigation Menu" class="p-2.5 rounded-xl bg-slate-100 dark:bg-dark-800 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white border border-slate-200 dark:border-white/10 focus:outline-none">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-b border-slate-200 dark:border-white/10 bg-white/95 dark:bg-dark-900/95 backdrop-blur-2xl px-4 pt-3 pb-6 transition-all duration-300">
            <nav class="flex flex-col gap-3 font-medium text-slate-700 dark:text-slate-200">
                <a href="#features" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">Features</a>
                <a href="#simulator" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5 flex items-center justify-between">
                    <span>Live Sandbox</span>
                    <span class="px-2 py-0.5 text-xs rounded bg-brand-500/20 text-brand-600 dark:text-brand-300">Interactive</span>
                </a>
                <a href="#solutions" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">Solutions</a>
                <a href="#routes" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">Carrier Routes</a>
                <a href="#pricing" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">Pricing</a>
                <a href="#faq" class="mobile-nav-link px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">FAQ</a>
                
                <!-- Mobile Theme Toggle Option -->
                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 my-1">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-circle-half-stroke text-brand-500"></i> Theme Appearance
                    </span>
                    <button type="button" id="mobile-drawer-theme-toggle" class="px-3 py-1 rounded-lg bg-white dark:bg-dark-800 border border-slate-300 dark:border-white/15 text-xs font-bold text-slate-800 dark:text-white shadow-sm flex items-center gap-1.5">
                        <i id="drawer-theme-icon" class="fa-solid fa-moon text-indigo-400"></i>
                        <span id="drawer-theme-text">Dark Mode</span>
                    </button>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-white/10 flex flex-col gap-2.5">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-brand-600 text-white font-semibold shadow-md">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 text-white font-semibold shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i>
                            <span>Sign In to Portal</span>
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>


    <!-- ========================================================================= -->
    <!-- HERO SECTION -->
    <!-- ========================================================================= -->
    <section class="relative pt-12 pb-20 md:pt-20 md:pb-32 overflow-hidden bg-grid-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <!-- Live SLA Badge -->
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-700 dark:text-brand-300 text-xs sm:text-sm font-semibold mb-6">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Tier-1 Carrier Direct Routes • 99.99% Delivery SLA</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.15] mb-6">
                        Enterprise Bulk SMS & <br class="hidden sm:inline">
                        <span class="gradient-text">Ultra-Fast OTP Gateway</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto lg:mx-0 mb-8 font-normal leading-relaxed">
                        ASL SMS HUB powers high-volume promotional broadcasts, transactional alerts, and mission-critical 2FA OTPs with sub-second delivery, 100% DLT compliance, and dedicated telecommunication direct pipes.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-10">
                        @auth
                            <a href="{{ route('user.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500 text-white font-bold text-base shadow-xl shadow-brand-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>Go to Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500 text-white font-bold text-base shadow-xl shadow-brand-600/30 hover:shadow-brand-600/50 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Sign In to Portal</span>
                            </a>
                        @endauth
                        <a href="#simulator" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-white hover:bg-slate-100 dark:bg-dark-800/90 dark:hover:bg-dark-700 text-slate-800 dark:text-slate-200 hover:text-brand-600 dark:hover:text-white font-semibold text-base border border-slate-200 dark:border-white/15 hover:border-brand-500/40 shadow-sm transition-all">
                            <i class="fa-solid fa-play text-brand-500 dark:text-brand-400 text-sm"></i>
                            <span>Test Live Simulator</span>
                        </a>
                    </div>

                    <!-- Trust Metric Highlights -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-200 dark:border-white/10 max-w-lg mx-auto lg:mx-0">
                        <div class="text-center lg:text-left">
                            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">99.99%</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Delivery SLA</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-2xl sm:text-3xl font-extrabold text-brand-600 dark:text-brand-400">&lt; 1.8s</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Avg OTP Speed</p>
                        </div>
                        <div class="text-center lg:text-left">
                            <p class="text-2xl sm:text-3xl font-extrabold text-cyan-600 dark:text-cyan-400">180+</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Global Operators</p>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Visual - Live Interactive Phone & Campaign Stream -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <!-- Glow Behind Phone -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-600/20 to-cyan-500/20 blur-3xl -z-10 rounded-full"></div>

                    <!-- Smartphone Mockup -->
                    <div class="relative w-[320px] sm:w-[350px] rounded-[44px] p-3 bg-slate-900 shadow-2xl border-4 border-slate-700/80 shadow-brand-500/10 animate-float">
                        <!-- Top Notch & Speaker -->
                        <div class="w-full flex justify-center items-center py-2 relative">
                            <div class="w-24 h-4 bg-slate-800 rounded-full flex items-center justify-between px-3">
                                <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                <div class="w-8 h-1 rounded-full bg-slate-700"></div>
                            </div>
                        </div>

                        <!-- Phone Screen -->
                        <div class="w-full bg-[#0a0f1d] rounded-[36px] p-4 text-xs font-sans overflow-hidden border border-white/5 shadow-inner">
                            <!-- Status Bar -->
                            <div class="flex justify-between items-center text-[11px] text-slate-400 mb-4 px-1">
                                <span class="font-bold text-white">09:41</span>
                                <div class="flex items-center gap-1.5 text-[10px]">
                                    <i class="fa-solid fa-signal"></i>
                                    <span>5G</span>
                                    <i class="fa-solid fa-battery-full text-emerald-400"></i>
                                </div>
                            </div>

                            <!-- Messages Header -->
                            <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/10">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-brand-600/30 text-brand-400 flex items-center justify-center font-bold text-xs border border-brand-500/30">
                                        DLT
                                    </div>
                                    <div>
                                        <p class="font-bold text-white text-xs">ASL-NOTIFY</p>
                                        <p class="text-[10px] text-emerald-400 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span> Verified Header
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-400 bg-white/5 px-2 py-0.5 rounded">Just now</span>
                            </div>

                            <!-- Live SMS Message Bubbles -->
                            <div class="space-y-3 py-1">
                                <!-- Bubble 1: OTP -->
                                <div class="bg-dark-800/90 border border-brand-500/30 p-3 rounded-2xl rounded-tl-sm shadow-sm">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-[10px] font-bold text-brand-400 uppercase tracking-wider">Authentication OTP</span>
                                        <span class="text-[9px] text-slate-400">1.2s ago</span>
                                    </div>
                                    <p class="text-slate-200 text-[11px] leading-relaxed">
                                        Your ASL SMS HUB Verification Code is <strong class="text-white bg-brand-500/20 px-1.5 py-0.5 rounded text-xs font-mono font-bold text-brand-300">849201</strong>. Valid for 5 minutes. Do not share with anyone.
                                    </p>
                                    <div class="mt-2 flex items-center justify-end text-[9px] text-emerald-400 gap-1">
                                        <i class="fa-solid fa-check-double"></i> Delivered in 1.1s
                                    </div>
                                </div>

                                <!-- Bubble 2: Transaction Alert -->
                                <div class="bg-dark-800/90 border border-white/10 p-3 rounded-2xl rounded-tl-sm shadow-sm">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">Bank Alert</span>
                                        <span class="text-[9px] text-slate-400">2m ago</span>
                                    </div>
                                    <p class="text-slate-300 text-[11px] leading-relaxed">
                                        Acct **4892 debited for <span class="text-white font-semibold">$149.00</span> at CloudServices on 14-Aug. Bal: $4,892.50.
                                    </p>
                                    <div class="mt-2 flex items-center justify-end text-[9px] text-emerald-400 gap-1">
                                        <i class="fa-solid fa-check-double"></i> Delivered
                                    </div>
                                </div>

                                <!-- Bubble 3: Promotional Discount -->
                                <div class="bg-dark-800/90 border border-purple-500/30 p-3 rounded-2xl rounded-tl-sm shadow-sm">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-[10px] font-bold text-purple-400 uppercase tracking-wider">Flash Sale</span>
                                        <span class="text-[9px] text-slate-400">10m ago</span>
                                    </div>
                                    <p class="text-slate-300 text-[11px] leading-relaxed">
                                        🎉 ASL Special! Use code <span class="text-purple-300 font-bold">SUPER50</span> to get 50% extra SMS credits on all recharge plans today!
                                    </p>
                                </div>
                            </div>

                            <!-- Delivery Telemetry pill -->
                            <div class="mt-3 pt-2 border-t border-white/10 flex items-center justify-between text-[10px] text-slate-400">
                                <span class="flex items-center gap-1 text-emerald-400">
                                    <i class="fa-solid fa-circle-check"></i> Tier-1 Direct Pipe
                                </span>
                                <span>Speed: 5,000 TPS</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge Card 1 -->
                    <div class="absolute -bottom-6 -left-4 sm:-left-8 glass-card p-3 sm:p-4 rounded-2xl border border-slate-200 dark:border-white/10 shadow-2xl flex items-center gap-3 max-w-[210px] animate-float-delayed">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">DLT Compliant</p>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400">100% Approved Headers</p>
                        </div>
                    </div>

                    <!-- Floating Badge Card 2 -->
                    <div class="absolute -top-4 -right-2 sm:-right-6 glass-card p-3 sm:p-4 rounded-2xl border border-slate-200 dark:border-white/10 shadow-2xl flex items-center gap-3 max-w-[200px] animate-float">
                        <div class="w-10 h-10 rounded-xl bg-brand-500/20 text-brand-600 dark:text-brand-400 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Instant DLR</p>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400">Real-Time Delivery</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- TRUSTED CLIENTS / ENTERPRISES -->
    <!-- ========================================================================= -->
    <section class="py-10 border-y border-slate-200 dark:border-white/5 bg-slate-100/70 dark:bg-dark-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs uppercase tracking-widest font-semibold text-slate-500 dark:text-slate-400 mb-8">
                Trusted by 10,000+ Enterprises, FinTechs, Retail Brands & Digital Leaders
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-14 opacity-70 hover:opacity-100 transition-opacity">
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-building-columns text-brand-600 dark:text-brand-400"></i> ApexFinTech
                </div>
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-cart-shopping text-cyan-600 dark:text-cyan-400"></i> HyperShop
                </div>
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-hospital text-rose-500 dark:text-rose-400"></i> CareHealth
                </div>
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-graduation-cap text-amber-500 dark:text-amber-400"></i> EduSpark
                </div>
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-truck-fast text-emerald-500 dark:text-emerald-400"></i> SwiftLogistics
                </div>
                <div class="flex items-center gap-2 font-bold text-lg text-slate-700 dark:text-slate-300">
                    <i class="fa-solid fa-cloud text-indigo-500 dark:text-indigo-400"></i> CloudScale
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- INTERACTIVE LIVE SMS SIMULATOR / SANDBOX -->
    <!-- ========================================================================= -->
    <section id="simulator" class="py-20 lg:py-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-microchip"></i> Live Interactive Sandbox
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Experience Lightning-Fast SMS Transmission
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-4 text-base sm:text-lg">
                    Type any message below to preview character counts, credits consumed, unicode auto-detection, and simulated real-time carrier delivery latency.
                </p>
            </div>

            <!-- Sandbox Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Input Form -->
                <div class="lg:col-span-7 glass-card p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-white/10 shadow-2xl">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-200 dark:border-white/10">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-sm font-bold text-slate-900 dark:text-white">Live Route Simulator</span>
                        </div>
                        <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-white/5 px-2.5 py-1 rounded-lg">Interactive Mode</span>
                    </div>

                    <div class="space-y-5">
                        <!-- Route Selection -->
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 tracking-wider mb-2">Select Route / Channel</label>
                            <div class="grid grid-cols-3 gap-2.5">
                                <button type="button" onclick="selectRoute('Transactional', 'ASL-NOTIFY')" class="route-btn active-route px-3 py-2.5 rounded-xl border border-brand-500 bg-brand-500/15 text-brand-700 dark:text-white text-xs font-semibold flex items-center justify-center gap-2 transition-all" data-route="Transactional">
                                    <i class="fa-solid fa-key text-brand-500 dark:text-brand-400"></i>
                                    <span>Transactional/OTP</span>
                                </button>
                                <button type="button" onclick="selectRoute('Promotional', 'ASL-OFFER')" class="route-btn px-3 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-dark-800 text-slate-700 dark:text-slate-300 hover:border-slate-300 text-xs font-semibold flex items-center justify-center gap-2 transition-all" data-route="Promotional">
                                    <i class="fa-solid fa-bullhorn text-amber-500 dark:text-amber-400"></i>
                                    <span>Promotional</span>
                                </button>
                                <button type="button" onclick="selectRoute('Two-Way', 'ASL-2WAY')" class="route-btn px-3 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-dark-800 text-slate-700 dark:text-slate-300 hover:border-slate-300 text-xs font-semibold flex items-center justify-center gap-2 transition-all" data-route="Two-Way">
                                    <i class="fa-solid fa-comments text-cyan-500 dark:text-cyan-400"></i>
                                    <span>Two-Way SMS</span>
                                </button>
                            </div>
                        </div>

                        <!-- Sender ID & Phone Number -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 tracking-wider mb-2">Sender ID / Header</label>
                                <div class="relative">
                                    <input type="text" id="sim-sender-id" value="ASL-NOTIFY" maxlength="11" class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-dark-800 border border-slate-200 dark:border-white/15 text-slate-900 dark:text-white font-mono text-sm focus:outline-none focus:border-brand-500 uppercase">
                                    <span class="absolute right-3 top-2.5 text-xs text-emerald-500 font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Approved
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 tracking-wider mb-2">Recipient Number</label>
                                <input type="text" id="sim-recipient" value="+1 (555) 019-2834" class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-dark-800 border border-slate-200 dark:border-white/15 text-slate-900 dark:text-white font-mono text-sm focus:outline-none focus:border-brand-500">
                            </div>
                        </div>

                        <!-- Message Text Area -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold uppercase text-slate-600 dark:text-slate-300 tracking-wider">SMS Message Content</label>
                                <div class="flex gap-2">
                                    <button type="button" onclick="loadSampleText('otp')" class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-medium">Sample OTP</button>
                                    <span class="text-slate-400 dark:text-slate-600">•</span>
                                    <button type="button" onclick="loadSampleText('promo')" class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-medium">Sample Promo</button>
                                    <span class="text-slate-400 dark:text-slate-600">•</span>
                                    <button type="button" onclick="loadSampleText('alert')" class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-medium">Sample Alert</button>
                                </div>
                            </div>
                            <textarea id="sim-message" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-100 dark:bg-dark-800 border border-slate-200 dark:border-white/15 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-brand-500 custom-scrollbar leading-relaxed" placeholder="Type your SMS message here...">Your OTP for ASL SMS HUB Portal login is 940215. Valid for 10 minutes. Please do not share this OTP with anyone.</textarea>
                        </div>

                        <!-- Counters & Telemetry Bar -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-100 dark:bg-dark-900/80 p-3.5 rounded-xl border border-slate-200 dark:border-white/5 text-center">
                            <div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Characters</p>
                                <p id="sim-char-count" class="text-base font-bold text-slate-900 dark:text-white">106</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">SMS Parts</p>
                                <p id="sim-credit-count" class="text-base font-bold text-brand-600 dark:text-brand-400">1 Credit</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Encoding</p>
                                <p id="sim-encoding" class="text-base font-bold text-emerald-500">GSM 7-bit</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">DLT Status</p>
                                <p class="text-base font-bold text-cyan-600 dark:text-cyan-400">Passed</p>
                            </div>
                        </div>

                        <!-- Send Button -->
                        <button type="button" id="sim-send-btn" onclick="triggerSimulatedSend()" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-sm shadow-lg shadow-brand-600/30 flex items-center justify-center gap-2 hover:scale-[1.01] active:scale-[0.99] transition-all">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Simulate Instant Delivery</span>
                        </button>
                    </div>
                </div>

                <!-- Right Live Preview Device -->
                <div class="lg:col-span-5 glass-card p-6 rounded-3xl border border-slate-200 dark:border-white/10 flex flex-col">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200 dark:border-white/10">
                        <span class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400 tracking-wider">Device Live Screen</span>
                        <span id="sim-live-status" class="text-xs font-semibold text-emerald-500 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Ready to Receive
                        </span>
                    </div>

                    <!-- Screen Preview Container -->
                    <div class="bg-slate-900 rounded-2xl p-4 border border-white/5 flex-grow flex flex-col justify-between min-h-[300px]">
                        <div>
                            <!-- Simulated Notification Banner -->
                            <div id="sim-notification" class="hidden mb-4 p-3 rounded-xl bg-dark-700/90 border border-brand-500/40 shadow-xl transition-all duration-300 animate-bounce">
                                <div class="flex items-center justify-between text-[11px] text-slate-400 mb-1">
                                    <span class="font-bold text-white flex items-center gap-1">
                                        <i class="fa-solid fa-comment-sms text-brand-400"></i> <span id="sim-notif-header">ASL-NOTIFY</span>
                                    </span>
                                    <span>Now</span>
                                </div>
                                <p id="sim-notif-body" class="text-xs text-slate-200 line-clamp-2">Message received</p>
                            </div>

                            <!-- Main Message Thread -->
                            <div class="space-y-3">
                                <div class="text-center">
                                    <span class="text-[10px] text-slate-400 bg-white/5 px-2 py-0.5 rounded-full">Today</span>
                                </div>

                                <div id="sim-delivered-bubble" class="bg-brand-600/20 border border-brand-500/40 p-3.5 rounded-2xl rounded-tl-sm text-slate-100 transition-all">
                                    <div class="flex justify-between items-center text-[10px] text-brand-400 mb-1">
                                        <span id="sim-preview-sender" class="font-bold">ASL-NOTIFY</span>
                                        <span id="sim-preview-time">Just now</span>
                                    </div>
                                    <p id="sim-preview-text" class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                                        Your OTP for ASL SMS HUB Portal login is 940215. Valid for 10 minutes. Please do not share this OTP with anyone.
                                    </p>
                                    <div class="mt-2 flex items-center justify-end gap-1 text-[10px] text-emerald-400">
                                        <i class="fa-solid fa-check-double"></i>
                                        <span id="sim-delivery-latency">Delivered in 1.4s</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Telemetry Log -->
                        <div class="mt-6 pt-3 border-t border-white/10 font-mono text-[11px] text-slate-400 space-y-1">
                            <div class="flex justify-between">
                                <span>Message ID:</span>
                                <span class="text-white" id="sim-msg-id">msg_8f93a10c</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Carrier Node:</span>
                                <span class="text-brand-400">ASL-DIRECT-PIPE</span>
                            </div>
                            <div class="flex justify-between">
                                <span>DLR Status:</span>
                                <span class="text-emerald-400 font-bold" id="sim-dlr-status">DELIVRD (0x000)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- FEATURES & CAPABILITIES GRID -->
    <!-- ========================================================================= -->
    <section id="features" class="py-20 lg:py-28 bg-slate-100/60 dark:bg-dark-900/50 border-t border-slate-200 dark:border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Unmatched Performance
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Engineered for High-Volume Messaging & High Delivery
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-4 text-base sm:text-lg">
                    Everything you need to broadcast millions of messages effortlessly with highest deliverability and lowest latency.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Feature 1 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center text-2xl mb-6 border border-brand-500/30">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Sub-Second OTP Routing</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Dedicated high-priority queues for time-critical 2FA, OTPs, and alerts with automatic telco failover and &lt; 2s delivery SLA.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/15 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-2xl mb-6 border border-cyan-500/30">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">100% DLT Compliance</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Seamless management of Principal Entity IDs, Header/Sender IDs, Consent Templates, and scrubbing filters to prevent regulatory rejection.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl mb-6 border border-indigo-500/30">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Custom Sender ID Management</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Register multiple custom brand sender headers, transactional alphanumeric IDs, and promotional routing tags with instant approval tracking.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/15 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl mb-6 border border-purple-500/30">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Real-Time DLR Analytics</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Track live campaign delivery rates, click-through rates on shortened links, undelivered reason codes, and operator performance.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mb-6 border border-emerald-500/30">
                        <i class="fa-solid fa-address-book"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Smart Audience Manager</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Upload millions of contacts via Excel/CSV, segment by tags, schedule recurring broadcasts, and scrub against global DND lists automatically.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card glass-card-hover p-8 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center text-2xl mb-6 border border-rose-500/30">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Global Tier-1 Reach</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                        Direct interconnections with over 800+ mobile operators across 180+ countries for seamless cross-border delivery with zero hops.
                    </p>
                </div>

            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- SOLUTIONS BY USE CASE / INDUSTRY -->
    <!-- ========================================================================= -->
    <section id="solutions" class="py-20 lg:py-28 bg-white dark:bg-dark-900/40 border-t border-slate-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-layer-group"></i> Tailored Solutions
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Powering Every Business Communication Channel
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-4 text-base sm:text-lg">
                    Whether you are an eCommerce store, a digital bank, or a healthcare provider, ASL SMS HUB provides specialized messaging architecture for your exact use case.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1 -->
                <div class="glass-card p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-brand-500/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">OTP & 2FA Gateway</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
                        Zero-delay authentication codes with automated backup carrier failover, ensuring your user signups and logins are never stalled.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="glass-card p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-cyan-500/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/15 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Promotional Campaigns</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
                        Broadcast flash sales, festive offers, and personalized marketing messages to millions of contacts with instant click tracking.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="glass-card p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-indigo-500/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Transactional Alerts</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
                        Bank account balances, invoice receipts, shipping status, booking confirmations, and mission-critical event triggers 24/7.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="glass-card p-6 rounded-2xl border border-slate-200 dark:border-white/10 hover:border-purple-500/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/15 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Voice SMS & WhatsApp</h3>
                    <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed">
                        Expand beyond standard SMS with automated outbound voice broadcast, interactive IVR, and official WhatsApp Business message integration.
                    </p>
                </div>

            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- CARRIER ROUTES & GLOBAL NETWORK -->
    <!-- ========================================================================= -->
    <section id="routes" class="py-20 lg:py-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 sm:p-14 rounded-3xl border border-slate-200 dark:border-white/10 relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                            <i class="fa-solid fa-network-wired"></i> High-Throughput Network
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                            Carrier-Grade Infrastructure with Direct Telecom Pipes
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 mt-4 text-base leading-relaxed">
                            ASL SMS HUB directly interfaces with national and international telecom operators to bypass intermediary aggregators, maximizing speed, security, and delivery rates.
                        </p>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="bg-slate-100 dark:bg-dark-900/80 p-4 rounded-xl border border-slate-200 dark:border-white/5">
                                <p class="text-2xl font-extrabold text-slate-900 dark:text-white">5,000+</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">TPS Capacity</p>
                            </div>
                            <div class="bg-slate-100 dark:bg-dark-900/80 p-4 rounded-xl border border-slate-200 dark:border-white/5">
                                <p class="text-2xl font-extrabold text-emerald-500">0 Hops</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Direct Carrier Pipe</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-6 space-y-3">
                        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-dark-900/90 border border-slate-200 dark:border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">Transactional Route (OTP / Alerts)</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">24/7 Delivery with Instant DND bypass for critical OTPs</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20">Active</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-dark-900/90 border border-slate-200 dark:border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">Promotional Route (Campaigns)</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">High-volume marketing with automated DND scrubbing</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-cyan-600 dark:text-cyan-400 bg-cyan-500/10 px-2.5 py-1 rounded-lg border border-cyan-500/20">Active</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-dark-900/90 border border-slate-200 dark:border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">Two-Way SMS & Virtual Numbers</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Receive inbound replies, surveys, and customer feedback</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-500/10 px-2.5 py-1 rounded-lg border border-indigo-500/20">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- INTERACTIVE PRICING CALCULATOR & PLANS -->
    <!-- ========================================================================= -->
    <section id="pricing" class="py-20 lg:py-28 relative bg-slate-100/50 dark:bg-dark-900/50 border-t border-slate-200 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400 border border-brand-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-tags"></i> Transparent Volume Pricing
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Simple, Transparent, Pay-As-You-Grow
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-4 text-base sm:text-lg">
                    No setup fees. No hidden maintenance charges. Volume discounts apply automatically.
                </p>
            </div>

            <!-- Interactive Volume Calculator Bar -->
            <div class="glass-card p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-white/10 max-w-4xl mx-auto mb-16 shadow-2xl">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white">Interactive Volume Cost Estimator</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Slide to estimate your monthly SMS volume & cost</p>
                    </div>
                    <div class="text-right">
                        <span id="calc-volume-display" class="text-2xl sm:text-3xl font-extrabold text-brand-600 dark:text-brand-400">50,000</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase block">SMS / Month</span>
                    </div>
                </div>

                <!-- Range Slider -->
                <input type="range" id="pricing-slider" min="5000" max="500000" step="5000" value="50000" oninput="updatePricingEstimate(this.value)" class="w-full h-2.5 bg-slate-200 dark:bg-dark-800 rounded-lg appearance-none cursor-pointer accent-brand-500">

                <div class="flex justify-between text-[11px] text-slate-500 dark:text-slate-400 mt-2 font-mono">
                    <span>5,000 SMS</span>
                    <span>100,000 SMS</span>
                    <span>250,000 SMS</span>
                    <span>500,000+ SMS</span>
                </div>

                <!-- Estimated Cost Card -->
                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-white/10 grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                    <div class="bg-slate-100 dark:bg-dark-900/80 p-3.5 rounded-xl border border-slate-200 dark:border-white/5">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Rate per SMS</p>
                        <p id="calc-rate-display" class="text-xl font-bold text-emerald-500">$0.0038</p>
                    </div>
                    <div class="bg-slate-100 dark:bg-dark-900/80 p-3.5 rounded-xl border border-slate-200 dark:border-white/5">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Estimated Total</p>
                        <p id="calc-total-display" class="text-xl font-bold text-slate-900 dark:text-white">$190.00</p>
                    </div>
                    <div class="bg-slate-100 dark:bg-dark-900/80 p-3.5 rounded-xl border border-slate-200 dark:border-white/5">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Credits Expiry</p>
                        <p class="text-xl font-bold text-cyan-600 dark:text-cyan-400">Lifetime Valid</p>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                
                <!-- Starter Plan -->
                <div class="glass-card p-8 rounded-3xl border border-slate-200 dark:border-white/10 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Starter Pack</div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Pay As You Go</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-6">Perfect for small projects, startups & basic OTP notifications.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6 pb-6 border-b border-slate-200 dark:border-white/10">
                            <span class="text-4xl font-extrabold text-slate-900 dark:text-white">$0.0045</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">/ SMS</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>High-Speed Transactional Route</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Free DLT & Sender ID Support</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Realtime Delivery Reports</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Contact Manager & CSV Upload</span>
                            </li>
                            <li class="flex items-center gap-2.5 text-slate-400 dark:text-slate-500">
                                <i class="fa-solid fa-xmark text-xs"></i>
                                <span>Dedicated Account Manager</span>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('login') }}" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/20 text-slate-900 dark:text-white font-bold text-center text-sm transition-all border border-slate-200 dark:border-transparent">
                        Sign In to Portal
                    </a>
                </div>

                <!-- Business / Growth (Featured) -->
                <div class="glass-card p-8 rounded-3xl border-2 border-brand-500 relative flex flex-col justify-between shadow-2xl shadow-brand-500/15 bg-white dark:bg-dark-800/90">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-brand-600 to-cyan-500 text-white text-[11px] font-bold uppercase tracking-wider shadow-lg">
                        Most Popular
                    </div>

                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-brand-600 dark:text-brand-400 mb-2">Growth Tier</div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Business Scale</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-6">For high-growth apps, fintechs, and marketing teams.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6 pb-6 border-b border-slate-200 dark:border-white/10">
                            <span class="text-4xl font-extrabold text-slate-900 dark:text-white">$0.0035</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">/ SMS</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span><strong>Sub-Second</strong> OTP Priority Queue</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Dynamic Sender ID & Multi-Header</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>5,000 TPS Concurrency</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Campaign Analytics & DLR Logs</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Priority 24/7 Chat & Ticket Support</span>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('login') }}" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-center text-sm shadow-lg shadow-brand-600/30 transition-all">
                        Sign In & Recharge
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="glass-card p-8 rounded-3xl border border-slate-200 dark:border-white/10 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-cyan-600 dark:text-cyan-400 mb-2">Custom Volume</div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Enterprise Wholesale</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-6">For telecoms, banking institutions & multi-million broadcasts.</p>
                        
                        <div class="flex items-baseline gap-1 mb-6 pb-6 border-b border-slate-200 dark:border-white/10">
                            <span class="text-4xl font-extrabold text-slate-900 dark:text-white">Custom</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Wholesale Slab</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Direct SMPP Server Connectivity</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Custom 99.99% Uptime SLA Agreement</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Dedicated Telecom Direct Pipe</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Dedicated Account Manager</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                                <span>Custom Postpaid Billing Slabs</span>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('login') }}" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/20 text-slate-900 dark:text-white font-bold text-center text-sm transition-all border border-slate-200 dark:border-transparent">
                        Contact Sales
                    </a>
                </div>

            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- FREQUENTLY ASKED QUESTIONS (ACCORDION) -->
    <!-- ========================================================================= -->
    <section id="faq" class="py-20 lg:py-28 bg-slate-50 dark:bg-dark-900/50 border-t border-slate-200 dark:border-white/5">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 text-xs font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-circle-question"></i> Got Questions?
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Frequently Asked Questions
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-3 text-base">
                    Find quick answers regarding our ASL SMS HUB platform, DLT registration, delivery tracking, and credit validity.
                </p>
            </div>

            <div class="space-y-4">
                
                <!-- FAQ Item 1 -->
                <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden">
                    <button type="button" onclick="toggleFaq(1)" class="w-full px-6 py-4 text-left flex items-center justify-between font-bold text-slate-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        <span>How fast is your OTP delivery speed?</span>
                        <i id="faq-icon-1" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-1" class="hidden px-6 pb-5 text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-white/5 pt-3">
                        Our Transactional and OTP pipelines use dedicated Tier-1 carrier direct links with smart multi-carrier redundancy. The average latency is under 1.8 seconds worldwide.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden">
                    <button type="button" onclick="toggleFaq(2)" class="w-full px-6 py-4 text-left flex items-center justify-between font-bold text-slate-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        <span>What is DLT registration and do you assist with it?</span>
                        <i id="faq-icon-2" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-2" class="hidden px-6 pb-5 text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-white/5 pt-3">
                        DLT (Distributed Ledger Technology) is a regulatory requirement mandated by telecom authorities to safeguard consumers against spam. We provide full assistance to help you register your Principal Entity, approved Sender Headers, and Content Templates.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden">
                    <button type="button" onclick="toggleFaq(3)" class="w-full px-6 py-4 text-left flex items-center justify-between font-bold text-slate-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        <span>Do prepaid SMS credits expire?</span>
                        <i id="faq-icon-3" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-2" class="hidden px-6 pb-5 text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-white/5 pt-3">
                        No! All prepaid SMS recharge credits come with <strong>Lifetime Validity</strong>. You can use your purchased balance anytime without fear of expiration.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden">
                    <button type="button" onclick="toggleFaq(4)" class="w-full px-6 py-4 text-left flex items-center justify-between font-bold text-slate-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        <span>How are Delivery Reports (DLR) tracked?</span>
                        <i id="faq-icon-4" class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="faq-content-4" class="hidden px-6 pb-5 text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-white/5 pt-3">
                        You can view live interactive status updates (Delivered, Sent, Undelivered, DND Blocked) directly inside your web portal dashboard in real-time.
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- BOTTOM CALL TO ACTION -->
    <!-- ========================================================================= -->
    <section id="contact" class="py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl p-8 sm:p-14 overflow-hidden bg-gradient-to-r from-brand-900 via-dark-800 to-dark-900 border border-brand-500/30 shadow-2xl text-white">
                <!-- Background glow inside banner -->
                <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 text-center lg:text-left">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                            Ready to Elevate Your Customer Messaging?
                        </h2>
                        <p class="text-slate-300 mt-3 text-base max-w-2xl">
                            Sign in to your ASL SMS HUB portal to launch high-impact campaigns, manage contacts, and track live carrier delivery reports.
                        </p>
                    </div>

                    <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                        <a href="{{ route('login') }}" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-500 via-indigo-600 to-cyan-500 text-white font-bold text-center text-sm shadow-xl shadow-brand-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>Sign In to Portal</span>
                        </a>
                        <a href="#simulator" class="w-full py-3.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-center text-sm border border-white/10 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-play text-brand-400 text-xs"></i>
                            <span>Try Live Sandbox</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- FOOTER -->
    <!-- ========================================================================= -->
    <footer class="border-t border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-dark-900 pt-16 pb-12 text-slate-500 dark:text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-[1.5px]">
                            <div class="w-full h-full bg-white dark:bg-dark-900 rounded-[10px] flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="#3B82F6" />
                                    <circle cx="7" cy="10" r="1.5" fill="#ffffff" />
                                    <circle cx="12" cy="10" r="1.5" fill="#ffffff" />
                                    <circle cx="17" cy="10" r="1.5" fill="#ffffff" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-1">
                            ASL SMS <span class="text-brand-600 dark:text-brand-400">HUB</span>
                        </span>
                    </a>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed max-w-sm">
                        ASL SMS HUB - High-availability enterprise messaging gateway. Delivering mission-critical OTPs, transactional alerts, and smart bulk marketing campaigns worldwide.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            All Carrier Routes Operational
                        </span>
                    </div>
                </div>

                <!-- Column 1: Solutions -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-4">Solutions</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-white transition">Bulk SMS Gateway</a></li>
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-white transition">OTP & 2FA Routing</a></li>
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-white transition">Transactional Alerts</a></li>
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-white transition">Two-Way SMS</a></li>
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-white transition">Voice SMS Broadcast</a></li>
                    </ul>
                </div>

                <!-- Column 2: Quick Links & Access -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-4">Portals & Quick Links</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-brand-600 dark:hover:text-white transition flex items-center gap-1.5"><i class="fa-solid fa-right-to-bracket text-xs text-brand-600 dark:text-brand-400"></i> Customer Sign In</a></li>
                        <li><a href="#simulator" class="hover:text-brand-600 dark:hover:text-white transition">Live Route Simulator</a></li>
                        <li><a href="#routes" class="hover:text-brand-600 dark:hover:text-white transition">Carrier Routes</a></li>
                        <li><a href="#pricing" class="hover:text-brand-600 dark:hover:text-white transition">Volume Pricing</a></li>
                        <li><a href="#faq" class="hover:text-brand-600 dark:hover:text-white transition">Help & FAQ</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Sub-Footer -->
            <div class="pt-8 border-t border-slate-200 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <p>&copy; {{ date('Y') }} ASL SMS HUB. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-900 dark:hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-900 dark:hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-slate-900 dark:hover:text-white transition">DLT Compliance Guidelines</a>
                    <a href="#" class="hover:text-slate-900 dark:hover:text-white transition">Security</a>
                </div>
            </div>
        </div>
    </footer>


    <!-- ========================================================================= -->
    <!-- JAVASCRIPT LOGIC FOR SIMULATOR, THEME TOGGLE & INTERACTION -->
    <!-- ========================================================================= -->
    <script>
        // ==========================================
        // Dark / Light Theme Toggle Engine
        // ==========================================
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const themeLabel = document.getElementById('theme-label');
        const mobileNavThemeBtn = document.getElementById('mobile-theme-btn-nav');
        const mobileNavThemeIcon = document.getElementById('mobile-nav-theme-icon');
        const drawerThemeToggle = document.getElementById('mobile-drawer-theme-toggle');
        const drawerThemeIcon = document.getElementById('drawer-theme-icon');
        const drawerThemeText = document.getElementById('drawer-theme-text');

        function applyThemeMode(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                
                if (darkIcon) darkIcon.classList.add('hidden');
                if (lightIcon) lightIcon.classList.remove('hidden');
                if (themeLabel) themeLabel.textContent = 'Light Mode';

                if (mobileNavThemeIcon) mobileNavThemeIcon.className = 'fa-solid fa-sun text-amber-400 text-sm';
                if (drawerThemeIcon) drawerThemeIcon.className = 'fa-solid fa-sun text-amber-400 text-sm';
                if (drawerThemeText) drawerThemeText.textContent = 'Light Mode';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');

                if (darkIcon) darkIcon.classList.remove('hidden');
                if (lightIcon) lightIcon.classList.add('hidden');
                if (themeLabel) themeLabel.textContent = 'Dark Mode';

                if (mobileNavThemeIcon) mobileNavThemeIcon.className = 'fa-solid fa-moon text-indigo-500 text-sm';
                if (drawerThemeIcon) drawerThemeIcon.className = 'fa-solid fa-moon text-indigo-500 text-sm';
                if (drawerThemeText) drawerThemeText.textContent = 'Dark Mode';
            }
        }

        // Initialize Theme State
        const isCurrentDark = document.documentElement.classList.contains('dark');
        applyThemeMode(isCurrentDark);

        function toggleTheme() {
            const isDarkNow = document.documentElement.classList.contains('dark');
            applyThemeMode(!isDarkNow);
        }

        if (themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);
        if (mobileNavThemeBtn) mobileNavThemeBtn.addEventListener('click', toggleTheme);
        if (drawerThemeToggle) drawerThemeToggle.addEventListener('click', toggleTheme);


        // ==========================================
        // Mobile Navigation Drawer Toggle
        // ==========================================
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.replace('fa-bars', 'fa-xmark');
                } else {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.replace('fa-xmark', 'fa-bars');
                }
            });

            // Close mobile menu when clicking nav links
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.replace('fa-xmark', 'fa-bars');
                });
            });
        }


        // ==========================================
        // Live SMS Simulator Logic
        // ==========================================
        const simMessage = document.getElementById('sim-message');
        const simCharCount = document.getElementById('sim-char-count');
        const simCreditCount = document.getElementById('sim-credit-count');
        const simEncoding = document.getElementById('sim-encoding');
        const simPreviewText = document.getElementById('sim-preview-text');
        const simSenderId = document.getElementById('sim-sender-id');
        const simPreviewSender = document.getElementById('sim-preview-sender');
        const simNotifHeader = document.getElementById('sim-notif-header');
        const simNotifBody = document.getElementById('sim-notif-body');

        function updateLiveCounters() {
            if (!simMessage) return;
            const text = simMessage.value;
            const len = text.length;
            
            // Check Unicode
            const isUnicode = /[^\u0000-\u00ff]/.test(text);
            
            if (simCharCount) simCharCount.textContent = len;
            if (simEncoding) simEncoding.textContent = isUnicode ? 'Unicode (UTF-8)' : 'GSM 7-bit';

            // Calculate SMS credits
            let credits = 1;
            if (!isUnicode) {
                credits = len <= 160 ? 1 : Math.ceil(len / 153);
            } else {
                credits = len <= 70 ? 1 : Math.ceil(len / 67);
            }
            if (simCreditCount) simCreditCount.textContent = `${credits} Credit${credits > 1 ? 's' : ''}`;

            // Update screen preview
            if (simPreviewText) simPreviewText.textContent = text || 'Empty message body...';
            if (simNotifBody) simNotifBody.textContent = text || 'Empty message body...';
        }

        if (simMessage) {
            simMessage.addEventListener('input', updateLiveCounters);
        }
        if (simSenderId) {
            simSenderId.addEventListener('input', () => {
                const header = simSenderId.value || 'ASL-NOTIFY';
                if (simPreviewSender) simPreviewSender.textContent = header;
                if (simNotifHeader) simNotifHeader.textContent = header;
            });
        }

        // Sample Text Loader
        function loadSampleText(type) {
            if (!simMessage) return;
            if (type === 'otp') {
                const randomOtp = Math.floor(100000 + Math.random() * 900000);
                simMessage.value = `Your OTP for ASL SMS HUB Portal login is ${randomOtp}. Valid for 10 minutes. Please do not share this OTP with anyone.`;
                if (simSenderId) simSenderId.value = 'ASL-NOTIFY';
            } else if (type === 'promo') {
                simMessage.value = `🎉 ASL Mega Weekend Offer! Get flat 30% extra SMS credits on all recharge plans today! Use promo code FLASH30.`;
                if (simSenderId) simSenderId.value = 'ASL-OFFER';
            } else if (type === 'alert') {
                simMessage.value = `Dear Customer, your order #ASL-88219 has been dispatched via Express Delivery and will arrive tomorrow by 4:00 PM.`;
                if (simSenderId) simSenderId.value = 'ASL-ALERT';
            }
            updateLiveCounters();
            if (simSenderId) {
                const header = simSenderId.value;
                if (simPreviewSender) simPreviewSender.textContent = header;
                if (simNotifHeader) simNotifHeader.textContent = header;
            }
        }

        // Route Selector
        function selectRoute(routeName, defaultSender) {
            document.querySelectorAll('.route-btn').forEach(btn => {
                btn.classList.remove('active-route', 'border-brand-500', 'bg-brand-500/15', 'text-brand-700', 'dark:text-white');
                btn.classList.add('border-slate-200', 'dark:border-white/10', 'bg-slate-100', 'dark:bg-dark-800', 'text-slate-700', 'dark:text-slate-300');
            });
            const activeBtn = document.querySelector(`[data-route="${routeName}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active-route', 'border-brand-500', 'bg-brand-500/15', 'text-brand-700', 'dark:text-white');
                activeBtn.classList.remove('border-slate-200', 'dark:border-white/10', 'bg-slate-100', 'dark:bg-dark-800', 'text-slate-700', 'dark:text-slate-300');
            }
            if (simSenderId) {
                simSenderId.value = defaultSender;
                if (simPreviewSender) simPreviewSender.textContent = defaultSender;
                if (simNotifHeader) simNotifHeader.textContent = defaultSender;
            }
        }

        // Simulated Send Trigger with realistic latency
        function triggerSimulatedSend() {
            const sendBtn = document.getElementById('sim-send-btn');
            const liveStatus = document.getElementById('sim-live-status');
            const deliveredBubble = document.getElementById('sim-delivered-bubble');
            const notification = document.getElementById('sim-notification');
            const msgId = document.getElementById('sim-msg-id');
            const latencyDisplay = document.getElementById('sim-delivery-latency');

            if (sendBtn) {
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Transmitting over Carrier Pipe...';
            }
            if (liveStatus) {
                liveStatus.innerHTML = '<span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span> Routing...';
                liveStatus.className = 'text-xs font-semibold text-amber-500 flex items-center gap-1.5';
            }

            const latency = (0.8 + Math.random() * 0.7).toFixed(1);

            setTimeout(() => {
                if (notification) {
                    notification.classList.remove('hidden');
                    setTimeout(() => notification.classList.add('hidden'), 4000);
                }
                if (deliveredBubble) {
                    deliveredBubble.classList.add('ring-2', 'ring-emerald-400');
                    setTimeout(() => deliveredBubble.classList.remove('ring-2', 'ring-emerald-400'), 1500);
                }
                if (liveStatus) {
                    liveStatus.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-400"></span> Delivered';
                    liveStatus.className = 'text-xs font-semibold text-emerald-500 flex items-center gap-1.5';
                }
                if (msgId) {
                    msgId.textContent = 'msg_' + Math.random().toString(36).substring(2, 10);
                }
                if (latencyDisplay) {
                    latencyDisplay.textContent = `Delivered in ${latency}s`;
                }
                if (sendBtn) {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fa-solid fa-check text-emerald-500 mr-2"></i> Sent Successfully! Test Again';
                }
            }, 1000);
        }

        // Pricing Estimator Slider
        function updatePricingEstimate(volume) {
            const vol = parseInt(volume);
            const volDisplay = document.getElementById('calc-volume-display');
            const rateDisplay = document.getElementById('calc-rate-display');
            const totalDisplay = document.getElementById('calc-total-display');

            let rate = 0.0045;
            if (vol >= 250000) rate = 0.0030;
            else if (vol >= 100000) rate = 0.0034;
            else if (vol >= 50000) rate = 0.0038;
            else if (vol >= 20000) rate = 0.0042;

            const total = (vol * rate).toFixed(2);

            if (volDisplay) volDisplay.textContent = vol.toLocaleString();
            if (rateDisplay) rateDisplay.textContent = `$${rate.toFixed(4)}`;
            if (totalDisplay) totalDisplay.textContent = `$${total}`;
        }

        // FAQ Accordion Toggle
        function toggleFaq(id) {
            const content = document.getElementById(`faq-content-${id}`);
            const icon = document.getElementById(`faq-icon-${id}`);
            if (!content) return;

            const isHidden = content.classList.contains('hidden');
            // Close all
            for (let i = 1; i <= 4; i++) {
                const c = document.getElementById(`faq-content-${i}`);
                const ic = document.getElementById(`faq-icon-${i}`);
                if (c) c.classList.add('hidden');
                if (ic) ic.classList.remove('rotate-180');
            }

            if (isHidden) {
                content.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        }
    </script>
</body>
</html>
