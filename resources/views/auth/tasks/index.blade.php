@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Mes tâches</h2>
            <p class="text-sm text-gray-500">Gérez vos tâches</p>
=======
    <main class="flex-1 overflow-y-auto p-4 md:p-6">
        <div class="max-w-7xl mx-auto">

            <!-- En-tête -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Agenda</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Visualisez vos tâches par jour</p>
                </div>
                <button id="openTaskModalBtn"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
                    <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                    Nouvelle tâche
                </button>
            </div>

            <!-- Calendrier -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- En-tête mois + navigation -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <button id="prevMonth" class="p-2 hover:bg-gray-200 rounded-lg transition"><iconify-icon
                                icon="solar:alt-arrow-left-linear" class="text-gray-600 text-lg"></iconify-icon></button>
                        <h2 id="monthYear" class="text-xl font-semibold text-gray-800 min-w-[200px] text-center">Mars 2026
                        </h2>
                        <button id="nextMonth" class="p-2 hover:bg-gray-200 rounded-lg transition"><iconify-icon
                                icon="solar:alt-arrow-right-linear" class="text-gray-600 text-lg"></iconify-icon></button>
                        <button id="todayBtn"
                            class="px-3 py-1.5 text-xs bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">Aujourd'hui</button>
                    </div>
                </div>

                <!-- Jours de la semaine -->
                <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50">
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">LUNDI</div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">MARDI</div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">MERCREDI
                    </div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">JEUDI</div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">VENDREDI
                    </div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600 border-r border-gray-200">SAMEDI</div>
                    <div class="text-center py-3 text-sm font-semibold text-gray-600">DIMANCHE</div>
                </div>

                <!-- Grille des jours -->
                <div id="calendarGrid" class="grid grid-cols-7 auto-rows-fr">
                    <!-- Les jours sont générés dynamiquement -->
                </div>
            </div>

            <!-- Modal Détails Tâche -->
            <div id="taskDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="detailModalBackdrop"></div>
                <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
                    id="detailModalContainer">
                    <div class="flex justify-between items-center p-5 border-b">
                        <h3 class="text-lg font-semibold text-gray-900" id="detailTitle">Tâche</h3>
                        <button id="closeDetailModal" class="text-gray-400 hover:text-gray-600"><iconify-icon
                                icon="solar:close-circle-linear" class="text-2xl"></iconify-icon></button>
                    </div>
                    <div class="p-5 space-y-4" id="detailContent">
                        <!-- Contenu dynamique -->
                    </div>
                    <div class="flex justify-between gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')

                            <button type="submit" onclick="return confirm('Supprimer cette tâche ?')"
                                class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition flex items-center gap-2">
                                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                Supprimer
                            </button>
                        </form>
                        <div class="flex gap-3">
                            <button id="closeDetailBtn"
                                class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
>>>>>>> 47040dd5ca2c2dfbee19815dfa84fc013cd8a3d6
        </div>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Nouvelle tâche
        </a>
    </div>

<<<<<<< HEAD
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
=======
        <!-- MODAL Ajout Tâche -->
        <div id="taskModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="modalBackdrop"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
                id="modalContainer">
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Nouvelle tâche</h3>
                    <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600"><iconify-icon
                            icon="solar:close-circle-linear" class="text-2xl"></iconify-icon></button>
                </div>
                <form action="{{ route('tasks.store') }}" method="post">
                    @csrf
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                                placeholder="Ex: Finaliser le rapport">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                                placeholder="Détails de la tâche..."></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="start" id="taskDate" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                                <select name="priority" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                                    <option value="basse">🟢 Basse</option>
                                    <option value="moyenne" selected>🔵 Moyenne</option>
                                    <option value="haute">🟠 Haute</option>
                                    <option value="urgent">🔴 Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                            <button type="button" id="cancelModalBtn"
                            class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>    
            </div>
>>>>>>> 47040dd5ca2c2dfbee19815dfa84fc013cd8a3d6
        </div>
    @endif

