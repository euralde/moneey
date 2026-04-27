{{-- resources/views/reunions/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Réunions</h1>
                <p class="text-sm text-gray-500 mt-0.5">Gérez vos rendez-vous et réunions</p>
            </div>
            <button id="openMeetingModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
                <iconify-icon icon="solar:calendar-add-linear" class="text-lg"></iconify-icon>
                Nouvelle réunion
            </button>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Total réunions</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalReunions">0</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:calendar-linear" class="text-blue-600 text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">À venir</p>
                        <p class="text-2xl font-bold text-emerald-600" id="upcomingReunions">0</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:calendar-mark-linear" class="text-emerald-600 text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Aujourd'hui</p>
                        <p class="text-2xl font-bold text-blue-600" id="todayReunions">0</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:clock-circle-linear" class="text-blue-600 text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Participants</p>
                        <p class="text-2xl font-bold text-purple-600" id="totalParticipants">0</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:users-group-rounded-linear"
                            class="text-purple-600 text-xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex gap-3">
                <select id="filterType" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Toutes les réunions</option>
                    <option value="upcoming">À venir</option>
                    <option value="past">Passées</option>
                    <option value="today">Aujourd'hui</option>
                </select>
                <input type="text" id="searchReunion" placeholder="Rechercher..."
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm w-48">
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
        </div>

        <!-- Liste des réunions -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Date & Heure</th>
                            <th class="px-6 py-4">Lien</th>
                            <th class="px-6 py-4">Participants</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reunionsTableBody" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
            <div id="emptyReunions" class="text-center py-12 hidden">
                <iconify-icon icon="solar:calendar-mark-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucune réunion programmée</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Nouvelle réunion" pour commencer</p>
            </div>
        </div>
    </div>

    <!-- MODAL Ajouter/Modifier Réunion -->
    <div id="meetingModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouvelle réunion</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="meetingTitle"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Ex: Réunion stratégique Q2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="meetingDescription" rows="2"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="Ordre du jour, points à aborder..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="meetingDate" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure <span
                                class="text-red-500">*</span></label>
                        <input type="time" id="meetingTime" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lien Google Meet / Zoom</label>
                    <input type="url" id="meetingLink" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                        placeholder="https://meet.google.com/xxx-xxxx-xxx">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Participants</label>
                    <select id="meetingParticipants" multiple class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                        <option value="Marc Dupont">Marc Dupont</option>
                        <option value="Koffi Jean">Koffi Jean</option>
                        <option value="Aïssata Diallo">Aïssata Diallo</option>
                        <option value="Pauline Yao">Pauline Yao</option>
                        <option value="Amadou Koné">Amadou Koné</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Maintenez Ctrl (Cmd) pour sélectionner plusieurs participants</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="meetingStatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                        <option value="planifiee">📅 Planifiée</option>
                        <option value="en_cours">🔄 En cours</option>
                        <option value="terminee">✅ Terminée</option>
                        <option value="annulee">❌ Annulée</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="saveMeetingBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- MODAL Détails Réunion -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="detailModalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
            id="detailModalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Détails de la réunion</h3>
                <button id="closeDetailModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4" id="detailContent"></div>
            <div class="flex justify-between gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <button id="deleteFromDetailBtn"
                    class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition flex items-center gap-2">
                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                    Supprimer
                </button>
                <div class="flex gap-3">
                    <button id="closeDetailBtn"
                        class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Fermer</button>
                    <button id="editFromDetailBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Modifier</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Données initiales
            let reunions = JSON.parse(localStorage.getItem('afro_reunions') || JSON.stringify([
                {
                    id: 1,
                    title: "Réunion stratégique Q2",
                    description: "Validation du budget et planning des projets",
                    date: "2026-04-28",
                    time: "10:00",
                    link: "https://meet.google.com/abc-defg-hij",
                    participants: ["Marc Dupont", "Koffi Jean"],
                    status: "planifiee",
                    createdAt: "2026-04-20"
                },
                {
                    id: 2,
                    title: "Point technique équipe IT",
                    description: "Revue des sprints et déploiement",
                    date: "2026-04-29",
                    time: "14:30",
                    link: "https://meet.google.com/xyz-uvwx-yz",
                    participants: ["Koffi Jean", "Aïssata Diallo"],
                    status: "planifiee",
                    createdAt: "2026-04-21"
                },
                {
                    id: 3,
                    title: "Présentation client",
                    description: "Démo de la nouvelle plateforme",
                    date: "2026-04-25",
                    time: "11:00",
                    link: "https://meet.google.com/123-456-789",
                    participants: ["Pauline Yao", "Marc Dupont"],
                    status: "terminee",
                    createdAt: "2026-04-19"
                }
            ]));

            let currentEditId = null;
            let currentDetailId = null;

            const statusLabels = {
                planifiee: { label: "📅 Planifiée", color: "bg-blue-100 text-blue-700" },
                en_cours: { label: "🔄 En cours", color: "bg-amber-100 text-amber-700" },
                terminee: { label: "✅ Terminée", color: "bg-emerald-100 text-emerald-700" },
                annulee: { label: "❌ Annulée", color: "bg-gray-100 text-gray-600" }
            };

            function saveReunions() {
                localStorage.setItem('afro_reunions', JSON.stringify(reunions));
            }

            function updateStats() {
                const total = reunions.length;
                const today = new Date().toISOString().split('T')[0];
                const upcoming = reunions.filter(r => r.date >= today && r.status !== 'terminee' && r.status !== 'annulee').length;
                const todayCount = reunions.filter(r => r.date === today && r.status !== 'annulee').length;
                let totalParticipants = 0;
                reunions.forEach(r => { totalParticipants += (r.participants?.length || 0); });

                document.getElementById('totalReunions').innerText = total;
                document.getElementById('upcomingReunions').innerText = upcoming;
                document.getElementById('todayReunions').innerText = todayCount;
                document.getElementById('totalParticipants').innerText = totalParticipants;
            }

            function renderReunions() {
                let filtered = [...reunions];
                const filterType = document.getElementById('filterType').value;
                const searchVal = document.getElementById('searchReunion').value.toLowerCase();
                const today = new Date().toISOString().split('T')[0];

                if (filterType === 'upcoming') {
                    filtered = filtered.filter(r => r.date >= today && r.status !== 'terminee' && r.status !== 'annulee');
                } else if (filterType === 'past') {
                    filtered = filtered.filter(r => r.date < today || r.status === 'terminee');
                } else if (filterType === 'today') {
                    filtered = filtered.filter(r => r.date === today);
                }

                if (searchVal) {
                    filtered = filtered.filter(r =>
                        r.title.toLowerCase().includes(searchVal) ||
                        r.description.toLowerCase().includes(searchVal)
                    );
                }

                filtered.sort((a, b) => new Date(`${a.date} ${a.time}`) - new Date(`${b.date} ${b.time}`));

                const tbody = document.getElementById('reunionsTableBody');
                const empty = document.getElementById('emptyReunions');

                if (filtered.length === 0) {
                    tbody.innerHTML = '';
                    empty.classList.remove('hidden');
                    updateStats();
                    return;
                }
                empty.classList.add('hidden');

                tbody.innerHTML = filtered.map(r => {
                    const participantsList = (r.participants || []).slice(0, 3).join(', ');
                    const moreParticipants = (r.participants?.length || 0) > 3 ? ` +${r.participants.length - 3}` : '';

                    return `
                                                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="openDetailModal(${r.id})">
                                                            <td class="px-6 py-4">
                                                                <div class="font-medium text-gray-900">${escapeHtml(r.title)}</div>
                                                                <div class="text-xs text-gray-400 mt-0.5">${escapeHtml(r.description?.substring(0, 50) || '')}</div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="text-gray-700">${new Date(r.date).toLocaleDateString('fr-FR')}</div>
                                                                <div class="text-xs text-gray-400">${r.time}</div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                ${r.link ? `<a href="${r.link}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1" onclick="event.stopPropagation()">
                                                                    <iconify-icon icon="solar:video-recording-linear" class="text-sm"></iconify-icon>
                                                                    Rejoindre
                                                                </a>` : '<span class="text-gray-400 text-xs">Non défini</span>'}
                                                             </td>
                                                            <td class="px-6 py-4 text-gray-500 text-sm">${participantsList}${moreParticipants}</td>
                                                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusLabels[r.status]?.color || 'bg-gray-100'}">${statusLabels[r.status]?.label || r.status}</span></td>
                                                            <td class="px-6 py-4 text-center">
                                                                <div class="flex items-center justify-center gap-2" onclick="event.stopPropagation()">
                                                                    <button onclick="editReunion(${r.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded" title="Modifier">
                                                                        <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                                                    </button>
                                                                    <button onclick="deleteReunion(${r.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded" title="Supprimer">
                                                                        <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                                                    </button>
                                                                </div>
                                                             </td>
                                                         </tr>
                                                    `;
                }).join('');
                updateStats();
            }

            function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, m => m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;'); }

            function openDetailModal(id) {
                const reunion = reunions.find(r => r.id === id);
                if (reunion) {
                    currentDetailId = id;
                    const status = statusLabels[reunion.status] || statusLabels.planifiee;
                    const participantsList = (reunion.participants || []).map(p => `<li class="text-sm text-gray-600">${escapeHtml(p)}</li>`).join('');

                    document.getElementById('detailContent').innerHTML = `
                                                        <div class="space-y-3">
                                                            <div><label class="text-xs font-medium text-gray-500">Titre</label><p class="text-base font-semibold text-gray-900">${escapeHtml(reunion.title)}</p></div>
                                                            <div><label class="text-xs font-medium text-gray-500">Description</label><p class="text-sm text-gray-700">${escapeHtml(reunion.description || 'Aucune description')}</p></div>
                                                            <div class="grid grid-cols-2 gap-3">
                                                                <div><label class="text-xs font-medium text-gray-500">Date</label><p class="text-sm text-gray-900">${new Date(reunion.date).toLocaleDateString('fr-FR')}</p></div>
                                                                <div><label class="text-xs font-medium text-gray-500">Heure</label><p class="text-sm text-gray-900">${reunion.time}</p></div>
                                                            </div>
                                                            <div><label class="text-xs font-medium text-gray-500">Lien</label>${reunion.link ? `<a href="${reunion.link}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">${escapeHtml(reunion.link)}</a>` : '<p class="text-sm text-gray-400">Non défini</p>'}</div>
                                                            <div><label class="text-xs font-medium text-gray-500">Participants</label><ul class="list-disc list-inside mt-1 space-y-0.5">${participantsList || '<li class="text-sm text-gray-400">Aucun participant</li>'}</ul></div>
                                                            <div><label class="text-xs font-medium text-gray-500">Statut</label><p><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${status.color}">${status.label}</span></p></div>
                                                        </div>
                                                    `;
                    openDetailModalWindow();
                }
            }

            function editReunion(id) {
                const reunion = reunions.find(r => r.id === id);
                if (reunion) {
                    currentEditId = id;
                    document.getElementById('modalTitle').innerText = 'Modifier la réunion';
                    document.getElementById('meetingTitle').value = reunion.title;
                    document.getElementById('meetingDescription').value = reunion.description || '';
                    document.getElementById('meetingDate').value = reunion.date;
                    document.getElementById('meetingTime').value = reunion.time;
                    document.getElementById('meetingLink').value = reunion.link || '';
                    document.getElementById('meetingStatus').value = reunion.status;

                    // Sélectionner les participants
                    const participantSelect = document.getElementById('meetingParticipants');
                    Array.from(participantSelect.options).forEach(opt => {
                        opt.selected = reunion.participants?.includes(opt.value) || false;
                    });

                    openModal();
                }
            }

            function deleteReunion(id) {
                if (confirm('Supprimer cette réunion ?')) {
                    reunions = reunions.filter(r => r.id !== id);
                    saveReunions();
                    renderReunions();
                }
            }

            // Modal principal
            function openModal() {
                const modal = document.getElementById('meetingModal');
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
                    document.getElementById('meetingModal').classList.add('hidden');
                    document.getElementById('meetingModal').classList.remove('flex');
                    resetForm();
                }, 200);
            }

            function resetForm() {
                currentEditId = null;
                document.getElementById('modalTitle').innerText = 'Nouvelle réunion';
                document.getElementById('meetingTitle').value = '';
                document.getElementById('meetingDescription').value = '';
                document.getElementById('meetingDate').value = '';
                document.getElementById('meetingTime').value = '';
                document.getElementById('meetingLink').value = '';
                document.getElementById('meetingStatus').value = 'planifiee';
                const select = document.getElementById('meetingParticipants');
                Array.from(select.options).forEach(opt => opt.selected = false);
            }

            function saveMeeting() {
                const title = document.getElementById('meetingTitle').value.trim();
                const description = document.getElementById('meetingDescription').value.trim();
                const date = document.getElementById('meetingDate').value;
                const time = document.getElementById('meetingTime').value;
                const link = document.getElementById('meetingLink').value.trim();
                const status = document.getElementById('meetingStatus').value;
                const participants = Array.from(document.getElementById('meetingParticipants').selectedOptions).map(opt => opt.value);

                if (!title) { alert('Veuillez saisir un titre'); return; }
                if (!date) { alert('Veuillez sélectionner une date'); return; }
                if (!time) { alert('Veuillez sélectionner une heure'); return; }

                if (currentEditId !== null) {
                    const index = reunions.findIndex(r => r.id === currentEditId);
                    if (index !== -1) {
                        reunions[index] = { ...reunions[index], title, description, date, time, link, status, participants };
                    }
                } else {
                    reunions.push({
                        id: Date.now(),
                        title, description, date, time, link, status, participants,
                        createdAt: new Date().toISOString().split('T')[0]
                    });
                }
                saveReunions();
                renderReunions();
                closeModal();
            }

            // Modal Détails
            function openDetailModalWindow() {
                const modal = document.getElementById('detailModal');
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
                    document.getElementById('detailModal').classList.add('hidden');
                    document.getElementById('detailModal').classList.remove('flex');
                    currentDetailId = null;
                }, 200);
            }

            function editFromDetail() {
                if (currentDetailId) {
                    closeDetailModal();
                    editReunion(currentDetailId);
                }
            }

            function deleteFromDetail() {
                if (currentDetailId && confirm('Supprimer cette réunion ?')) {
                    reunions = reunions.filter(r => r.id !== currentDetailId);
                    saveReunions();
                    renderReunions();
                    closeDetailModal();
                }
            }

            // Event listeners
            document.getElementById('openMeetingModal').addEventListener('click', () => { resetForm(); openModal(); });
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            document.getElementById('saveMeetingBtn').addEventListener('click', saveMeeting);

            document.getElementById('closeDetailModalBtn').addEventListener('click', closeDetailModal);
            document.getElementById('closeDetailBtn').addEventListener('click', closeDetailModal);
            document.getElementById('detailModalBackdrop').addEventListener('click', closeDetailModal);
            document.getElementById('editFromDetailBtn').addEventListener('click', editFromDetail);
            document.getElementById('deleteFromDetailBtn').addEventListener('click', deleteFromDetail);

            document.getElementById('filterType').addEventListener('change', renderReunions);
            document.getElementById('searchReunion').addEventListener('input', renderReunions);
            document.getElementById('resetFilters').addEventListener('click', () => {
                document.getElementById('filterType').value = 'all';
                document.getElementById('searchReunion').value = '';
                renderReunions();
            });

            // Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (!document.getElementById('meetingModal').classList.contains('hidden')) closeModal();
                    if (!document.getElementById('detailModal').classList.contains('hidden')) closeDetailModal();
                }
            });

            // Styles
            const style = document.createElement('style');
            style.textContent = `.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }`;
            document.head.appendChild(style);

            // Initial render
            renderReunions();
        </script>
    @endpush
@endsection