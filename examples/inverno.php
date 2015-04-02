<?php
include '../captcha.php';

$captcha = new Captcha();

$captcha->image([
    'background' => 'D1DFDF',
    'color' => '676767',
    'elements' => ['elipse' => 'FF']
]);
