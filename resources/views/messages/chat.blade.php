@extends('layouts.app')
@section('title', 'Chat with Ahli')

@section('content')
<div class="flex flex w-full h-[84vh] p-3 md:p-2 gap-4 pt-2 md:pb-0">
    <!-- Sidebar Daftar Pengguna -->
    <div id="chat-list-panel" class="w-full md:w-1/3 bg-white border-2 border-dark rounded-playful-lg flex flex-col overflow-hidden shadow-border-offset-lg mt-1 md:mt-0 z-10">
        <div class="p-4 border-b-2 border-dark flex items-center bg-white">
            <h2 class="text-xl font-bold font-exo2">Chat</h2>
            <input type="text" id="search-users" placeholder="Cari pengguna..." class="ml-3 flex-1 rounded-full py-1 px-3 bg-gray-100 border-2 border-dark focus:outline-none focus:border-primary text-sm">
        </div>
        <div id="users-list" class="flex flex-col p-2 overflow-y-auto space-y-2">
            <!-- Daftar pengguna akan dimuat di sini oleh JavaScript -->
            <a href="{{ route('chat.bot') }}" class="click-1 user-list-item flex items-center p-3 rounded-playful-sm bg-primary border-2 border-dark shadow-border-offset">
                <div class="w-10 h-10 rounded-full bg-dark flex items-center justify-center text-white mr-3">
                    <i class="fas fa-robot text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-dark font-exo2">Curhat dengan NEMO</h3>
                    <p class="text-xs text-dark">Temen untuk curhat anda</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Area Chat Utama -->
    <div id="chat-window-panel" class="flex-1 hidden md:flex flex-col bg-white border-2 border-dark rounded-playful-lg ml-[-12px] shadow-border-offset-lg mt-4 md:mt-0 p-4 relative">
        <!-- Header Chat -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-2 flex items-center z-20 ">
            <div id="current-chat-info" class="min-w-[150px] ">
                    <div class="flex items-center p-2 bg-white rounded-md border-2 border-dark shadow-md z-20">

                <div class="flex items-center ">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white mr-">
                        <i class="fas fa-robot text-lg"></i>
                    </div>
                    <h3 class="font-bold text-base font-exo2 text-dark">Pilih percakapan</h3>
                </div>
                    </div>
            </div>
        </div>

        <!-- Container Pesan -->
        <div id="messages-container" class="flex-1 p-4 overflow-y-auto space-y-6 pt-16">
            <!-- Pesan akan dimuat di sini oleh JavaScript -->
            <div class="flex justify-center items-center h-full">
                <p class="text-gray-500">Pilih percakapan untuk mulai mengobrol</p>
            </div>
        </div>

        <!-- Input Pesan (Awalnya Disembunyikan) -->
        <div id="message-input-container" style="display: none;" class="p-4 border-t-2 border-dark sticky bottom-0 bg-white z-10">
            <form id="message-form" class="flex items-center space-x-2">
                <input type="text" id="message-input" placeholder="Ketik pesan..." class="flex-1 rounded-full py-2 px-4 bg-gray-100 border-2 border-dark focus:outline-none focus:border-primary">
                <button type="submit" class="bg-primary text-white p-2 rounded-full w-10 h-10 flex items-center justify-center border-2 border-dark shadow-[2px_3px_0px_#080330] hover:bg-primary-dark transition-transform duration-200 hover:scale-105">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Styles untuk Chat -->
<style>
    .user-list-item {
        cursor: pointer;
        padding: 12px;
        border-radius: 8px;
        border: 2px solid #080330;
        margin-bottom: 8px;
        background: white;
        box-shadow: 2px 3px 0px #080330;
        transition: all 0.2s ease;
    }

    .user-list-item:hover {
        transform: translateY(-2px);
        box-shadow: 4px 5px 0px #080330;
    }

    .user-list-item.active {
        background-color: #F0C3FF;
    }

    .online-status, .offline-status {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 4px;
    }

    .online-status {
        background-color: #4CAF50;
    }

    .offline-status {
        background-color: #9E9E9E;
    }

    .unread-count {
        background-color: #FF5252;
        color: white;
    }

    .message {
    margin-bottom: 1rem;
    max-width: 75%;
    padding: 0.75rem;
    border-radius: 0.5rem;
    border: 2px solid #080330;
    box-shadow: 2px 3px 0px #080330;
    position: relative;
    display: flex;
    flex-direction: column;
}

