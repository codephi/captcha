<?php
include '../captcha.php';

$captcha = new Captcha('fonts');

$captcha->image([
    'fontFamily' => ['Indie_Flower/IndieFlower.ttf', 'Open_Sans/OpenSans-Semibold.ttf'],
    'fontSize' => '60',
    'color' => false,
    'elements' => false
]);