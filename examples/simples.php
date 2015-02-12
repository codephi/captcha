<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

/*
$width = 200; // Tamanho horizontal da imagem.
$height = 100; // Tamanho vertical da imagem.
$fontSize = 50; // Tamanho da fonte dos caracteres.
$total = 4; //Quantidade de caracteres personalizada.
$background = "FFFFFF"; // Cor do background da image. (ATENÇÃO: Não existe cor aleatória para essa propriedade).
$color = false; //Cor dos caracteres, caso FALSE, a cor será aleatória.
$elements = ['elipse'=> false,'polygon' => false,'rectangle'=>false];// Tipos de desenhos e suas respectivas cores.
                                                                        Exemplo: ['elipse'=>false], gera um desenho
                                                                        tipo elipse de dimensão aleatória e com cor
                                                                        aleatória.

                                                                        ['polygon'=>'00FF00'], gera um desenho
                                                                        tipo polygon e dimensão aleatória e cor verde.

$maxElements = 10;// Número máximo de desenhos aleatórios.
$level = 3;// Nível do verificador. Quanto maior, maior e mais complexa é a quantidade e a variedade de caracteres.
$fontFamily = [ 'IndieFlower.ttf','OpenSans-Semibold.ttf']//Família de Fontes em seus respectivos sub-diretórios.
$fontsDir; //Diretório padrão das fontes (Padrão: "fonts").
$code'Gaxinim'; //Conjunto de caracteres personalizados.
 */

include '../lib/captcha.php';

$captcha = new Captcha();

$captcha->image();