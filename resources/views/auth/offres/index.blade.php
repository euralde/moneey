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
</html>

<body>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Offres de recrutement
        </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    
    @foreach ($recrutements as $recrutement)
        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300">

            <!-- Titre -->
            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                {{ $recrutement->title }}
            </h2>

            <!-- Département -->
            <p class="text-sm text-gray-600 mb-1">
                <span class="font-medium">Département :</span>
                {{ $recrutement->departement->name }}
            </p>

            <!-- Localisation -->
            <p class="text-sm text-gray-600 mb-1">
                <span class="font-medium">Lieu :</span>
                {{ $recrutement->location }}
            </p>

            <!-- Statut -->
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-2
                {{ $recrutement->status == 'actif' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }}">
                {{ $recrutement->status }}
            </span>

            <!-- Date limite -->
            <p class="text-sm text-gray-500 mb-4">
                📅 Date limite : {{ $recrutement->deadline }}
            </p>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-4">

                <!-- Details -->
                <a href="{{ route('offres.show', $recrutement->id) }}"
                class="block w-full text-center bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition mt-4">
                    Voir détails
                </a>
            </div>

        </div>
    @endforeach

</div>
</body>
</html>