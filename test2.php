<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$captcha = app('captcha');
$img = $captcha->create('default', true); // true = api mode, returns array
var_dump($img);
var_dump(session('captcha.key'));
var_dump(\Illuminate\Support\Facades\Hash::check($img['key'], session('captcha.key')));
var_dump($captcha->check($img['key']));
