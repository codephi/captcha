<?php
include '../lib/captcha.php';

$captcha = new Captcha('fonts');

if (!isset($_POST['captcha']))
    $captcha->image([
        'level' => 5,
        'total' => 4,
        'fontFamily' => ['Open_Sans/OpenSans-Bold.ttf']
    ]);
else
    echo json_encode($captcha->validate($_POST['captcha']));

