<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$captcha = app('captcha');
session(['captcha' => [
    'key' => \Illuminate\Support\Facades\Hash::make('test'),
    'sensitive' => false,
]]);

var_dump(session('captcha.key'));
var_dump($captcha->check('test'));
