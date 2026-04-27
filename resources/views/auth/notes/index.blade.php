{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <!-- En-tête avec bouton ajout -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-gray-900">Mes notes</h2>
                <p class="text-sm text-gray-500 mt-0.5">Organisez vos idées et suivis</p>
            </div>
            <button id="openNoteModalBtn"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-200 shadow-sm text-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Nouvelle note
            </button>
        </div>

        <!-- Grille des notes -->
        <div id="notesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <!-- Les notes seront injectées dynamiquement ici -->
        </div>

        <!-- Message si aucune note -->
        <div id="emptyState" class="text-center py-12 hidden">
            <iconify-icon icon="solar:document-text-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
            <p class="text-gray-400 text-sm">Aucune note pour le moment</p>
            <p class="text-gray-300 text-xs mt-1">Cliquez sur "Nouvelle note" pour commencer</p>
        </div>
    </div>

    <!-- MODAL Note (Ajouter/Modifier) -->
    <div id="noteModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouvelle note</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text" id="noteTitle"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm"
                        placeholder="Ex: Réunion stratégique">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="noteDesc" rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-sm resize-none"
                        placeholder="Détails de votre note..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">Annuler</button>
                <button id="saveNoteBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- MODAL Détails / Édition Note -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="detailModalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0"
            id="detailModalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="detailTitle">Détail de la note</h3>
                <button id="closeDetailModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4 max-h-[60vh] overflow-y-auto" id="detailContent"></div>
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
            // Clé pour le stockage local
            const STORAGE_KEY = 'afroplume_notes';

            // État global
            let notes = [];
            let currentEditId = null;
            let currentDetailNoteId = null;

            // Éléments DOM
            const notesGrid = document.getElementById('notesGrid');
            const emptyState = document.getElementById('emptyState');
            const modal = document.getElementById('noteModal');
            const modalContainer = document.getElementById('modalContainer');
            const modalTitle = document.getElementById('modalTitle');
            const noteTitleInput = document.getElementById('noteTitle');
            const noteDescInput = document.getElementById('noteDesc');
            const openModalBtn = document.getElementById('openNoteModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelModalBtn = document.getElementById('cancelModalBtn');
            const saveNoteBtn = document.getElementById('saveNoteBtn');
            const modalBackdrop = document.getElementById('modalBackdrop');

            // Éléments modal détails
            const detailModal = document.getElementById('detailModal');
            const detailModalContainer = document.getElementById('detailModalContainer');
            const detailTitle = document.getElementById('detailTitle');
            const detailContent = document.getElementById('detailContent');
            const closeDetailModalBtn = document.getElementById('closeDetailModalBtn');
            const closeDetailBtn = document.getElementById('closeDetailBtn');
            const editFromDetailBtn = document.getElementById('editFromDetailBtn');
            const deleteFromDetailBtn = document.getElementById('deleteFromDetailBtn');
            const detailModalBackdrop = document.getElementById('detailModalBackdrop');

            // ==================== Fonctions utilitaires ====================

            function loadNotes() {
                const stored = localStorage.getItem(STORAGE_KEY);
                if (stored) {
                    notes = JSON.parse(stored);
                } else {
                    notes = [
                        { id: Date.now() + 1, title: "Réunion Stratégique", description: "Points abordés : budget Q2, recrutement équipe technique, prestataires logistique.\n\nÀ faire :\n- Envoyer compte-rendu à Junior\n- Planifier point avec Koffi Jean", createdAt: "2026-04-20T10:00:00.000Z" },
                        { id: Date.now() + 2, title: "Idées UI/UX", description: "Inspirations pour la v2 du dashboard :\n- Graphiques plus intuitifs\n- Thème sombre\n- Animations fluides\n- Amélioration du responsive mobile", createdAt: "2026-04-21T14:30:00.000Z" },
                        { id: Date.now() + 3, title: "À faire - Marketing", description: "[ ] Préparer le briefing pour l'agence\n[ ] Valider les visuels pour la campagne\n[ ] Planifier les réseaux sociaux\n[ ] Analyser les résultats du mois dernier", createdAt: "2026-04-22T09:15:00.000Z" }
                    ];
                    saveNotesToLocal();
                }
                renderNotes();
            }

            function saveNotesToLocal() {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(notes));
            }

            function formatRelativeDate(dateISO) {
                const date = new Date(dateISO);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);

                if (diffMins < 1) return "À l'instant";
                if (diffMins < 60) return `Il y a ${diffMins} min`;
                if (diffHours < 24) return `Il y a ${diffHours} h`;
                if (diffDays === 1) return "Hier";
                if (diffDays < 7) return `Il y a ${diffDays} jours`;
                return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
            }

            function formatFullDate(dateISO) {
                const date = new Date(dateISO);
                return date.toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            }

            function truncateText(text, maxLength = 100) {
                if (!text) return "";
                if (text.length <= maxLength) return text;
                return text.substring(0, maxLength) + "...";
            }

            function escapeHtml(str) {
                if (!str) return '';
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }

            // ==================== Rendu de la grille ====================

            function renderNotes() {
                if (notes.length === 0) {
                    notesGrid.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    return;
                }

                notesGrid.classList.remove('hidden');
                emptyState.classList.add('hidden');

                const sortedNotes = [...notes].sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));

                notesGrid.innerHTML = sortedNotes.map(note => `
                                                                                                                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col h-full transition-all duration-200 hover:shadow-md hover:border-blue-200 cursor-pointer" onclick="openNoteDetail(${note.id})">
                                                                                                                        <div class="p-4 flex-1">
                                                                                                                            <div class="flex items-start justify-between gap-2">
                                                                                                                                <h3 class="font-semibold text-gray-900 text-base leading-tight line-clamp-2">${escapeHtml(note.title)}</h3>
                                                                                                                                <div class="relative group">
                                                                                                                                    <button class="note-options-btn text-gray-400 hover:text-gray-600 transition-colors p-1" data-id="${note.id}" onclick="event.stopPropagation()">
                                                                                                                                        <iconify-icon icon="solar:menu-dots-bold" class="text-lg"></iconify-icon>
                                                                                                                                    </button>
                                                                                                                                    <div class="note-options-menu hidden absolute right-0 mt-1 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10 overflow-hidden" data-menu-id="${note.id}">
                                                                                                                                        <button class="edit-note-btn w-full text-left px-3 py-2 text-xs text-gray-600 hover:bg-gray-50 flex items-center gap-2" data-id="${note.id}" onclick="event.stopPropagation(); editNoteFromMenu(${note.id})">
                                                                                                                                            <iconify-icon icon="solar:pen-2-linear" class="text-sm"></iconify-icon>
                                                                                                                                            Modifier
                                                                                                                                        </button>
                                                                                                                                        <button class="delete-note-btn w-full text-left px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 flex items-center gap-2" data-id="${note.id}" onclick="event.stopPropagation(); deleteNoteFromMenu(${note.id})">
                                                                                                                                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-sm"></iconify-icon>
                                                                                                                                            Supprimer
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <p class="text-gray-600 text-xs mt-2 leading-relaxed line-clamp-3 whitespace-pre-line">${escapeHtml(truncateText(note.description, 120))}</p>
                                                                                                                        </div>
                                                                                                                        <div class="px-4 py-3 border-t border-gray-50 bg-gray-50/30 flex justify-between items-center">
                                                                                                                            <span class="text-[10px] text-gray-400 font-medium">📅 ${formatRelativeDate(note.createdAt)}</span>
                                                                                                                            <span class="text-blue-500 text-xs font-medium hover:text-blue-700 transition-colors flex items-center gap-1">
                                                                                                                                Lire la suite
                                                                                                                                <iconify-icon icon="solar:arrow-right-linear" class="text-xs"></iconify-icon>
                                                                                                                            </span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                `).join('');

                attachNoteCardEvents();
            }

            function attachNoteCardEvents() {
                // Fermer tous les menus quand on clique ailleurs
                document.addEventListener('click', closeAllMenus);
            }

            function closeAllMenus() {
                document.querySelectorAll('.note-options-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }

            function editNoteFromMenu(id) {
                const note = notes.find(n => n.id === id);
                if (note) {
                    openModalForEdit(note);
                }
                closeAllMenus();
            }

            function deleteNoteFromMenu(id) {
                if (confirm('Supprimer cette note ?')) {
                    notes = notes.filter(n => n.id !== id);
                    saveNotesToLocal();
                    renderNotes();
                    if (currentDetailNoteId === id) closeDetailModal();
                }
                closeAllMenus();
            }

            // Gestion des options click
            document.querySelectorAll('.note-options-btn')?.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const noteId = this.getAttribute('data-id');
                    const menu = document.querySelector(`.note-options-menu[data-menu-id="${noteId}"]`);
                    document.querySelectorAll('.note-options-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    if (menu) menu.classList.toggle('hidden');
                });
            });

            // ==================== Détails note ====================

            function openNoteDetail(id) {
                const note = notes.find(n => n.id === id);
                if (note) {
                    currentDetailNoteId = id;
                    detailTitle.innerText = note.title;
                    detailContent.innerHTML = `
                                                                                                                        <div class="space-y-4">
                                                                                                                            <div class="flex items-center gap-2 text-sm text-gray-500 pb-2 border-b">
                                                                                                                                <iconify-icon icon="solar:calendar-linear" class="text-base"></iconify-icon>
                                                                                                                                <span>Créée le ${formatFullDate(note.createdAt)}</span>
                                                                                                                            </div>
                                                                                                                            <div class="prose prose-sm max-w-none">
                                                                                                                                <div class="whitespace-pre-wrap text-gray-700 text-sm leading-relaxed">${escapeHtml(note.description)}</div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    `;
                    openDetailModal();
                }
            }

            // ==================== Gestion du Modal ====================

            function openModalForCreate() {
                currentEditId = null;
                modalTitle.textContent = "Nouvelle note";
                noteTitleInput.value = "";
                noteDescInput.value = "";
                openModal();
            }

            function openModalForEdit(note) {
                currentEditId = note.id;
                modalTitle.textContent = "Modifier la note";
                noteTitleInput.value = note.title;
                noteDescInput.value = note.description;
                openModal();
            }

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContainer.classList.remove('scale-95', 'opacity-0');
                    modalContainer.classList.add('scale-100', 'opacity-100');
                }, 10);
                noteTitleInput.focus();
            }

            function closeModal() {
                modalContainer.classList.remove('scale-100', 'opacity-100');
                modalContainer.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    currentEditId = null;
                    noteTitleInput.value = "";
                    noteDescInput.value = "";
                }, 200);
            }

            function saveNote() {
                const title = noteTitleInput.value.trim();
                const description = noteDescInput.value.trim();

                if (!title) {
                    alert("Veuillez saisir un titre");
                    noteTitleInput.focus();
                    return;
                }

                if (!description) {
                    alert("Veuillez saisir une description");
                    noteDescInput.focus();
                    return;
                }

                if (currentEditId !== null) {
                    const index = notes.findIndex(n => n.id === currentEditId);
                    if (index !== -1) {
                        notes[index] = {
                            ...notes[index],
                            title: title,
                            description: description,
                            updatedAt: new Date().toISOString()
                        };
                    }
                } else {
                    notes.unshift({
                        id: Date.now(),
                        title: title,
                        description: description,
                        createdAt: new Date().toISOString()
                    });
                }

                saveNotesToLocal();
                renderNotes();
                closeModal();
            }

            // ==================== Modal Détails ====================

            function openDetailModal() {
                detailModal.classList.remove('hidden');
                detailModal.classList.add('flex');
                setTimeout(() => {
                    detailModalContainer.classList.remove('scale-95', 'opacity-0');
                    detailModalContainer.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeDetailModal() {
                detailModalContainer.classList.remove('scale-100', 'opacity-100');
                detailModalContainer.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    detailModal.classList.add('hidden');
                    detailModal.classList.remove('flex');
                    currentDetailNoteId = null;
                }, 200);
            }

            function editFromDetail() {
                if (currentDetailNoteId) {
                    const note = notes.find(n => n.id === currentDetailNoteId);
                    if (note) {
                        closeDetailModal();
                        openModalForEdit(note);
                    }
                }
            }

            function deleteFromDetail() {
                if (currentDetailNoteId && confirm('⚠️ Supprimer cette note ? Cette action est irréversible.')) {
                    notes = notes.filter(n => n.id !== currentDetailNoteId);
                    saveNotesToLocal();
                    renderNotes();
                    closeDetailModal();
                }
            }

            // ==================== Événements ====================

            openModalBtn.addEventListener('click', openModalForCreate);
            closeModalBtn.addEventListener('click', closeModal);
            cancelModalBtn.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);
            saveNoteBtn.addEventListener('click', saveNote);

            closeDetailModalBtn.addEventListener('click', closeDetailModal);
            closeDetailBtn.addEventListener('click', closeDetailModal);
            detailModalBackdrop.addEventListener('click', closeDetailModal);
            editFromDetailBtn.addEventListener('click', editFromDetail);
            deleteFromDetailBtn.addEventListener('click', deleteFromDetail);

            modalContainer.addEventListener('click', (e) => e.stopPropagation());
            detailModalContainer.addEventListener('click', (e) => e.stopPropagation());

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (!modal.classList.contains('hidden')) closeModal();
                    if (!detailModal.classList.contains('hidden')) closeDetailModal();
                }
            });

            // Mobile menu
            document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('-translate-x-full');
                document.getElementById('mobile-overlay').classList.toggle('hidden');
            });
            document.getElementById('mobile-overlay')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.add('-translate-x-full');
                document.getElementById('mobile-overlay').classList.add('hidden');
            });

            // Styles supplémentaires
            const style = document.createElement('style');
            style.textContent = `
                                                                                                                .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
                                                                                                                .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
                                                                                                                .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }
                                                                                                                .note-options-menu { z-index: 50; }
                                                                                                            `;
            document.head.appendChild(style);

            // Initialisation
            loadNotes();
        </script>
    @endpush
@endsection