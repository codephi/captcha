<?php
include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->image([
    'background' => 'FF',
    'color' => false,
    'elements' => ['elipse' => false],
    'maxElements' => 100
]);