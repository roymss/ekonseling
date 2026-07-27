@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">Live Chat Konsultasi</span>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex" style="height: 70vh; min-height: 500px;">
        
        <!-- Sidebar: List of Rooms -->
        <div class="w-1/3 border-r border-gray-200 flex flex-col bg-gray-50">
            <div class="p-4 border-b border-gray-200 bg-white flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-lg">Pesan Saya</h3>
                <button onclick="openNewChatModal()" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full shadow-sm transition-colors" title="Mulai Konsultasi Baru">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto" id="room-list">
                @if($rooms->count() == 0)
                    <div class="p-6 text-center text-gray-500 text-sm">
                        Belum ada riwayat percakapan. <br>Klik tombol + untuk memulai.
                    </div>
                @endif

                @foreach($rooms as $room)
                    <div class="room-item p-4 border-b border-gray-100 hover:bg-gray-100 cursor-pointer transition-colors {{ $loop->first ? 'bg-gray-100' : '' }}" 
                         onclick="selectRoom({{ $room->id_konsul }}, this)" data-id="{{ $room->id_konsul }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-800 text-sm truncate w-3/4">{{ $room->judul }}</h4>
                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($room->tanggal)->format('d/m') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ strip_tags($room->isi_konsul) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="w-2/3 flex flex-col bg-slate-50 relative">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 bg-white flex justify-between items-center" id="chat-header">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg" id="chat-title">Pilih pesan di samping</h3>
                    <p class="text-xs text-gray-500" id="chat-subtitle">Atau mulai percakapan baru</p>
                </div>
            </div>

            <!-- Chat Messages Area -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4" id="chat-messages" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
                <div class="flex h-full items-center justify-center text-gray-400">
                    <div>
                        <i class="fa-regular fa-comments text-4xl mb-2 text-center block"></i>
                        <p>Pilih percakapan untuk mulai membaca pesan.</p>
                    </div>
                </div>
            </div>

            <!-- Chat Input Area -->
            <div class="p-3 border-t border-gray-200 bg-white opacity-50 pointer-events-none" id="chat-input-container">
                <form id="chat-form" onsubmit="sendMessage(event)" class="flex gap-2 items-end">
                    <textarea id="message-input" class="w-full bg-gray-100 border-none rounded-2xl py-3 px-4 focus:ring-0 focus:outline-none resize-none overflow-hidden text-sm" rows="1" placeholder="Ketik pesan..." oninput="autoResize(this)" onkeypress="handleEnter(event)"></textarea>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 shadow-sm transition-colors">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            
            <!-- Loading overlay for chat area -->
            <div id="chat-loading" class="absolute inset-0 bg-white/70 flex items-center justify-center hidden z-10">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konsultasi Baru -->
