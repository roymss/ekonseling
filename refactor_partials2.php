<?php
$dir = 'c:/laragon/www/ekonseling/ekonseling-laravel/resources/views/partials/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Convert $row[hari] to $row->hari
    $content = preg_replace('/\$([a-zA-Z0-9_]+)\[([a-zA-Z0-9_]+)\]/', '$$1->$2', $content);
    
    file_put_contents($file, $content);
    echo "Fixed array syntax in $file\n";
}
