@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden" style="height: 80vh;">
        <div class="flex h-full">
            <!-- Sidebar des conversations -->
            <div class="w-1/3 border-r bg-gray-50">
                <div class="p-4 border-b bg-white">
                    <h2 class="text-lg font-semibold">Discussions</h2>
                </div>
                <div class="overflow-y-auto" style="height: calc(80vh - 70px);" id="usersList">
                    <!-- Les utilisateurs seront chargés ici -->
                </div>
            </div>
            
            <!-- Zone de chat -->
            <div class="w-2/3 flex flex-col">
                <div class="p-4 border-b bg-white">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold" id="avatarChat">
                            ?
                        </div>
                        <div class="ml-3">
                            <div class="font-semibold" id="chatUser">Sélectionnez une conversation</div>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 bg-gray-100" id="messagesContainer">
                    <div class="text-center text-gray-500 mt-20">
                        Sélectionnez une conversation pour commencer
                    </div>
                </div>
                
                <div class="p-4 border-t bg-white">
                    <div class="flex gap-2">
                        <input type="text" id="messageInput" placeholder="Tapez votre message..." class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <button onclick="sendMessage()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            ➤ Envoyer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentUser = null;
    
    // Charger la liste des utilisateurs
    function loadUsers() {
        fetch('/messages/users')
            .then(response => response.json())
            .then(users => {
                const container = document.getElementById('usersList');
                container.innerHTML = '';
                
                users.forEach(user => {
                    const div = document.createElement('div');
                    div.className = 'p-3 border-b hover:bg-gray-100 cursor-pointer';
                    div.onclick = () => loadConversation(user);
                    div.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                ${user.charAt(0).toUpperCase()}
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold">${user}</div>
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });
            });
    }
    
    // Charger une conversation
    function loadConversation(user) {
        currentUser = user;
        document.getElementById('chatUser').innerText = user;
        document.getElementById('avatarChat').innerText = user.charAt(0).toUpperCase();
        
        fetch(`/messages/conversation/${user}`)
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('messagesContainer');
                container.innerHTML = '';
                
                if(messages.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-500 mt-20">Aucun message, envoyez votre premier message !</div>';
                    return;
                }
                
                messages.forEach(msg => {
                    const isOwn = msg.expediteur === 'Admin';
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} mb-3`;
                    messageDiv.innerHTML = `
                        <div class="max-w-[70%]">
                            <div class="${isOwn ? 'bg-blue-500 text-white' : 'bg-white text-gray-800'} rounded-lg px-4 py-2 shadow">
                                <div class="text-sm">${msg.contenu}</div>
                                <div class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-400'} mt-1">
                                    ${new Date(msg.created_at).toLocaleString()}
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(messageDiv);
                });
                
                container.scrollTop = container.scrollHeight;
            });
    }
    
    // Envoyer un message
    function sendMessage() {
        const input = document.getElementById('messageInput');
        const content = input.value.trim();
        
        if(!content || !currentUser) {
            alert('Sélectionnez d\'abord une conversation');
            return;
        }
        
        fetch('{{ route("messages.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                contenu: content,
                destinataire: currentUser,
                expediteur: 'Admin'
            })
        })
        .then(response => response.json())
        .then(() => {
            input.value = '';
            loadConversation(currentUser);
        });
    }
    
    // Raccourci Entrée
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if(e.key === 'Enter') sendMessage();
    });
    
    // Charger les utilisateurs au démarrage
    loadUsers();
</script>
@endsection