<div id="newChatModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-800">Mulai Konsultasi Baru</h3>
            <button onclick="closeNewChatModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="new-chat-form" onsubmit="createNewChat(event)" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="new-kategori" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach ($kategori as $row)
                            <option value="{{ $row->id_kategori_konsul }}">{{ $row->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Psikolog</label>
                    <select id="new-psikolog" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm" required>
                        <option value="">- Pilih Psikolog -</option>
                        @foreach ($psikologs as $p)
                            <option value="{{ $p->username }}">{{ $p->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul / Topik</label>
                    <input type="text" id="new-judul" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Contoh: Sakit kepala berkepanjangan" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Pembuka</label>
                    <textarea id="new-pesan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Ceritakan keluhan Anda..." required></textarea>
                </div>
                <div class="pt-4 flex justify-end">
                    <button type="button" onclick="closeNewChatModal()" class="mr-2 px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium">Batal</button>
                    <button type="submit" id="btn-submit-new" class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-md text-sm font-medium flex items-center">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Mulai Chat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentRoomId = null;
    let pollInterval = null;

    // Load room pertama jika ada
    document.addEventListener('DOMContentLoaded', function() {
        const firstRoom = document.querySelector('.room-item');
        if(firstRoom) {
            firstRoom.click();
        }
    });

    function openNewChatModal() {
        document.getElementById('newChatModal').classList.remove('hidden');
    }

    function closeNewChatModal() {
        document.getElementById('newChatModal').classList.add('hidden');
    }

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight < 120 ? textarea.scrollHeight : 120) + 'px';
        if(textarea.scrollHeight >= 120) {
            textarea.style.overflowY = 'auto';
        } else {
            textarea.style.overflowY = 'hidden';
        }
    }

    function handleEnter(e) {
        if(e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage(e);
        }
    }

    function selectRoom(roomId, element) {
        currentRoomId = roomId;
        
        // Update UI styles
        document.querySelectorAll('.room-item').forEach(el => el.classList.remove('bg-gray-100'));
        element.classList.add('bg-gray-100');
        
        // Enable input
        document.getElementById('chat-input-container').classList.remove('opacity-50', 'pointer-events-none');
        document.getElementById('chat-loading').classList.remove('hidden');
        
        // Load messages immediately
        fetchRoomMessages(roomId, true);
        
        // Setup polling
        if(pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(() => {
            if(currentRoomId) fetchRoomMessages(currentRoomId, false);
        }, 3000);
    }

    function fetchRoomMessages(roomId, scrollToBottom = false) {
        fetch(`{{ url('user/chat/messages') }}?id_konsul=${roomId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                renderMessages(data.messages, data.room);
                if(scrollToBottom) {
                    const box = document.getElementById('chat-messages');
                    box.scrollTop = box.scrollHeight;
                    document.getElementById('chat-loading').classList.add('hidden');
                }
            }
        })
        .catch(err => console.error(err));
    }

    function renderMessages(messages, room) {
        document.getElementById('chat-title').innerText = room.judul;
        document.getElementById('chat-subtitle').innerText = 'ID: ' + room.id_konsul + ' | Dimulai: ' + room.tanggal;

        const box = document.getElementById('chat-messages');
        // Simple diff check to prevent re-rendering everything if not needed
        // For production, a more robust diffing is better, but this works for basic polling
        const currentMsgCount = box.querySelectorAll('.chat-bubble').length;
        
        if (currentMsgCount !== messages.length) {
            let html = '';
            messages.forEach(msg => {
                if(msg.is_me) {
                    html += `
                        <div class="chat-bubble flex justify-end">
                            <div class="bg-green-100 rounded-2xl rounded-tr-sm py-2 px-3 max-w-[75%] shadow-sm border border-green-200">
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">${msg.text}</p>
                                <p class="text-[10px] text-gray-500 text-right mt-1">${msg.time.substring(11, 16)}</p>
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="chat-bubble flex justify-start">
                            <div class="bg-white rounded-2xl rounded-tl-sm py-2 px-3 max-w-[75%] shadow-sm border border-gray-200 relative">
                                <span class="text-xs font-bold text-blue-600 mb-1 block">${msg.sender}</span>
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">${msg.text}</p>
                                <p class="text-[10px] text-gray-400 text-right mt-1">${msg.time.substring(11, 16)}</p>
                            </div>
                        </div>
                    `;
                }
            });
            
            // Auto scroll logic (if already at bottom, stay at bottom)
            const isAtBottom = box.scrollHeight - box.scrollTop <= box.clientHeight + 100;
            
            box.innerHTML = html;
            
            if (isAtBottom) {
                box.scrollTop = box.scrollHeight;
            }
        }
    }

    function sendMessage(e) {
        if(e) e.preventDefault();
        
        const input = document.getElementById('message-input');
        const text = input.value.trim();
        
        if(!text || !currentRoomId) return;
        
        input.value = '';
        input.style.height = 'auto'; // reset height
        
        // Optimistic UI update (add to DOM immediately)
        const box = document.getElementById('chat-messages');
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        
        box.insertAdjacentHTML('beforeend', `
            <div class="chat-bubble flex justify-end opacity-70" id="temp-msg">
                <div class="bg-green-100 rounded-2xl rounded-tr-sm py-2 px-3 max-w-[75%] shadow-sm border border-green-200">
                    <p class="text-sm text-gray-800 whitespace-pre-wrap">${text}</p>
                    <p class="text-[10px] text-gray-500 text-right mt-1">${timeStr} <i class="fa-solid fa-clock ml-1"></i></p>
                </div>
            </div>
        `);
        box.scrollTop = box.scrollHeight;
        
        // Send to server
        const formData = new FormData();
        formData.append('id_konsul', currentRoomId);
        formData.append('message', text);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch(`{{ url('user/chat/send') }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Fetch immediately to get true ID and remove temp msg
                fetchRoomMessages(currentRoomId, true);
            }
        });
    }

    function createNewChat(e) {
        e.preventDefault();
        
        const btn = document.getElementById('btn-submit-new');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...';
        btn.disabled = true;
        
        const formData = new FormData();
        formData.append('kategori', document.getElementById('new-kategori').value);
        formData.append('judul', document.getElementById('new-judul').value);
        formData.append('pesan', document.getElementById('new-pesan').value);
        formData.append('psikolog', document.getElementById('new-psikolog').value);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch(`{{ url('user/chat/create') }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Reload page to show new room in list (simplest approach for now)
                window.location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i> Mulai Chat';
            btn.disabled = false;
        });
    }
</script>
@endsection
