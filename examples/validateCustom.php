<?php
include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->options([
    'level' => 6,
    'fontFamily' => ['Open_Sans/OpenSans-Bold.ttf'],
    'code' => 'GgUuAaXxIiNnMm'
]);

if (!isset($_POST['captcha']))
    $captcha->image();
else
    echo json_encode($captcha->validate($_POST['captcha']));

