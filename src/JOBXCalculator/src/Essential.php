<?php
/*
|--------------------------------------------------------------------------
| JOBXCalculator Essential
|--------------------------------------------------------------------------
|
| Tools
| @author Eduardo Castro <Skillerm>
| 2022-20-01
*/
namespace SkillerM\JOBXCalculator;

/**
 * Essential
 * @author Eduardo Castro <Skillerm>
 * @description: Class for calculating elobooster
 * @package SkillerM\JOBXCalculator
 * 
 */
class Essential
{

    public function __construct($lang)
    {
        require dirname(dirname(__FILE__)) . "../langs/" . $lang . ".php";
    }

    protected const DIVISIONS_THEAMOUNT = 4;

    public const LANGS = [
        "en-us",
        "pt-br"
    ];

    public const Types = [
        "eloboost",
        "duoboost"
    ];

    public function convertETN($a): int
    {
        switch ($a) {
            case 'iron':
                return 0;
            case 'bronze':
                return 1;
            case 'silver':
                return 2;
            case 'gold':
                return 3;
            case 'platinum':
                return 4;
            case 'diamond':
                return 5;
            case 'master':
                return 6;
            case 'grandmaster':
                return 7;
            case 'challenger':
                return 8;
            default:
                return 100;
        }
    }

    public function convertETN2($a): int
    {
        switch ($a) {
            case 'iron':
                return 0;
            case 'bronze':
                return 1;
            case 'silver':
                return 2;
            case 'gold':
                return 3;
            case 'platinum':
                return 4;
            case 'diamond':
                return 5;
            default:
                return 100;
        }
    }


    public function correctDIV($a, $b, $c, $d): bool
    {
        return $d > Essential::DIVISIONS_THEAMOUNT || $d == 0 || $c == 0 || $a == $b && ($c >= $d) ? true : false;
    }

    public function correctMFL($a)
    {
        switch ($a) {
            case 1:
                return 4;
            case 2:
                return 3;
            case 3:
                return 2;
            case 4:
                return 1;
        }
    }

    public function convertRTN($roman)
    {
        $romans = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        );
        $result = 0;
        foreach ($romans as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }
        return $result;
    }

    public function multiplyEnd($x, $y)
    {
        $z = 1;
        for ($x > $y; $x--;) {
            if ($x == $y) {
                break;
            }
            $z++;
        }
        return $z;
    }
}
