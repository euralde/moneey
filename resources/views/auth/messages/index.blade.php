@extends('layouts.app')

@section('content')

<div class="flex-1 flex max-w-7xl mx-auto w-full p-4 gap-5 overflow-hidden">

    <!-- =========================
        LISTE DES CONTACTS
    ========================== -->
    <div class="w-80 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col overflow-hidden flex-shrink-0">

        <!-- SEARCH -->
        <div class="p-4 border-b border-gray-100">

            <div class="relative">

                <iconify-icon
                    icon="solar:magnifer-linear"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">
                </iconify-icon>

                <input
                    type="text"
                    id="searchContact"
                    placeholder="Rechercher un profil..."
                    class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>

        <!-- CONTACTS -->
        <div class="flex-1 overflow-y-auto" id="contactsList">

            @foreach($users as $user)

                <div
                    class="contact-item p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition-all"

                    data-user-id="{{ $user->id }}"

                    data-user-name="{{ $user->firstname.' '.$user->lastname }}"

                    data-user-initials="{{ strtoupper(substr($user->firstname,0,1).substr($user->lastname,0,1)) }}">

                    <div class="flex items-center gap-3">

                        <!-- Avatar -->
                        <div class="relative">

                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-medium text-white text-sm">

                                {{ strtoupper(substr($user->firstname,0,1).substr($user->lastname,0,1)) }}

                            </div>
                        </div>

                        <!-- Infos -->
                        <div class="flex-1 min-w-0">

                            <div class="flex justify-between items-start w-full">

                                <h4 class="font-medium text-gray-900 text-sm truncate">

                                    {{ $user->firstname.' '.$user->lastname }}

                                </h4>

                                @if($user->unread_count > 0)

                                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-2">

                                        {{ $user->unread_count }}

                                    </span>

                                @endif
                            </div>

                            <p class="text-xs text-gray-500 truncate">

                                {{ $user->email }}

                            </p>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>

    <!-- =========================
        ZONE DE CHAT
    ========================== -->
    <div class="flex-1 bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col overflow-hidden">

        <!-- HEADER -->
        <div id="chatHeader"
            class="px-6 py-4 border-b bg-gray-50/50 flex items-center gap-3">

            <!-- Avatar -->
            <div id="selectedContactAvatar"
                class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center font-medium text-white text-sm">

                ?
            </div>

            <!-- Infos -->
            <div>

                <h3 id="selectedContactName"
                    class="font-semibold text-gray-900">

                    Sélectionnez un contact

                </h3>

                <p id="selectedContactStatus"
                    class="text-xs text-gray-400">

                    ...

                </p>
            </div>
        </div>

        <!-- MESSAGES -->
        <div id="chatMessages"
            class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/30">
        </div>

        <!-- INPUT -->
        <div id="messageInputContainer"
            class="p-4 border-t bg-white hidden">

            <div class="flex gap-3">

                <textarea
                    id="messageInput"
                    rows="2"
                    placeholder="Écrivez votre message..."
                    class="flex-1 px-4 py-2 border border-gray-200 rounded-xl resize-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm">
                </textarea>

                <button id="sendMessageBtn"
                    class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2">

                    ✈️ Envoyer

                </button>
            </div>
        </div>

        <!-- EMPTY -->
        <div id="noContactSelected"
            class="flex-1 flex flex-col items-center justify-center text-gray-400">

            <iconify-icon
                icon="solar:chat-dots-linear"
                class="text-5xl mb-3 opacity-50">
            </iconify-icon>

            <p class="text-sm">

                Sélectionnez un contact pour commencer à discuter

            </p>
        </div>
    </div>
</div>

<!-- =========================
    SCRIPT
========================== -->

