<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

session(['captcha' => [
    'key' => \Illuminate\Support\Facades\Hash::make('test'),
    'sensitive' => false,
]]);

var_dump(session()->has('captcha'));
var_dump(captcha_check('test'));
