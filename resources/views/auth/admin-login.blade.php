<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Portal Login - ASL SMS HUB</title>
    <meta name="description" content="Secure Admin Login & Two-Factor OTP Authentication for ASL SMS HUB." />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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
                        'blob': 'blob 10s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -40px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #070a12;
            color: #f1f5f9;
            min-height: 100vh;
        }
        .bg-auth-image {
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(7, 10, 18, 0.75) 0%, rgba(7, 10, 18, 0.95) 100%),
                url('https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .glass-panel {
            background: rgba(12, 18, 34, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 40px -10px rgba(59, 130, 246, 0.2);
        }
        .glow-effect {
            position: absolute;
            filter: blur(90px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.5;
        }
        .otp-input-field {
            letter-spacing: 0.5em;
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
        }
    </style>
</head>
<body class="bg-auth-image flex items-center justify-center p-4 sm:p-6 min-h-screen relative overflow-x-hidden selection:bg-brand-500 selection:text-white">

    <!-- Ambient Glowing Orbs -->
    <div class="fixed -top-20 -left-20 w-96 h-96 bg-brand-600/25 rounded-full glow-effect animate-blob"></div>
    <div class="fixed top-1/2 -right-20 w-96 h-96 bg-indigo-600/20 rounded-full glow-effect animate-blob" style="animation-delay: 3s;"></div>
    <div class="fixed -bottom-20 left-1/3 w-96 h-96 bg-cyan-600/20 rounded-full glow-effect animate-blob" style="animation-delay: 6s;"></div>

    <!-- Main Container -->
    <div class="w-full max-w-md relative z-10 my-auto">
        
        <!-- Brand Header Logo -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group transition-transform hover:scale-105">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 via-indigo-600 to-cyan-400 p-[2px] shadow-xl shadow-brand-500/30">
                    <div class="w-full h-full bg-dark-900 rounded-[14px] flex items-center justify-center relative overflow-hidden">
                        <!-- Custom SMS Icon -->
                        <svg class="w-6 h-6 text-brand-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="url(#admin-logo-grad)" />
                            <circle cx="7" cy="10" r="1.5" fill="#ffffff" />
                            <circle cx="12" cy="10" r="1.5" fill="#ffffff" />
                            <circle cx="17" cy="10" r="1.5" fill="#ffffff" />
                            <defs>
                                <linearGradient id="admin-logo-grad" x1="2" y1="2" x2="22" y2="22" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3B82F6"/>
                                    <stop offset="1" stop-color="#06B6D4"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-1">
                        ASL SMS <span class="text-brand-400">HUB</span>
                    </span>
                    <span class="text-[10px] block font-semibold uppercase tracking-widest text-slate-400 -mt-0.5">Admin Security Center</span>
                </div>
            </a>
        </div>

        <!-- Glassmorphism Login Card -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 transition-all duration-300">
            
            <!-- Card Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <h1 id="cardTitle" class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Admin Sign In</h1>
                    <span id="stepBadge" class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-brand-500/15 text-brand-300 border border-brand-500/30 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-xs text-brand-400"></i>
                        <span>Step 1 of 2</span>
                    </span>
                </div>
                <p id="cardSubtitle" class="text-slate-400 text-xs sm:text-sm mt-1.5">
                    Enter your administrative credentials to continue.
                </p>
            </div>

            <!-- Global Feedback Message Box -->
            <div id="formMessage" class="mb-4"></div>

            <!-- Active User Chip (Appears only during OTP Step) -->
            <div id="activeUserChip" class="hidden mb-5 p-3.5 rounded-2xl bg-dark-900/90 border border-brand-500/30 flex items-center justify-between transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-sm font-bold border border-brand-500/30">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Verifying Admin</p>
                        <p id="activeUsernameDisplay" class="text-sm font-bold text-white font-mono">admin</p>
                    </div>
                </div>
                <button type="button" onclick="resetToCredentialsStep()" class="text-xs text-brand-400 hover:text-brand-300 hover:underline flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Change</span>
                </button>
            </div>

            <!-- Login / OTP Form -->
            <form id="formAuthentication" action="{{ route('admin.login') }}" method="POST" data-step="credentials" class="space-y-4">
                @csrf

                <!-- Username Input Container (Visible ONLY in Step 1) -->
                <div id="usernameContainer" class="space-y-1.5">
                    <label for="admin_username" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                        Admin Username <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input
                            type="text"
                            id="admin_username"
                            name="admin_username"
                            value="{{ old('admin_username') }}"
                            placeholder="Enter your admin username"
                            required
                            autofocus
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-dark-900/90 border border-white/15 text-white text-sm placeholder:text-slate-500 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
                        />
                    </div>
                    @error('admin_username')
                        <p class="text-rose-400 text-xs font-medium mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Input Container (Visible ONLY in Step 1) -->
                <div id="passwordContainer" class="space-y-1.5 password-container">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                            Password <span class="text-rose-400">*</span>
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            class="w-full pl-10 pr-11 py-3 rounded-xl bg-dark-900/90 border border-white/15 text-white text-sm placeholder:text-slate-500 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
                        />
                        <button type="button" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white transition focus:outline-none">
                            <i id="passwordToggleIcon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-400 text-xs font-medium mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- OTP Verification Container (Visible ONLY in Step 2) -->
                <div id="otpVerification" class="hidden space-y-1.5 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <label for="otp" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                            6-Digit Verification Code <span class="text-brand-400">*</span>
                        </label>
                        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-clock"></i> Valid for 5 mins
                        </span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-brand-400">
                            <i class="fa-solid fa-key text-sm"></i>
                        </div>
                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            placeholder="······"
                            maxlength="6"
                            autocomplete="one-time-code"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl bg-dark-900/90 border border-brand-500/50 text-white text-lg font-mono tracking-widest otp-input-field placeholder:text-slate-600 focus:outline-none focus:border-brand-400 focus:ring-4 focus:ring-brand-500/20 transition shadow-inner"
                        />
                    </div>
                    <p class="text-slate-400 text-xs mt-1">
                        Please enter the one-time authentication passcode generated for your session.
                    </p>
                    @error('otp')
                        <p class="text-rose-400 text-xs font-medium mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox (Required) -->
                <div id="rememberContainer" class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            value="1"
                            required
                            class="w-4 h-4 rounded bg-dark-900 border-white/20 text-brand-600 focus:ring-brand-500 focus:ring-offset-dark-900 accent-brand-600"
                        />
                        <span class="text-xs font-medium text-slate-300 hover:text-white">
                            Remember this device <span class="text-rose-400 font-bold">*</span>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    id="submitButton"
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500 hover:from-brand-500 hover:to-cyan-400 text-white font-bold text-sm shadow-xl shadow-brand-600/30 hover:shadow-brand-600/50 hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 mt-4"
                >
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span id="submitBtnText">Sign In to Admin</span>
                </button>
            </form>

            <!-- Card Footer -->
            <div class="mt-6 pt-5 border-t border-white/10 text-center">
                <p class="text-xs text-slate-400 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-lock text-[11px] text-emerald-400"></i>
                    <span>Authorized Administrative Personnel Only</span>
                </p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-slate-200 transition flex items-center justify-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Return to Main Website</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Security Footer Badge -->
        <div class="mt-6 text-center text-[11px] text-slate-500 flex items-center justify-center gap-4">
            <span class="flex items-center gap-1"><i class="fa-solid fa-shield-check text-emerald-400"></i> 256-Bit SSL Encrypted</span>
            <span>•</span>
            <span>ASL SMS HUB v{{ app()->version() }}</span>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- JAVASCRIPT LOGIC (STEP HANDLING, AJAX AUTH & SECURITY) -->
    <!-- ========================================================================= -->
    <script>
        const form = document.getElementById('formAuthentication');
        const usernameContainer = document.getElementById('usernameContainer');
        const passwordContainer = document.getElementById('passwordContainer');
        const otpSection = document.getElementById('otpVerification');
        const rememberContainer = document.getElementById('rememberContainer');
        const activeUserChip = document.getElementById('activeUserChip');
        const activeUsernameDisplay = document.getElementById('activeUsernameDisplay');
        const submitButton = document.getElementById('submitButton');
        const submitBtnText = document.getElementById('submitBtnText');
        const messageBox = document.getElementById('formMessage');
        const rememberCheckbox = document.getElementById('remember');
        const cardTitle = document.getElementById('cardTitle');
        const cardSubtitle = document.getElementById('cardSubtitle');
        const stepBadge = document.getElementById('stepBadge');
        const otpInput = document.getElementById('otp');
        const adminUsernameInput = document.getElementById('admin_username');

        // Toggle Password Visibility
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Show Alert Messages
        function showMessage(message, type = 'info') {
            let bgClass = 'bg-blue-500/10 border-blue-500/30 text-blue-300';
            let icon = 'fa-circle-info';

            if (type === 'danger') {
                bgClass = 'bg-rose-500/10 border-rose-500/30 text-rose-300';
                icon = 'fa-circle-exclamation';
            } else if (type === 'warning') {
                bgClass = 'bg-amber-500/10 border-amber-500/30 text-amber-300';
                icon = 'fa-triangle-exclamation';
            } else if (type === 'success') {
                bgClass = 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300';
                icon = 'fa-circle-check';
            }

            messageBox.innerHTML = `
                <div class="p-3.5 rounded-xl border text-xs leading-relaxed flex items-start gap-2.5 ${bgClass} transition-all duration-200">
                    <i class="fa-solid ${icon} mt-0.5 shrink-0 text-sm"></i>
                    <div class="flex-1">${message}</div>
                </div>
            `;
        }

        // Clear Messages
        function clearMessage() {
            messageBox.innerHTML = '';
        }

        // Switch between Step 1 (Credentials) and Step 2 (OTP)
        function setStep(step) {
            form.dataset.step = step;
            if (step === 'otp') {
                // HIDE USERNAME & PASSWORD INPUTS
                usernameContainer.classList.add('hidden');
                passwordContainer.classList.add('hidden');
                rememberContainer.classList.add('hidden');

                // SHOW ACTIVE USER CHIP & OTP INPUT
                activeUserChip.classList.remove('hidden');
                activeUsernameDisplay.textContent = adminUsernameInput.value.trim() || 'Admin';
                otpSection.classList.remove('hidden');

                // UPDATE HEADINGS & BADGE
                cardTitle.textContent = 'Two-Factor Authentication';
                cardSubtitle.textContent = 'Enter the 6-digit OTP code sent to your registered channel.';
                stepBadge.innerHTML = '<i class="fa-solid fa-key text-xs text-amber-400"></i><span>Step 2 of 2</span>';
                stepBadge.className = 'px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-amber-500/15 text-amber-300 border border-amber-500/30 flex items-center gap-1.5';
                
                submitBtnText.textContent = 'Verify OTP & Enter';

                // AUTO-FOCUS OTP
                setTimeout(() => {
                    if (otpInput) {
                        otpInput.value = '';
                        otpInput.focus();
                    }
                }, 100);
            } else {
                // RESET TO STEP 1
                usernameContainer.classList.remove('hidden');
                passwordContainer.classList.remove('hidden');
                rememberContainer.classList.remove('hidden');

                activeUserChip.classList.add('hidden');
                otpSection.classList.add('hidden');

                cardTitle.textContent = 'Admin Sign In';
                cardSubtitle.textContent = 'Enter your administrative credentials to continue.';
                stepBadge.innerHTML = '<i class="fa-solid fa-shield-halved text-xs text-brand-400"></i><span>Step 1 of 2</span>';
                stepBadge.className = 'px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-brand-500/15 text-brand-300 border border-brand-500/30 flex items-center gap-1.5';
                
                submitBtnText.textContent = 'Sign In to Admin';
            }
        }

        // Reset to Step 1 from OTP
        function resetToCredentialsStep() {
            clearMessage();
            setStep('credentials');
            if (otpInput) otpInput.value = '';
            const pwd = document.getElementById('password');
            if (pwd) {
                pwd.value = '';
                pwd.focus();
            }
        }

        // Restrict OTP input to numbers only
        if (otpInput) {
            otpInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 6);
            });
        }

        // Handle AJAX Form Submission
        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            clearMessage();

            const step = form.dataset.step || 'credentials';

            if (step === 'credentials' && !rememberCheckbox.checked) {
                showMessage('Please check "Remember this device" to proceed with login.', 'danger');
                rememberCheckbox.focus();
                return;
            }

            const endpoint = step === 'otp' ? '{{ route('admin.login.verify_otp') }}' : '{{ route('admin.login') }}';
            const formData = new FormData(form);
            const body = new URLSearchParams();

            body.append('_token', formData.get('_token'));
            body.append('admin_username', formData.get('admin_username'));
            body.append('remember', rememberCheckbox.checked ? '1' : '0');
            
            if (step === 'credentials') {
                body.append('password', formData.get('password'));
            } else {
                body.append('otp', formData.get('otp'));
            }

            submitButton.disabled = true;
            submitBtnText.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-1"></i> ${step === 'otp' ? 'Verifying OTP...' : 'Authenticating...'}`;

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: body.toString(),
                });

                const data = await response.json();

                if (!response.ok || data.status === false) {
                    showMessage(data.message || 'Authentication failed. Please check your inputs.', 'danger');
                    if (data.requires_otp) {
                        setStep('otp');
                    }
                    return;
                }

                if (data.requires_otp) {
                    setStep('otp');
                    let msg = data.message || 'OTP verification required. Please enter the code.';
                    if (data.otp) {
                        msg += ` <strong class="block mt-1 font-mono text-amber-300">Development OTP: ${data.otp}</strong>`;
                    }
                    showMessage(msg, 'warning');
                    return;
                }

                if (data.redirect) {
                    showMessage('Authentication successful! Redirecting to Admin Dashboard...', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 500);
                    return;
                }

                showMessage('Login successful, redirecting...', 'success');
            } catch (error) {
                showMessage('Network error or server unreachable. Please try again.', 'danger');
            } finally {
                submitButton.disabled = false;
                submitBtnText.textContent = form.dataset.step === 'otp' ? 'Verify OTP & Enter' : 'Sign In to Admin';
            }
        });
    </script>
</body>
</html>
