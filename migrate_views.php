<?php
$source_dir = 'c:/laragon/www/ekonseling/application/views/phpmu-ekonseling/';
$target_views_dir = 'c:/laragon/www/ekonseling/ekonseling-laravel/resources/views/';

$directories = ['layouts', 'partials', 'berita', 'halaman', 'kategori', 'konsultasi', 'hubungi', 'download', 'user'];
foreach ($directories as $dir) {
    if (!is_dir($target_views_dir . $dir)) mkdir($target_views_dir . $dir, 0777, true);
}

function convert_ci_to_blade($content) {
    $content = str_replace('<?php echo base_url(); ?>', "{{ url('/') }}/", $content);
    $content = str_replace('<?php echo template(); ?>', 'phpmu-ekonseling', $content);
    $content = str_replace('<?=template()?>', 'phpmu-ekonseling', $content);
    $content = str_replace('<?php echo $contents; ?>', "@yield('content')", $content);
    
    // Replace specific includes
    $content = preg_replace("/<\?php\s+include\s+[\"'](.*?)[\"'];\s*\?>/", "@include('partials.$1')", $content);
    
    // Echos
    $content = preg_replace("/<\?php\s+echo\s+(.*?);\s*\?>/", "{{ $1 }}", $content);
    
    return $content;
}

$files_to_partials = ['header-top.php', 'header.php', 'footer.php', 'footer-copyright.php', 'sidebar.php', 'sidebar_kiri.php'];
foreach ($files_to_partials as $file) {
    if (file_exists($source_dir . $file)) {
        $content = convert_ci_to_blade(file_get_contents($source_dir . $file));
        file_put_contents($target_views_dir . 'partials/' . str_replace('.php', '.blade.php', $file), $content);
        echo "Created partial: $file\n";
    }
}


if (file_exists($source_dir . 'template.php')) {
    $content = convert_ci_to_blade(file_get_contents($source_dir . 'template.php'));
    file_put_contents($target_views_dir . 'layouts/app.blade.php', $content);
    echo "Created layout\n";
}

$view_map = [
    'home.php' => 'home.blade.php',
    'berita.php' => 'berita/index.blade.php',
    'detailberita.php' => 'berita/detail.blade.php',
    'detailhalaman.php' => 'halaman/detail.blade.php',
    'detailkategori.php' => 'kategori/detail.blade.php',
    'konsultasi.php' => 'konsultasi/index.blade.php',
    'detailkonsul.php' => 'konsultasi/detail.blade.php',
    'hubungi.php' => 'hubungi/index.blade.php',
    'download.php' => 'download/index.blade.php',
    'login.php' => 'user/login.blade.php',
    'register.php' => 'user/register.blade.php',
    'profile.php' => 'user/profile.blade.php',
    'profile_edit.php' => 'user/profile_edit.blade.php',
    'konsultasi_tambah.php' => 'user/konsultasi_tambah.blade.php',
    'konsultasi_edit.php' => 'user/konsultasi_edit.blade.php',
    'psikolog_list.php' => 'user/psikolog_list.blade.php'
];

foreach ($view_map as $ci_view => $blade_view) {
    if (file_exists($source_dir . $ci_view)) {
        $content = convert_ci_to_blade(file_get_contents($source_dir . $ci_view));
        $header = "@extends('layouts.app')\n@section('content')\n";
        $footer = "\n@endsection\n";
        file_put_contents($target_views_dir . $blade_view, $header . $content . $footer);
        echo "Converted view: $ci_view\n";
    }
}
echo "Migration complete.\n";
