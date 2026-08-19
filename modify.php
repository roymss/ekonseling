<?php
$c = file_get_contents('resources/views/psikolog/profile.blade.php');
$c = str_replace('Sesi Saya', 'Pasien Saya', $c);
$c = str_replace("url('user/edit_profile')", "url('psikolog/edit_profile')", $c);
$c = str_replace('user/chat', 'psikolog/chat', $c);
$c = str_replace("url('user/konsultasi')", "url('psikolog/profile')", $c);

// Remove "Jadwalkan Sesi Baru" button
$c = preg_replace('/<button[^>]*@click\.prevent="\$dispatch\(\'open-new-session\'\)"[^>]*>.*?<\/button>/is', '', $c);
// Remove new session modal
$c = preg_replace('/<!-- New Session Modal -->.*?<!-- Detail Modal Popup -->/is', '<!-- Detail Modal Popup -->', $c);

// Replace queries in Blade for Sesi Mendatang
$c = preg_replace("/where\('konsul.username', session\('username'\)\)/", "where('konsul.username_psikolog', session('username'))", $c);

// Also $sesi_saya query:
$c = preg_replace("/\\\$sesi_saya = .*?->get\(\);/s", "
\$sesi_saya = \Illuminate\Support\Facades\DB::table('konsul')
    ->leftJoin('users', 'konsul.username', '=', 'users.username')
    ->select('konsul.*', 'users.nama_lengkap as nama_pasien')
    ->where('konsul.username_psikolog', session('username'))
    ->orderBy('konsul.id_konsul', 'desc')
    ->get();
", $c);

// "Konseling dengan {{ $k->nama_psikolog ?? 'Konselor (Menunggu)' }}" -> "Pasien: {{ $k->nama_pasien ?? $k->username }}"
$c = str_replace("Konseling dengan {{ \$k->nama_psikolog ?? 'Konselor (Menunggu)' }}", "Konseling dengan Pasien: {{ \$k->nama_pasien ?? \$k->username }}", $c);
$c = str_replace("Konseling dengan {{ \$sesi_mendatang->nama_psikolog ?? 'Konselor (Menunggu)' }}", "Konseling dengan Pasien: {{ \$sesi_mendatang->nama_pasien ?? 'Pasien' }}", $c);
// initChat name
$c = str_replace("initChat({{ \$k->id_konsul }}, '{{ addslashes(\$k->nama_psikolog ?? 'Konselor') }}')", "initChat({{ \$k->id_konsul }}, '{{ addslashes(\$k->nama_pasien ?? 'Pasien') }}')", $c);

file_put_contents('resources/views/psikolog/profile.blade.php', $c);
echo "Done";
