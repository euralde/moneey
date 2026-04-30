
{{-- resources/views/messagerie/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="flex-1 flex max-w-7xl mx-auto w-full p-4 gap-5 overflow-hidden">

        <!-- Liste des contacts (gauche) -->
        <div class="w-80 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col overflow-hidden flex-shrink-0">
            <div class="p-4 border-b border-gray-100">
                <div class="relative">
                    <iconify-icon icon="solar:magnifer-linear"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base"></iconify-icon>
                    <input type="text" id="searchContact" placeholder="Rechercher un profil..."
                        class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div class="flex-1 overflow-y-auto" id="contactsList">
                <!-- Contacts chargés dynamiquement -->
            </div>
        </div>

        <!-- Zone de chat (droite) -->
        <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col overflow-hidden">
            <!-- Header du chat -->
            <div id="chatHeader" class="px-6 py-4 border-b bg-gray-50/50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <iconify-icon icon="solar:user-circle-linear" class="text-gray-500 text-2xl"></iconify-icon>
                </div>
                <div>
                    <h3 id="selectedContactName" class="font-semibold text-gray-900">Sélectionnez un contact</h3>
                    <p id="selectedContactStatus" class="text-xs text-gray-400">...</p>
                </div>
            </div>

            <!-- Messages area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/30"></div>

            <!-- Input area -->
            <div id="messageInputContainer" class="p-4 border-t bg-white hidden">
                <div class="flex gap-3">
                    <textarea id="messageInput" rows="2"
                        class="flex-1 px-4 py-2 border border-gray-200 rounded-xl resize-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm"
                        placeholder="Écrivez votre message..."></textarea>
                    <button id="sendMessageBtn"
                        class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition flex items-center justify-center">
                        <iconify-icon icon="solar:paper-plane-linear" class="text-xl"></iconify-icon>
                    </button>
                </div>
            </div>
            <div id="noContactSelected" class="flex-1 flex flex-col items-center justify-center text-gray-400">
                <iconify-icon icon="solar:chat-dots-linear" class="text-5xl mb-3 opacity-50"></iconify-icon>
                <p class="text-sm">Sélectionnez un contact pour commencer à discuter</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ==================== DONNÉES ====================
            const currentUser = { id: 1, name: "Junior SANNI", avatar: "JS", role: "admin" };

            // Liste des contacts disponibles
            let contacts = [
                { id: 2, name: "Marc Dupont", role: "Développeur Front-end", status: "online", avatar: "MD", email: "marc@afroplume.com" },
                { id: 3, name: "Koffi Jean", role: "Développeur Backend", status: "online", avatar: "KJ", email: "koffi@afroplume.com" },
                { id: 4, name: "Aïssata Diallo", role: "Chef de projet", status: "offline", avatar: "AD", email: "aissata@afroplume.com" },
                { id: 5, name: "Pauline Yao", role: "Marketing", status: "online", avatar: "PY", email: "pauline@afroplume.com" },
                { id: 6, name: "Amadou Koné", role: "Commercial", status: "offline", avatar: "AK", email: "amadou@afroplume.com" }
            ];

            // Stockage des messages par conversation
            let conversations = JSON.parse(localStorage.getItem('afro_chat_conversations')) || {};

            function getConversationKey(userId1, userId2) {
                return userId1 < userId2 ? `${userId1}_${userId2}` : `${userId2}_${userId1}`;
            }

            function getMessagesWith(contactId) {
                const key = getConversationKey(currentUser.id, contactId);
                if (!conversations[key]) {
                    if (contactId === 2) {
                        conversations[key] = [
                            { id: Date.now(), senderId: 2, text: "Bonjour Junior ! Le nouveau dashboard est prêt ?", timestamp: new Date(Date.now() - 3600000).toISOString() },
                            { id: Date.now() + 1, senderId: currentUser.id, text: "Oui Marc, je viens de le finaliser. Tu peux le tester.", timestamp: new Date(Date.now() - 3000000).toISOString() },
                        ];
                    } else if (contactId === 3) {
                        conversations[key] = [
                            { id: Date.now(), senderId: 3, text: "Salut ! Besoin d'aide sur l'API ?", timestamp: new Date(Date.now() - 7200000).toISOString() },
                        ];
                    } else {
                        conversations[key] = [];
                    }
                    saveConversations();
                }
                return conversations[key];
            }

            function saveConversations() {
                localStorage.setItem('afro_chat_conversations', JSON.stringify(conversations));
            }

            function addMessage(contactId, text) {
                if (!text.trim()) return;
                const key = getConversationKey(currentUser.id, contactId);
                if (!conversations[key]) conversations[key] = [];
                conversations[key].push({
                    id: Date.now(),
                    senderId: currentUser.id,
                    text: text.trim(),
                    timestamp: new Date().toISOString()
                });
                saveConversations();
                renderChatMessages(contactId);

                // Simulation de réponse automatique
                setTimeout(() => {
                    const contact = contacts.find(c => c.id === contactId);
                    if (contact && Math.random() > 0.5) {
                        const autoReplies = ["👍 D'accord!", "Merci pour l'info", "Je regarde ça", "Ok parfait", "👌 Reçu"];
                        conversations[key].push({
                            id: Date.now() + 1,
                            senderId: contactId,
                            text: autoReplies[Math.floor(Math.random() * autoReplies.length)],
                            timestamp: new Date().toISOString()
                        });
                        saveConversations();
                        renderChatMessages(contactId);
                    }
                }, 2000);
            }

            // ==================== RENDU DES CONTACTS ====================
            let selectedContactId = null;

            function renderContacts(filter = "") {
                const container = document.getElementById('contactsList');
                const filtered = contacts.filter(c =>
                    c.name.toLowerCase().includes(filter.toLowerCase()) ||
                    c.role.toLowerCase().includes(filter.toLowerCase())
                );

                container.innerHTML = filtered.map(contact => `
                                    <div class="contact-item p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition-all ${selectedContactId === contact.id ? 'contact-active' : ''}" data-id="${contact.id}">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-medium text-white text-sm">${contact.avatar}</div>
                                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full ${contact.status === 'online' ? 'bg-emerald-500' : 'bg-gray-400'} border-2 border-white"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-medium text-gray-900 text-sm truncate">${escapeHtml(contact.name)}</h4>
                                                    <span class="text-[10px] text-gray-400">${contact.status === 'online' ? 'En ligne' : 'Hors ligne'}</span>
                                                </div>
                                                <p class="text-xs text-gray-500 truncate">${escapeHtml(contact.role)}</p>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');

                document.querySelectorAll('.contact-item').forEach(el => {
                    el.addEventListener('click', () => {
                        const id = parseInt(el.dataset.id);
                        selectContact(id);
                    });
                });
            }

            function selectContact(contactId) {
                selectedContactId = contactId;
                const contact = contacts.find(c => c.id === contactId);
                renderContacts(document.getElementById('searchContact').value);

                document.getElementById('selectedContactName').innerText = contact.name;
                document.getElementById('selectedContactStatus').innerHTML = contact.status === 'online' ? '<span class="text-emerald-500">●</span> En ligne' : '<span class="text-gray-400">●</span> Hors ligne';

                document.getElementById('messageInputContainer').classList.remove('hidden');
                document.getElementById('noContactSelected').classList.add('hidden');

                renderChatMessages(contactId);
            }

            function renderChatMessages(contactId) {
                const container = document.getElementById('chatMessages');
                const messages = getMessagesWith(contactId);
                const contact = contacts.find(c => c.id === contactId);

                if (messages.length === 0) {
                    container.innerHTML = `<div class="flex flex-col items-center justify-center h-full text-gray-400"><iconify-icon icon="solar:chat-round-dots-linear" class="text-4xl mb-2 opacity-50"></iconify-icon><p class="text-xs">Aucun message, envoyez le premier !</p></div>`;
                    return;
                }

                container.innerHTML = messages.map(msg => {
                    const isOwn = msg.senderId === currentUser.id;
                    const senderName = isOwn ? currentUser.name : (contact ? contact.name : "Inconnu");
                    return `
                                        <div class="chat-message flex ${isOwn ? 'justify-end' : 'justify-start'}">
                                            <div class="max-w-[70%] ${isOwn ? 'bg-blue-600 text-white rounded-l-xl rounded-br-xl' : 'bg-white border border-gray-200 rounded-r-xl rounded-bl-xl'} px-4 py-2 shadow-sm">
                                                <div class="flex items-center gap-2 mb-1 ${isOwn ? 'justify-end' : ''}">
                                                    <span class="text-xs font-medium ${isOwn ? 'text-blue-100' : 'text-gray-500'}">${escapeHtml(senderName)}</span>
                                                    <span class="text-[10px] ${isOwn ? 'text-blue-200' : 'text-gray-400'}">${new Date(msg.timestamp).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}</span>
                                                </div>
                                                <p class="text-sm ${isOwn ? 'text-white' : 'text-gray-700'}">${escapeHtml(msg.text)}</p>
                                            </div>
                                        </div>
                                    `;
                }).join('');
                container.scrollTop = container.scrollHeight;
            }

            function escapeHtml(str) {
                if (!str) return '';
                return str.replace(/[&<>]/g, function (m) {
                    if (m === '&') return '&amp;';
                    if (m === '<') return '&lt;';
                    if (m === '>') return '&gt;';
                    return m;
                });
            }

            function sendMessage() {
                if (!selectedContactId) {
                    alert("Veuillez sélectionner un contact");
                    return;
                }
                const input = document.getElementById('messageInput');
                const text = input.value;
                if (!text.trim()) return;
                addMessage(selectedContactId, text);
                input.value = '';
                input.focus();
            }

            // ==================== INITIALISATION ====================
            document.getElementById('searchContact').addEventListener('input', (e) => {
                renderContacts(e.target.value);
            });
            document.getElementById('sendMessageBtn').addEventListener('click', sendMessage);
            document.getElementById('messageInput').addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Styles additionnels
            const style = document.createElement('style');
            style.textContent = `
                                .chat-message { animation: fadeInUp 0.2s ease; }
                                @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                                .contact-active { background-color: #eff6ff; border-left: 3px solid #3b82f6; }
                                ::-webkit-scrollbar { width: 6px; }
                                ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
                                ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
                            `;
            document.head.appendChild(style);

            // Chargement initial
            renderContacts("");

            if (contacts.length > 0) {
                setTimeout(() => selectContact(contacts[0].id), 100);
            }
        </script>
    @endpush
@endsection




 

