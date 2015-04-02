<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Captcha
 * por: Philippe Assis
 * https://github.com/PhilippeAssis/captcha
 */
class Captcha
{

    /**
     *  int $width
     *
     *  Tamanho horizontal da imagem.
     * */
    public $width = 220;

    /**
     *  int $height
     *
     *  Tamanho vertical da imagem.
     * */
    public $height = 80;

    /**
     * int $fontSize
     *
     * Tamanho da fonte dos caracteres.
     */
    public $fontSize = 30;
    /**
     * int $total
     *
     * Tamanho da fonte dos caracteres.
     * */
    public $total;

    /***
     * string $background
     *
     * Quantidade de caracteres personalizada.
     * */
    public $background = "FFFFFF";

    /**
     * bool string $color
     *
     * Cor do background da image. (ATENÇÃO: Não existe cor aleatória para essa propriedade).
     * */
    public $color = false; // Cor dos caracteres, caso FALSE, a cor será aleatória.

    /**
     * array $elements;
     *
     * Tipos de desenhos e suas respectivas cores.
     * Exemplo: ['elipse'=>false], gera um desenho
     * tipo elipse de dimensão aleatória e com cor aleatória.
     * ['polygon'=>'00FF00'], gera um desenho tipo polygon e dimensão aleatória e cor verde.
     *
     * */
    public $elements = [
        'elipse' => false,
//            'polygon' => false,
//            'rectangle'=>false
    ];

    /**
     * int $maxElements
     *
     * Número máximo de desenhos aleatórios.
     * */
    public $maxElements = 10;

    /**
     * int $level
     *
     * Nível do verificador. Quanto maior, maior e mais complexa é a quantidade e a variedade de caracteres.
     * Vai de 1 a 6
     * */
    public $level = 3;

    /**
     * array $fontFamily
     *
     * Família de Fontes em seus respectivos sub-diretórios.
     * */
    public $fontFamily = ['Indie_Flower/IndieFlower.ttf', 'Permanent_Marker/PermanentMarker.ttf', 'Open_Sans/OpenSans-Bold.ttf', 'Open_Sans/OpenSans-Semibold.ttf'];

    /**
     * string $fontsDir
     *
     * Diretório padrão das fontes (Padrão: "fonts").
     * */
    public $fontsDir;

    /**
     * string $code
     *
     * Conjunto de caracteres personalizados.
     * */
    public $code;

    /**
     * array $codes
     *
     * Conjunto de caracteres.
     * */
    public $codes = [
        "0123456789",//1
        "ABCDEFGHIJKLMNPQRSTUVYXWZ",//2
        "ABCDEFGHIJKLMNPQRSTUVYXWZ0123456789",//3
        "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789",//4
        "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789",//5
        "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789",//6
    ];

    /**
     * bool $case
     *
     * Caso true, aceita caracteres minusculos ou maiusculos como entrada válida na validação.
     * */
    public $case = false;

    /**
     * string int $captcha
     *
     * Contém o valor do captcha na sessão. O mesmo que $_SESSION['captcha'];
     * */
    protected $captcha;

    /**
     * resource $image
     *
     * Contém a imagem.
     * */
    private $image;

    /**
     * array $position
     *
     * Posição inicial do texto.
     * */
    private $position;

    /**
     * array $fontFamilyCount
     *
     * Quantidade de fonts declaradas.
     * */
    private $fontFamilyCount;


    /**
     * @param string $fontsDir
     */
    public function __construct($fontsDir = 'fonts')
    {
        session_start();
        $this->fontsDir = $fontsDir;
        if (isset($_SESSION['captcha']))
            $this->captcha = $_SESSION['captcha'];
    }


    /**
     * Crian um código aleatório para o captcha.
     */
    function sessionCode()
    {
        if ($this->code) {
            $code = $this->code;
            if (!$this->total)
                $this->total = $this->level + 1;
        } else {
            $code = $this->codes[$this->level - 1];
            if (!$this->total)
                $this->total = ($this->level + 1) > 3 ? ($this->level + 1) : 3;
        }

        $this->captcha = substr(str_shuffle($code), 0, ($this->total));
        $_SESSION["captcha"] = $this->captcha;
        $_SESSION["level"] = $this->level;
    }

    /**
     * param bool $options
     *
     * Gera a imagem do captcha.
     */
    public function image($options = false)
    {
        $this->mergeOptions($options);
        $this->sessionCode();
        $this->position();
        $this->fontFamilyCount = count($this->fontFamily);
        $this->backgroundColor();
        $this->imageRandom();
        $this->fontColor();

        for ($i = 1; $i <= $this->total; $i++)
            imagettftext(
                $this->image,
                $this->fontSize,
                rand(-25, 25),
                $this->position[0] + ($this->fontSize * $i),
                $this->position[1],
                $this->color ? $this->color : $this->randomColor(),
                $this->randomFont(),
                substr($this->captcha, ($i - 1), 1)
            );

        header("Content-type: image/jpeg");
        imagejpeg($this->image);
        imagedestroy($this->image);
    }

