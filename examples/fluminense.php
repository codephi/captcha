<?php
include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->image([
    'maxElements' => 8,
    'background' => 'FF',
    'color' => 'FABE00',
    'elements' => ['polygon' => '0C4D19', 'rectangle' => 'A1001F']
]);