.message.sent {
    margin-left: auto;
    background: #4F46E5; /* warna solid biar mirip user */
    color: white;
}

.message.received {
    margin-right: auto;
    background: #F3F4F6;
    color: #080330;
}

.message-content {
    /* kalau mau isi aja yang beda, bisa kosongin style di sini */
}

.message-time {
    font-size: 0.75rem;
    margin-top: 0.5rem;
    display: flex;
    justify-content: flex-end;
    opacity: 0.7;
}

</style>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatListPanel = document.getElementById('chat-list-panel');
    const chatWindowPanel = document.getElementById('chat-window-panel');

    // window.ChatApp = {
    //     currentUser: {{ Auth::id() }},
    //     currentChat: null,
    //     pusher: null,
    //     channel: null,

    //     isMobile: function() {
    //         return window.innerWidth < 768;
    //     },

    //     init: function() {
    //         this.loadUsers();
    //         this.setupEventListeners();
    //         this.initPusher();
    //     },

    //     initPusher: function() {
    //         this.pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
    //             cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
    //             encrypted: true
    //         });
    //         this.channel = this.pusher.subscribe('user.' + this.currentUser);
    //         this.channel.bind('ChatMessageSent', (data) => {
    //             this.handleNewMessage(data);
    //         });
    //     },

    //     loadUsers: function() {
    //         fetch('{{ route("chat.users") }}')
    //             .then(response => response.json())
    //             .then(users => {
    //                 this.renderUsers(users);
    //             });
    //     },

    //     renderUsers: function(users) {
    //         const usersList = document.getElementById('users-list');

    //         users.forEach(user => {
    //             const userElement = document.createElement('div');
    //             userElement.className = 'user-list-item';
    //             userElement.dataset.userId = user.id;
    //             userElement.innerHTML = `
    //                 <div class="flex items-center w-full">
    //                     <img src="${user.avatar || 'https://ui-avatars.com/api/?name=' + user.name}"
    //                          class="rounded-full mr-3" width="40" height="40">
    //                     <div class="flex-1">
    //                         <h6 class="font-bold mb-0">${user.name}</h6>
    //                         <small class="text-muted" id="status-${user.id}">
    //                             ${user.is_online ? '<span class="online-status"></span> Online' : '<span class="offline-status"></span> Offline'}
    //                         </small>
    //                     </div>
    //                     <span class="unread-count text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full"
    //                           id="unread-${user.id}" style="display: none;">0</span>
    //                 </div>
    //             `;

    //             userElement.addEventListener('click', () => {
    //                 this.selectUser(user);
    //             });

    //             usersList.appendChild(userElement);
    //         });
    //     },

    //     selectUser: function(user) {
    //         this.currentChat = user;

    //         if (this.isMobile()) {
    //             chatListPanel.classList.add('hidden');
    //             chatWindowPanel.classList.remove('hidden');
    //             chatWindowPanel.classList.add('flex');
    //         }

    //         document.querySelectorAll('.user-list-item').forEach(item => {
    //             item.classList.remove('active');
    //         });
    //         document.querySelector(`[data-user-id="${user.id}"]`).classList.add('active');

    //         document.getElementById('current-chat-info').innerHTML = `
    //             <div class="flex items-center p-2 bg-white rounded-md border-2 border-dark shadow-md z-20 w-full">
    //                 <button id="back-to-list-button" class="text-dark mr-3 md:hidden">
    //                     <i class="fas fa-arrow-left"></i>
    //                 </button>

    //                 <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white mr-2 border-2 border-dark overflow-hidden">
    //                     ${ user.avatar
    //                        ? `<img src="${user.avatar}" class="w-full h-full object-cover">`
    //                        : `<i class="fas fa-user text-sm"></i>` }
    //                 </div>
    //                 <div class="flex-1">
    //                     <h3 class="font-bold text-base text-dark m-0">${user.name}</h3>
    //                     <p class="text-xs text-gray-600" id="current-user-status">
    //                         ${document.getElementById(`status-${user.id}`).innerHTML}
    //                     </p>
    //                 </div>
    //             </div>
    //         `;

    //         document.getElementById('back-to-list-button').addEventListener('click', () => {
    //             chatWindowPanel.classList.add('hidden');
    //             chatWindowPanel.classList.remove('flex');
    //             chatListPanel.classList.remove('hidden');
    //             this.currentChat = null;
    //         });

    //         document.getElementById('message-input-container').style.display = 'block';
    //         this.loadMessages(user.id);
    //     },

    //     loadMessages: function(userId) {
    //         fetch(`/chat/messages/${userId}`)
    //             .then(response => response.json())
    //             .then(messages => {
    //                 this.renderMessages(messages);
    //                 this.markAsRead(userId);
    //             });
    //     },

    //     renderMessages: function(messages) {
    //         const container = document.getElementById('messages-container');
    //         container.innerHTML = '';

    //         if (messages.length === 0) {
    //             container.innerHTML = '<div class="flex justify-center items-center h-full"><p class="text-gray-500">Mulai percakapan dengan mengirim pesan</p></div>';
    //             return;
    //         }

    //         messages.forEach(message => {
    //             const messageElement = document.createElement('div');
    //             messageElement.className = `message ${message.sender_id === this.currentUser ? 'sent' : 'received'}`;

    //             messageElement.innerHTML = `
    //                 <div class="message-content">
    //                     <div class="message-text">${message.body}</div>
    //                     <div class="message-time">
    //                         ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
    //                     </div>
    //                 </div>
    //             `;

    //             container.appendChild(messageElement);
    //         });

    //         container.scrollTop = container.scrollHeight;
    //     },

    //     setupEventListeners: function() {
    //         document.getElementById('message-form').addEventListener('submit', (e) => {
    //             e.preventDefault();
    //             this.sendMessage();
    //         });

    //         document.getElementById('search-users').addEventListener('input', (e) => {
    //             this.searchUsers(e.target.value);
    //         });
    //     },

    //     sendMessage: function() {
    //         const messageInput = document.getElementById('message-input');
    //         const message = messageInput.value.trim();

    //         if (!message || !this.currentChat) return;

    //         fetch('{{ route("chat.send") }}', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: JSON.stringify({
    //                 receiver_id: this.currentChat.id,
    //                 message: message
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 messageInput.value = '';
    //                 // Optimistic UI update can be added here
    //                 this.loadMessages(this.currentChat.id);
    //             }
    //         });
    //     },

    //     handleNewMessage: function(data) {
    //         if (this.currentChat && data.message.sender_id === this.currentChat.id) {
    //             this.loadMessages(this.currentChat.id);
    //         } else {
    //             this.updateUnreadCount(data.message.sender_id);
    //         }
    //     },

    //     updateUnreadCount: function(userId) {
    //         const unreadElement = document.getElementById(`unread-${userId}`);
    //         if (unreadElement) {
    //             const currentCount = parseInt(unreadElement.textContent) || 0;
    //             unreadElement.textContent = currentCount + 1;
    //             unreadElement.style.display = 'flex';
    //         }
    //     },

    //     markAsRead: function(userId) {
    //         fetch(`/chat/mark-read/${userId}`, {
    //             method: 'POST',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             }
    //         });

    //         const unreadElement = document.getElementById(`unread-${userId}`);
    //         if (unreadElement) {
    //             unreadElement.style.display = 'none';
    //             unreadElement.textContent = '0';
    //         }
    //     },

    //     searchUsers: function(query) {
    //         const usersList = document.getElementById('users-list');
    //         const originalItems = usersList.querySelectorAll('.user-list-item');

    //         originalItems.forEach(item => {
    //             const userName = item.querySelector('h6').textContent.toLowerCase();
    //             if (userName.includes(query.toLowerCase())) {
    //                 item.style.display = 'flex';
    //             } else {
    //                 item.style.display = 'none';
    //             }
    //         });
    //     }
    // };

    // ChatApp.init();
});
</script>
@endsection
