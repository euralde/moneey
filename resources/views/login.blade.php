<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFRO'PLUME - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-gradient-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.25);
        }
        input:-webkit-autofill,
        input:-webkit-autofill:focus {
            transition: background-color 600000s 0s, color 600000s 0s;
        }
    </style>
</head>
<body class="bg-gradient-custom min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-6xl mx-auto fade-in">
        <div class="flex flex-col lg:flex-row bg-white/5 backdrop-blur-sm rounded-2xl overflow-hidden shadow-2xl border border-white/10">

            <!-- Left Side - Branding -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-between bg-white/5">
                <div>
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                            <iconify-icon icon="solar:pen-2-bold" class="text-white text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white tracking-tight">AFRO'PLUME</h1>
                            <p class="text-blue-300 text-xs font-medium tracking-wide">Gestion intelligente</p>
                        </div>
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">
                        Bienvenue sur votre<br>
                        <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">espace de gestion</span>
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed mb-8">
                        Gérez efficacement votre entreprise avec notre plateforme intuitive.
                        Suivez vos finances, vos employés, vos projets et bien plus encore.
                    </p>

                    <div class="space-y-4 mt-8">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <iconify-icon icon="solar:chart-2-linear" class="text-blue-400 text-sm"></iconify-icon>
                            </div>
                            <span class="text-sm">Tableau de bord en temps réel</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <iconify-icon icon="solar:users-group-rounded-linear" class="text-blue-400 text-sm"></iconify-icon>
                            </div>
                            <span class="text-sm">Gestion RH et recrutements</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <iconify-icon icon="solar:wallet-money-linear" class="text-blue-400 text-sm"></iconify-icon>
                            </div>
                            <span class="text-sm">Suivi financier complet</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <iconify-icon icon="solar:chat-dots-linear" class="text-blue-400 text-sm"></iconify-icon>
                            </div>
                            <span class="text-sm">Messagerie interne sécurisée</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-white/10">
                    <p class="text-slate-400 text-xs">
                        &copy; {{ date('Y') }} AFRO'PLUME. Tous droits réservés.<br>
                        Protection de vos données garantie.
                    </p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="lg:w-1/2 p-8 lg:p-12 bg-white rounded-t-2xl lg:rounded-l-none lg:rounded-r-2xl">
                <div class="mb-8 text-center lg:text-left">
                    <h3 class="text-2xl font-bold text-gray-900">Connexion</h3>
                    <p class="text-gray-500 text-sm mt-1">Connectez-vous à votre espace administrateur</p>
                </div>

                <!-- Message d'erreur -->
                @if($errors->any())
                <div class="mb-6 p-3 bg-red-50 border border-red-200 rounded-lg flex items-center gap-2 text-red-700 text-sm">
                    <iconify-icon icon="solar:danger-circle-bold" class="text-base"></iconify-icon>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email ou identifiant</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <iconify-icon icon="solar:user-circle-linear" class="text-gray-400 text-lg"></iconify-icon>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="contact@afroplume.com"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('email') border-red-500 @enderror"
                                autofocus>
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <iconify-icon icon="solar:lock-password-linear" class="text-gray-400 text-lg"></iconify-icon>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all @error('password') border-red-500 @enderror"
                                >
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <iconify-icon icon="solar:eye-linear" class="text-gray-400 text-lg hover:text-gray-600 transition"></iconify-icon>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-600">Se souvenir de moi</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <button type="submit" id="loginBtn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-600/25">
                        <iconify-icon icon="solar:login-3-linear" class="text-lg"></iconify-icon>
                        Se connecter
                    </button>
                </form>

                <!-- Demo credentials hint (pour test) -->
                <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-xs text-gray-500 text-center">
                        🔐 <span class="font-medium">Compte de démonstration</span><br>
                        <span class="text-gray-400">admin@afroplume.com / admin123</span>
                    </p>
                </div>

                <!-- Security notice -->
                <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <iconify-icon icon="solar:shield-check-linear" class="text-sm"></iconify-icon>
                    <span>Connexion sécurisée</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        /*document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('iconify-icon');
            if (type === 'text') {
                icon.setAttribute('icon', 'solar:eye-closed-linear');
            } else {
                icon.setAttribute('icon', 'solar:eye-linear');
            }
        });

        // Animation de chargement sur soumission du formulaire
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<iconify-icon icon="svg-spinners:3-dots-fade" class="text-xl"></iconify-icon> Connexion en cours...';
            });
        }

        // Nettoyer l'erreur quand l'utilisateur tape
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        if (emailInput) {
            emailInput.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                const errorDiv = document.querySelector('.bg-red-50');
                if (errorDiv) errorDiv.style.display = 'none';
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        }*/
    </script>
</body>
</html>
