<?php
include '../captcha.php';

$captcha = new Captcha();

$captcha->image([
    'maxElements' => 6,
    'elements' => [
        'elipse' => false,
        'polygon' => false,
        'rectangle' => false
    ]
]);