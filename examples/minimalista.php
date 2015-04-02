<?php
include '../captcha.php';

$captcha = new Captcha();

$captcha->image([
    'maxElements' => 6,
    'elements' => ['elipse' => 33],
    'maxElements' => 1,
    'color' => 33,
    'fontSize' => 14,
    'width' => 80,
    'height' => 30,
    'total' => 3,
    'level' => 1
]);