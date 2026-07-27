<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$captcha = app('captcha');
$value = 'test';
$sessionKey = \Illuminate\Support\Facades\Hash::make('test');
session(['captcha.key' => $sessionKey]);

var_dump(captcha_check($value));
