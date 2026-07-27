@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">Dashboard Psikolog - Live Chat</span>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex" style="height: 75vh; min-height: 500px;">
        
        <!-- Sidebar: List of Rooms (All Patients) -->
        <div class="w-1/3 border-r border-gray-200 flex flex-col bg-gray-50">
            <div class="p-4 border-b border-gray-200 bg-blue-50 flex justify-between items-center">
                <h3 class="font-bold text-blue-800 text-lg">Daftar Konsultasi Pasien</h3>
                <!-- No add button for psikolog -->
            </div>
            
            <div class="flex-1 overflow-y-auto" id="room-list">
                @if($rooms->count() == 0)
                    <div class="p-6 text-center text-gray-500 text-sm">
                        Belum ada riwayat percakapan pasien.
                    </div>
                @endif

                @foreach($rooms as $room)
                    <div class="room-item p-4 border-b border-gray-100 hover:bg-gray-100 cursor-pointer transition-colors {{ $loop->first ? 'bg-gray-100' : '' }}" 
                         onclick="selectRoom({{ $room->id_konsul }}, this)" data-id="{{ $room->id_konsul }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-800 text-sm truncate w-3/4">{{ $room->nama_pasien ?? $room->username }}</h4>
                            <span class="text-xs text-blue-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($room->tanggal)->format('d/m') }}</span>
                        </div>
                        <p class="text-xs font-semibold text-gray-700 truncate">{{ $room->judul }}</p>
                        <p class="text-xs text-gray-500 truncate mt-1">{{ strip_tags($room->isi_konsul) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="w-2/3 flex flex-col bg-slate-50 relative">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 bg-white flex justify-between items-center" id="chat-header">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3 hidden" id="chat-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg" id="chat-title">Pilih pesan pasien di samping</h3>
                        <p class="text-xs text-gray-500" id="chat-subtitle">Untuk mulai memberikan tanggapan</p>
                    </div>
                </div>
            </div>

            <!-- Chat Messages Area -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4" id="chat-messages" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
                <div class="flex h-full items-center justify-center text-gray-400">
                    <div>
                        <i class="fa-regular fa-comments text-4xl mb-2 text-center block text-blue-200"></i>
                        <p>Pilih percakapan untuk mulai membaca keluhan.</p>
                    </div>
                </div>
            </div>

            <!-- Chat Input Area -->
            <div class="p-3 border-t border-gray-200 bg-white opacity-50 pointer-events-none" id="chat-input-container">
                <form id="chat-form" onsubmit="sendMessage(event)" class="flex gap-2 items-end">
                    <textarea id="message-input" class="w-full bg-gray-100 border-none rounded-2xl py-3 px-4 focus:ring-0 focus:outline-none resize-none overflow-hidden text-sm" rows="1" placeholder="Ketik tanggapan medis..." oninput="autoResize(this)" onkeypress="handleEnter(event)"></textarea>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 shadow-sm transition-colors">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            
            <!-- Loading overlay for chat area -->
            <div id="chat-loading" class="absolute inset-0 bg-white/70 flex items-center justify-center hidden z-10">
                <i class="fa-solid fa-spinner fa-spin text-3xl text-blue-600"></i>
            </div>
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

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight < 150 ? textarea.scrollHeight : 150) + 'px';
        if(textarea.scrollHeight >= 150) {
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
        document.querySelectorAll('.room-item').forEach(el => el.classList.remove('bg-gray-100', 'border-l-4', 'border-blue-500'));
        element.classList.add('bg-gray-100', 'border-l-4', 'border-blue-500');
        
        // Enable input
        document.getElementById('chat-input-container').classList.remove('opacity-50', 'pointer-events-none');
        document.getElementById('chat-loading').classList.remove('hidden');
        document.getElementById('chat-avatar').classList.remove('hidden');
        
        // Load messages immediately
        fetchRoomMessages(roomId, true);
        
        // Setup polling
        if(pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(() => {
            if(currentRoomId) fetchRoomMessages(currentRoomId, false);
        }, 3000);
    }

    function fetchRoomMessages(roomId, scrollToBottom = false) {
        fetch(`{{ url('psikolog/chat/messages') }}?id_konsul=${roomId}`, {
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
        document.getElementById('chat-title').innerText = room.nama_pasien ?? room.username;
        document.getElementById('chat-subtitle').innerText = room.judul;

        const box = document.getElementById('chat-messages');
        const currentMsgCount = box.querySelectorAll('.chat-bubble').length;
        
        if (currentMsgCount !== messages.length) {
            let html = '';
            messages.forEach(msg => {
                if(msg.is_me) { // is_me for psikolog
                    html += `
                        <div class="chat-bubble flex justify-end">
                            <div class="bg-blue-100 rounded-2xl rounded-tr-sm py-2 px-3 max-w-[75%] shadow-sm border border-blue-200">
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">${msg.text}</p>
                                <p class="text-[10px] text-gray-500 text-right mt-1">${msg.time.substring(11, 16)}</p>
                            </div>
                        </div>
                    `;
                } else { // Pasien
                    html += `
                        <div class="chat-bubble flex justify-start">
                            <div class="bg-white rounded-2xl rounded-tl-sm py-2 px-3 max-w-[75%] shadow-sm border border-gray-200 relative">
                                <span class="text-xs font-bold text-green-600 mb-1 block">${msg.sender}</span>
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">${msg.text}</p>
                                <p class="text-[10px] text-gray-400 text-right mt-1">${msg.time.substring(11, 16)}</p>
                            </div>
                        </div>
                    `;
                }
            });
            
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
        input.style.height = 'auto';
        
        const box = document.getElementById('chat-messages');
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        
        box.insertAdjacentHTML('beforeend', `
            <div class="chat-bubble flex justify-end opacity-70" id="temp-msg">
                <div class="bg-blue-100 rounded-2xl rounded-tr-sm py-2 px-3 max-w-[75%] shadow-sm border border-blue-200">
                    <p class="text-sm text-gray-800 whitespace-pre-wrap">${text}</p>
                    <p class="text-[10px] text-gray-500 text-right mt-1">${timeStr} <i class="fa-solid fa-clock ml-1"></i></p>
                </div>
            </div>
        `);
        box.scrollTop = box.scrollHeight;
        
        const formData = new FormData();
        formData.append('id_konsul', currentRoomId);
        formData.append('message', text);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch(`{{ url('psikolog/chat/send') }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                fetchRoomMessages(currentRoomId, true);
            }
        });
    }
</script>
@endsection