<script>

    let currentReceiverId = null;
    let currentConversationId = null;

    // =========================
    // START CONVERSATION
    // =========================
    function startConversation(receiverId, name, initials)
    {
        currentReceiverId = receiverId;

        // HEADER
        document.getElementById('selectedContactName')
            .innerText = name;

        document.getElementById('selectedContactAvatar')
            .innerText = initials;

        document.getElementById('selectedContactStatus')
            .innerText = '🟢 En ligne';

        // UI
        document.getElementById('messageInputContainer')
            .classList.remove('hidden');

        document.getElementById('noContactSelected')
            .classList.add('hidden');

        // ACTIVE CONTACT
        document.querySelectorAll('.contact-item')
            .forEach(item => {

                item.classList.remove('contact-active');
            });

        const currentContact =
            document.querySelector(
                `.contact-item[data-user-id="${receiverId}"]`
            );

        currentContact.classList.add('contact-active');

        // CHECK CONVERSATION
        fetch(`/conversations/check/${receiverId}`)

            .then(res => res.json())

            .then(data => {

                if (data.conversation_id)
                {
                    currentConversationId =
                        data.conversation_id;

                    loadMessages(currentConversationId);
                }
                else
                {
                    currentConversationId = null;

                    document.getElementById('chatMessages')
                        .innerHTML = `
                            <div class="text-center text-gray-500">
                                Aucun message,
                                écrivez le premier 👋
                            </div>
                        `;
                }
            });
    }

    // =========================
    // LOAD MESSAGES
    // =========================
    function loadMessages(conversationId)
    {
        fetch(`/conversations/${conversationId}`)

            .then(res => res.json())

            .then(data => {

                const container =
                    document.getElementById('chatMessages');

                container.innerHTML = '';

                data.messages.forEach(msg => {

                    const isOwn =
                        msg.sender_id === {{ auth()->id() }};

                    const div =
                        document.createElement('div');

                    div.className =
                        `chat-message flex ${
                            isOwn
                            ? 'justify-end'
                            : 'justify-start'
                        }`;

                    div.innerHTML = `
                        <div class="
                            max-w-[70%]
                            ${isOwn
                                ? 'bg-blue-600 text-white rounded-l-xl rounded-br-xl'
                                : 'bg-white border border-gray-200 rounded-r-xl rounded-bl-xl'}
                            px-4 py-2 shadow-sm
                        ">

                            <div class="
                                flex items-center gap-2 mb-1
                                ${isOwn ? 'justify-end' : ''}
                            ">

                                <span class="
                                    text-xs font-medium
                                    ${isOwn
                                        ? 'text-blue-100'
                                        : 'text-gray-500'}
                                ">

                                    ${escapeHtml(
                                        msg.sender.firstname
                                        + ' '
                                        + msg.sender.lastname
                                    )}

                                </span>

                                <span class="
                                    text-[10px]
                                    ${isOwn
                                        ? 'text-blue-200'
                                        : 'text-gray-400'}
                                ">

                                    ${new Date(
                                        msg.created_at
                                    ).toLocaleTimeString()}

                                </span>
                            </div>

                            <p class="
                                text-sm
                                ${isOwn
                                    ? 'text-white'
                                    : 'text-gray-700'}
                            ">

                                ${escapeHtml(msg.content)}

                            </p>
                        </div>
                    `;

                    container.appendChild(div);
                });

                container.scrollTop =
                    container.scrollHeight;
            });
    }

    // =========================
    // SEND MESSAGE
    // =========================
    function sendMessage()
    {
        const content =
            document.getElementById('messageInput')
            .value
            .trim();

        if (!content || !currentReceiverId)
            return;

        // CREATE CONVERSATION
        if (!currentConversationId)
        {
            fetch('/conversations', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}'
                },

                body: JSON.stringify({

                    receiver_id:
                        currentReceiverId
                })

            })

            .then(res => res.json())

            .then(data => {

                currentConversationId =
                    data.id;

                sendMessageToConversation(content);
            });
        }
        else
        {
            sendMessageToConversation(content);
        }
    }

    // =========================
    // SEND TO CONVERSATION
    // =========================
    function sendMessageToConversation(content)
    {
        fetch('{{ route("messages.send") }}', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            },

            body: JSON.stringify({

                conversation_id:
                    currentConversationId,

                content: content
            })

        })

        .then(() => {

            document.getElementById('messageInput')
                .value = '';

            loadMessages(currentConversationId);
        });
    }

    // =========================
    // ESCAPE HTML
    // =========================
    function escapeHtml(str)
    {
        if (!str) return '';

        const div =
            document.createElement('div');

        div.textContent = str;

        return div.innerHTML;
    }

    // =========================
    // EVENTS
    // =========================
    document.querySelectorAll('.contact-item')

        .forEach(el => {

            el.addEventListener('click', () => {

                const id =
                    el.dataset.userId;

                const name =
                    el.dataset.userName;

                const initials =
                    el.dataset.userInitials;

                startConversation(
                    id,
                    name,
                    initials
                );
            });
        });

    // SEND BUTTON
    document.getElementById('sendMessageBtn')

        .addEventListener(
            'click',
            sendMessage
        );

    // ENTER KEY
    document.getElementById('messageInput')

        .addEventListener('keypress', function(e) {

            if (
                e.key === 'Enter'
                &&
                !e.shiftKey
            )
            {
                e.preventDefault();

                sendMessage();
            }
        });

    // SEARCH
    document.getElementById('searchContact')

        .addEventListener('input', function(e) {

            const term =
                e.target.value.toLowerCase();

            document.querySelectorAll('.contact-item')

                .forEach(el => {

                    const name =
                        el.querySelector('h4')
                        .innerText
                        .toLowerCase();

                    el.style.display =
                        name.includes(term)
                        ? 'flex'
                        : 'none';
                });
        });

</script>

<!-- =========================
    STYLE
========================== -->

<style>

    .chat-message {
        animation: fadeInUp 0.2s ease;
    }

    @keyframes fadeInUp {

        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .contact-active {

        background-color: #eff6ff;

        border-left: 3px solid #3b82f6;
    }

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

</style>

@endsection