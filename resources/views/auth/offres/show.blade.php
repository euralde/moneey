<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFRO'PLUME - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @stack('styles')
</head>


<body class="bg-gray-100">

<div class="max-w-6xl mx-auto py-8 px-4">
    <a href="{{ route('offres.index') }}" class="text-gray-400 hover:text-gray-600 transition"> 
        <iconify-icon icon="solar:arrow-left-linear" class="text-2xl"></iconify-icon> 
    </a>

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6 shadow-lg mb-6">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold">{{ $recrutement->title }}</h1>
                    <p class="text-blue-100 mt-1">Rejoignez notre équipe dès maintenant 🚀</p>
                </div>
            </div>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- CONTENU PRINCIPAL -->
            <div class="lg:col-span-2 space-y-6">

                <!-- DESCRIPTION -->
                <div class="bg-white rounded-xl p-6 shadow">
                    <h2 class="text-xl font-semibold mb-3">📄 Description</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $recrutement->description }}
                    </p>
                </div>

                <!-- COMPETENCES -->
                <div class="bg-white rounded-xl p-6 shadow">
                    <h2 class="text-xl font-semibold mb-3">✅ Compétences requises</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $recrutement->requirements }}
                    </p>
                </div>

            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">
                <!-- INFOS -->
                <div class="bg-white rounded-xl p-5 shadow">
                    <h3 class="font-semibold mb-3">📌 Informations</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>📍 {{ $recrutement->location }}</p>
                        <p>📅 Date limite : {{ $recrutement->deadline }}</p>
                        <p>🏢 Département : {{ $recrutement->departement->name }}</p>
                    </div>
                </div>
            </div>

        </div>
        </div>
        <div class="max-w-6xl mx-auto py-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl p-6 shadow space-y-4">
                        <div class="flex justify-between items-center p-5 border-b">
                            <h3 class="text-lg font-semibold text-gray-900">Ajouter une candidature</h3>
                        </div>
                            <form action="{{ route('offres.store', $recrutement) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="p-5 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span
                                                        class="text-red-500">*</span></label>
                                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}"
                                                    placeholder="Ex: Jean Koffi">
                                                    @error('name')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}"
                                                        placeholder="candidat@email.com">
                                                        @error('email')
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                                    <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('phone') border-red-500 @enderror" value="{{ old('phone') }}"
                                                        placeholder="+225 XX XX XX XX">
                                                        @error('phone')
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    CV (PDF ou Word) <span class="text-red-500">*</span>
                                                </label>
                                                <input type="file" 
                                                    name="cv_url" 
                                                    accept=".pdf,.doc,.docx"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('cv_url') border-red-500 @enderror"
                                                    placeholder="Lien Google Drive, Dropbox ou commentaire sur le CV...">{{ old('cv_url') }}</textarea>
                                                    @error('cv_url')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    Lettre de motivation (PDF ou Word)
                                                </label>

                                                <input type="file" 
                                                    name="lettre_motivation" 
                                                    accept=".pdf,.doc,.docx"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('lettre_motivation') border-red-500 @enderror">

                                                @error('lettre_motivation')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                                        <iconify-icon icon="solar:check-circle-linear" class="inline mr-2 text-base"></iconify-icon>Postuler</button>
                                        </div>
                            </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</body> 
</html>