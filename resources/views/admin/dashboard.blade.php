@extends('admin.layout.app')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Admin')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Stat cards -->
    <div class="admin-card bg-gradient-to-r from-indigo-600 to-purple-600 p-5 rounded-xl shadow-lg text-white flex items-center">
        <i class="fa-solid fa-users text-3xl mr-4"></i>
        <div>
            <div class="text-sm font-medium">Total Pengguna</div>
            <div class="text-2xl font-bold">{{ $total_users }}</div>
        </div>
    </div>
    <div class="admin-card bg-gradient-to-r from-indigo-600 to-purple-600 p-5 rounded-xl shadow-lg text-white flex items-center">
        <i class="fa-solid fa-user-md text-3xl mr-4"></i>
        <div>
            <div class="text-sm font-medium">Total Konselor</div>
            <div class="text-2xl font-bold">{{ $total_psikolog }}</div>
        </div>
    </div>
    <div class="admin-card bg-gradient-to-r from-indigo-600 to-purple-600 p-5 rounded-xl shadow-lg text-white flex items-center">
        <i class="fa-solid fa-stethoscope text-3xl mr-4"></i>
        <div>
            <div class="text-sm font-medium">Konsultasi Aktif</div>
            <div class="text-2xl font-bold">{{ $active_consultations }}</div>
        </div>
    </div>
</div>

<!-- Quick actions -->
<div class="mt-8 flex gap-4">
    <a href="{{ route('admin.manajemenuser') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        <i class="fa-solid fa-user-plus mr-2"></i>Tambah Pengguna
    </a>
    <a href="{{ route('admin.manajemen_psikolog') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        <i class="fa-solid fa-user-md mr-2"></i>Tambah Konselor
    </a>
</div>

<!-- Recent tables -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div>
        <h3 class="text-lg font-semibold mb-2">Catatan Klinis Terbaru</h3>
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Pasien</th>
                    <th class="px-4 py-2 text-left">Konselor</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_notes as $note)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $note->id }}</td>
                    <td class="px-4 py-2">{{ $note->nama_pasien ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $note->nama_konselor ?? '-' }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($note->created_at)->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <h3 class="text-lg font-semibold mb-2">Konsultasi Terbaru</h3>
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Pasien</th>
                    <th class="px-4 py-2 text-left">Konselor</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_consultations as $cons)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $cons->id_konsul }}</td>
                    <td class="px-4 py-2">{{ $cons->username ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $cons->username_psikolog ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $cons->status ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Chart -->
<div class="mt-8 bg-white border border-[#C4C6CF] p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-bold text-[#002045] mb-4">Konsultasi 7 Hari Terakhir</h3>
    <div class="relative h-64 w-full">
        <canvas id="consultationsChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('consultationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart['labels']) !!},
            datasets: [{
                label: 'Konsultasi Aktif',
                data: {!! json_encode($chart['data']) !!},
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79,70,229,0.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush
