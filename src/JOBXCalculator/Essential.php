<?php

namespace JOBXCalculator\JOBXCalculator;

class Essential
{

    protected const DIVISIONS_THEAMOUNT = 4;
    public const DEFAULT_JOBX_ELO = [
        array("elo" => "ferro",      "value" => 28,    "parcelado" => 7,   "prazo" => 1),
        array("elo" => "bronze",     "value" => 32,    "parcelado" => 8,   "prazo" => 1),
        array("elo" => "prata",      "value" => 48,    "parcelado" => 12,  "prazo" => 1),
        array("elo" => "ouro",       "value" => 60,    "parcelado" => 15,  "prazo" => 1),
        array("elo" => "platina",    "value" => 80,    "parcelado" => 20,  "prazo" => 1),
        array("elo" => "diamante",   "value" => 200,   "parcelado" => 50,  "prazo" => 2),
        array("elo" => "mestre",     "value" => 160,   "parcelado" => 0,   "prazo" => 4),
        array("elo" => "grao-mestre", "value" => 900,   "parcelado" => 0,   "prazo" => 7),
        array("elo" => "desafiante", "value" => 2000,  "parcelado" => 0,   "prazo" => 15)
    ];
    public const DEFAULT_JOBX_DUOBOOSTER = [
        array("elo" => "ferro",     "value" => 56,    "parcelado" => 14,  "prazo" => 1),
        array("elo" => "bronze",    "value" => 64,    "parcelado" => 16,  "prazo" => 1),
        array("elo" => "prata",     "value" => 96,    "parcelado" => 24,  "prazo" => 1),
        array("elo" => "ouro",      "value" => 120,   "parcelado" => 30,  "prazo" => 1),
        array("elo" => "platina",   "value" => 160,   "parcelado" => 40,  "prazo" => 1),
        array("elo" => "diamante",  "value" => 400,   "parcelado" => 100, "prazo" => 2)
    ];

    public function convertETN($a): int
    {
        switch ($a) {
            case 'ferro':
                return 0;
            case 'bronze':
                return 1;
            case 'prata':
                return 2;
            case 'ouro':
                return 3;
            case 'platina':
                return 4;
            case 'diamante':
                return 5;
            case 'mestre':
                return 6;
            case 'grao-mestre':
                return 7;
            case 'desafiante':
                return 8;
            default:
                return 100;
        }
    }

    public function convertETN2($a): int
    {
        switch ($a) {
            case 'ferro':
                return 0;
            case 'bronze':
                return 1;
            case 'prata':
                return 2;
            case 'ouro':
                return 3;
            case 'platina':
                return 4;
            case 'diamante':
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
