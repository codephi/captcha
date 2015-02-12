<?php
include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->image([
    'level' => 6,
    'total' => 10,
    'maxElements' => 100,
    'elements' => ['elipse' => false, 'polygon' => false, 'rectangle' => false]
]);
