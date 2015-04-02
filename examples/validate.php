<?php
include '../captcha.php';

$captcha = new Captcha();


if (!isset($_POST['captcha']))
    $captcha->image([
        'level' => 2
    ]);
else
    echo json_encode($captcha->validate($_POST['captcha']));