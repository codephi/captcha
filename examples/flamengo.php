<?php
include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->image([
    'maxElements' => 8,
    'background' => '00',
    'color' => 'FF',
    'elements' => ['elipse' => 'CF0000', 'rectangle' => 'CF0000']
]);
