<?php
include '../captcha.php';

$captcha = new Captcha();

$captcha->image([
    'background' => '00',
    'color' => 'FF',
    'elements' => ['elipse' => 'FF']
]);