    /**
     * @return string
     *
     * Definia a fonte do caracter, a partir do level indicado.
     */
    public function randomFont()
    {
        if ($this->level > 0 and $this->level <= 3 and $this->fontFamilyCount < 2)
            $rand = rand(0, 1);
        else
            $rand = rand(1, $this->fontFamilyCount) - 1;

        return $this->fontsDir . DIRECTORY_SEPARATOR . $this->fontFamily[$rand];
    }

    /**
     * Gera os elementos ativados de modo aleatório.
     */
    public function imageRandom()
    {

        if ($this->maxElements)
            $max = ($this->maxElements / count($this->elements));
        else
            $max = 2 + $this->level;

        for ($i = 1; $i <= rand(1, $max); $i++)
            $this->addElements();
    }


    /**
     *  Verifica os elementos ativados e chama os seus respectivos metodos
     */
    public function addElements()
    {
        foreach ($this->elements as $key => $value) {
            if (!$value)
                $color = $this->randomColor();
            else {
                $color = $this->hex2RGB($value);
                $color = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
            }

            $this->$key($color);
        }
    }

    /**
     * @param $color
     */
    public function elipse($color)
    {
        imagearc($this->image, rand(0, $this->width), rand(0, $this->height), rand(5, 50), rand(5, 50), rand(0, 360),
            rand(10,
                360), $color);
    }

    /**
     * @param $color
     */
    public function polygon($color)
    {
        $points = rand(6, 12);
        $polygon = [];
        for ($i = 1; $i <= $points; $i++)
            $polygon[] = (rand(1, 24) * 10);

        imagefilledpolygon($this->image, $polygon, $points / 2, $color);
    }

    /**
     * @param $color
     */
    public function rectangle($color)
    {
        $x = rand(0, $this->width);
        $y = rand(0, $this->height);
        imagefilledrectangle($this->image, $x, $y, rand($x, $x + 100), rand($y, $y + 100), $color);
    }

    /**
     * Declara a posição inivial do texto.
     */
    public function position()
    {
        $baseSize = $this->total * $this->fontSize;

        if ($baseSize >= ($this->width - $baseSize))
            $this->width += $baseSize;

        if ($this->fontSize >= ($this->height - $this->fontSize))
            $this->height += $this->fontSize;

        $x = rand(0, ($this->width - $baseSize - $this->fontSize));
        $y = rand($this->fontSize, ($this->height - ($this->fontSize / 3)));

        $this->position = [$x, $y];
    }

    public function options($options)
    {
        $this->mergeOptions($options);
    }

    /**
     * @param $options
     *
     * Mistura as opções.
     */
    public function mergeOptions($options)
    {
        if ($options)
            foreach ($options as $key => $value)
                $this->$key = $value;

    }

    /**
     * Define a cor do background.
     */
    public function backgroundColor()
    {
        if (strpos($this->background, ',') === false)
            $this->background = $this->hex2RGB($this->background);
        else
            $this->background = explode(',', $this->background);

        $this->image = imagecreate($this->width, $this->height);
        imagecolorallocate($this->image, $this->background[0], $this->background[1], $this->background[2]);
    }

    /**
     * Define as cores do texto
     */
    public function fontColor()
    {
        if ($this->color) {
            if (strpos($this->color, ',') === false)
                $this->color = $this->hex2RGB($this->color);
            else
                $this->color = explode(',', $this->color);

            $this->color = imagecolorallocate($this->image, $this->color[0], $this->color[1], $this->color[2]);
        }
    }


    /**
     * @param $hex
     * @return array|bool
     *
     * Converte hexadecial para RGB e divide em um array
     */
    public function hex2RGB($hex)
    {

        if (strlen($hex) == 6)
            list($r, $g, $b) = array($hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5]);
        elseif (strlen($hex) == 3)
            list($r, $g, $b) = array($hex[0] . $hex[1], $hex[2] . $hex[0], $hex[1] . $hex[2]);
        else if (strlen($hex) == 2)
            list($r, $g, $b) = array($hex[0] . $hex[1], $hex[0] . $hex[1], $hex[0] . $hex[1]);
        else if (strlen($hex) == 1)
            list($r, $g, $b) = array($hex[0] . $hex[0], $hex[0] . $hex[0], $hex[0] . $hex[0]);
        else
            return false;

        $color = [];
        $color[] = hexdec($r);
        $color[] = hexdec($g);
        $color[] = hexdec($b);

        return $color;
    }

    /**
     * @return int
     *
     * Gera uma cor alearótia tentando não oculta-la caso o background seja muito claro ou muito escuro.
     */
    public function randomColor()
    {
        $rgb = [rand(0, 255), rand(0, 255), rand(0, 255)];

        if (array_sum($this->background) < 510)
            $rgb[rand(0, 2)] = 255;
        elseif (array_sum($this->background) > 510)
            $rgb[rand(0, 2)] = 0;

        return imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]);
    }

    public function validate($code)
    {
        if ($this->level <= 3 or $this->case) {
            $code = strtoupper($code);
            $this->captcha = strtoupper($this->captcha);
        }

        if ($code == $this->captcha) {
            $this->sessionCode();
            return true;
        }

        $this->sessionCode();
        return false;
    }
}