<<<<<<< HEAD
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Titre</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Description</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Priorité</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Statut</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $task->title }}</td>
                    <td class="px-4 py-3">{{ $task->description ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($task->priority == 'urgent')
                            <span class="text-red-600 font-medium">Urgent</span>
                        @elseif($task->priority == 'haute')
                            <span class="text-orange-600 font-medium">Haute</span>
                        @elseif($task->priority == 'moyenne')
                            <span class="text-blue-600 font-medium">Moyenne</span>
                        @else
                            <span class="text-gray-500">Basse</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $task->due_date ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($task->is_completed)
                            <span class="text-green-600">✔ Terminée</span>
                        @else
                            <span class="text-yellow-600">⏳ En cours</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-yellow-600 hover:text-yellow-800 mr-3">Modifier</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette tâche ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">
                        Aucune tâche. Cliquez sur "+ Nouvelle tâche" pour en créer une.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
=======
        <script>
            let tasks = @json($tasks);
        </script>
        
        <script>
            // Données des tâches
            

            let currentDate = new Date();

            const priorityConfig = {
                urgent: { label: "Urgent", bg: "bg-rose-500", text: "text-rose-700", light: "bg-rose-50" },
                haute: { label: "Haute", bg: "bg-amber-500", text: "text-amber-700", light: "bg-amber-50" },
                moyenne: { label: "Moyenne", bg: "bg-blue-500", text: "text-blue-700", light: "bg-blue-50" },
                basse: { label: "Basse", bg: "bg-emerald-500", text: "text-emerald-700", light: "bg-emerald-50" }
            };

            

            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                // Mettre à jour le titre
                const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                document.getElementById('monthYear').innerText = `${monthNames[month]} ${year}`;

                // Premier jour du mois (lundi = 1, dimanche = 0)
                const firstDayOfMonth = new Date(year, month, 1);
                let startDay = firstDayOfMonth.getDay();
                startDay = startDay === 0 ? 6 : startDay - 1;

                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const daysInPrevMonth = new Date(year, month, 0).getDate();

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                let calendarDays = [];

                // Jours du mois précédent
                for (let i = startDay - 1; i >= 0; i--) {
                    const dayNumber = daysInPrevMonth - i;
                    calendarDays.push({ date: null, dayNumber, isCurrentMonth: false });
                }

                // Jours du mois actuel
                for (let i = 1; i <= daysInMonth; i++) {
                    const dateObj = new Date(year, month, i);
                    const dateStr = dateObj.toLocaleDateString('en-CA');
                    const dayTasks = tasks.filter(t => t.start === dateStr);
                    const isToday = dateObj.toDateString() === today.toDateString();

                    calendarDays.push({
                        date: dateStr,
                        dayNumber: i,
                        isCurrentMonth: true,
                        isToday,
                        tasks: dayTasks
                    });
                }

                // Compléter avec jours du mois suivant
                const remaining = 42 - calendarDays.length;
                for (let i = 1; i <= remaining; i++) {
                    calendarDays.push({ date: null, dayNumber: i, isCurrentMonth: false });
                }

                // Rendu de la grille
                const grid = document.getElementById('calendarGrid');
                grid.innerHTML = calendarDays.map(day => {
                    if (!day.isCurrentMonth) {
                        return `
                        <div class="min-h-[120px] bg-gray-50/50 border-b border-r border-gray-100 p-2">
                            <div class="text-right">
                                <span class="text-xs text-gray-400">${day.dayNumber}</span>
                            </div>
                        </div>
                        `;
                    }

                    const tasksHtml = day.tasks.map(task => {
                        const priority = priorityConfig[task.priority] || priorityConfig.moyenne;
                        return `
                            <div onclick="openTaskDetail(${task.id})" class="cursor-pointer mb-1.5 p-1.5 rounded-lg ${priority.light} hover:shadow-sm transition-all">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full ${priority.bg}"></div>
                                    <span class="text-xs font-medium ${priority.text} truncate flex-1">${escapeHtml(task.title)}</span>
                                </div>
                            </div>
                            `;
                    }).join('');

                    const isTodayClass = day.isToday ? 'bg-blue-50' : '';
                    return `
                        <div class="min-h-[120px] border-b border-r border-gray-100 p-2 ${isTodayClass} hover:bg-gray-50/30 transition">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-sm font-medium ${day.isToday ? 'bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs' : 'text-gray-700'}">${day.dayNumber}</span>
                                    <button onclick="openTaskModalWithDate('${day.date}')" class="text-gray-300 hover:text-blue-500 transition">
                                        <iconify-icon icon="solar:add-circle-linear" class="text-sm"></iconify-icon>
                                    </button>
                            </div>
                            <div class="space-y-1 max-h-[90px] overflow-y-auto">
                                ${tasksHtml}
                            </div>
                        </div>
                        `;
                }).join('');
            }

            function openTaskDetail(taskId) {
                const task = tasks.find(t => t.id === taskId);
                if (!task) return;

                // 🔥 IMPORTANT : définir l'URL du delete
                document.getElementById('deleteForm').action = `/tasks/${task.id}`;

                const priority = priorityConfig[task.priority] || priorityConfig.moyenne;
                const dateObj = new Date(task.date);
                const formattedDate = dateObj.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

                document.getElementById('detailTitle').innerHTML = `
                                                                                        <div class="flex items-center gap-2">
                                                                                            <span class="w-3 h-3 rounded-full ${priority.bg}"></span>
                                                                                            ${escapeHtml(task.title)}
                                                                                        </div>
                                                                                    `;

                document.getElementById('detailContent').innerHTML = `
                                                                                        <div class="space-y-3">
                                                                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                                                                <iconify-icon icon="solar:calendar-linear" class="text-base"></iconify-icon>
                                                                                                <span>${formattedDate}</span>
                                                                                            </div>
                                                                                            <div class="flex items-center gap-2">
                                                                                                <span class="text-xs px-2 py-1 rounded-full ${priority.light} ${priority.text} font-medium">Priorité ${priority.label}</span>
                                                                                            </div>
                                                                                            <div class="pt-2 border-t border-gray-100">
                                                                                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Description</label>
                                                                                                <p class="text-sm text-gray-700 mt-1 leading-relaxed">${escapeHtml(task.description) || 'Aucune description'}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    `;

                openDetailModal();
            }

            function openTaskModalWithDate(date) {
                document.getElementById('taskDate').value = date;
                openModal();
            }

            function changeMonth(delta) {
                currentDate.setMonth(currentDate.getMonth() + delta);
                renderCalendar();
            }

            function goToToday() {
                currentDate = new Date();
                renderCalendar();
            }

            // Modals
            function openModal() {
                const modal = document.getElementById('taskModal');
                const container = document.getElementById('modalContainer');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                const container = document.getElementById('modalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('taskModal').classList.add('hidden');
                    document.getElementById('taskModal').classList.remove('flex');
                }, 200);
            }

            function openDetailModal() {
                const modal = document.getElementById('taskDetailModal');
                const container = document.getElementById('detailModalContainer');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeDetailModal() {
                const container = document.getElementById('detailModalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('taskDetailModal').classList.add('hidden');
                    document.getElementById('taskDetailModal').classList.remove('flex');
                }, 200);
            }

            function escapeHtml(str) {
                if (!str) return '';
                return str.replace(/[&<>]/g, m => m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;');
            }

            // Événements
            document.getElementById('openTaskModalBtn').addEventListener('click', () => openTaskModalWithDate(new Date().toISOString().split('T')[0]));
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);

            document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);
            document.getElementById('closeDetailBtn').addEventListener('click', closeDetailModal);
            document.getElementById('detailModalBackdrop').addEventListener('click', closeDetailModal);

            document.getElementById('prevMonth').addEventListener('click', () => changeMonth(-1));
            document.getElementById('nextMonth').addEventListener('click', () => changeMonth(1));
            document.getElementById('todayBtn').addEventListener('click', goToToday);

            // Initialisation
            renderCalendar();
        </script>
    </main>
>>>>>>> 47040dd5ca2c2dfbee19815dfa84fc013cd8a3d6
@endsection