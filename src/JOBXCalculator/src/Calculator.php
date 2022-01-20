<?php
/*
|--------------------------------------------------------------------------
| JOBXCalculator Calculator
|--------------------------------------------------------------------------
|
| Calculation script
| @author Eduardo Castro <Skillerm>
| 2022-20-01
*/

namespace SkillerM\JOBXCalculator;


class Calculator
{
    protected const DIVISIONS_THEAMOUNT = 4;
    protected const ELO_ERROR = 100;
    protected const DONT_HAVE_DIVISIONS = ['master', 'grandmaster', 'challenger'];

    private $TotalV = 0; // Value Price Total
    private $TotalD = 0; // Deadline Total
    private $StartS = false; // Start Calculator
    private $VallCD = 0; // Value Divisions Courrent
    private $VallDD = 0; // Value Divisions Disered


    public function __construct($options)
    {
        $this->lang = $options["lang"];
        $this->typeCalculate = $options['service'];

        require dirname(dirname(__FILE__)) . "../langs/" . $options['lang'] . ".php";

        $this->currentElo = $options['currentleague'];
        $this->desiredElo = $options['desiredleague'];
        $this->currentDivision = $options['currentdivision'];
        $this->desiredDivision = $options['desireddivision'];
        $this->setJOBX($options['table']);
        $this->calculateBooster();
    }


    private function necessaryTools()
    {
        return new Essential($this->lang);
    }

    private function setJOBX($z)
    {
        return $this->DEFAULT_JOBX = $z;
    }

    private function securityTesting()
    {

        if (array_search($this->lang, Essential::LANGS) === false) {
            throw new MyException(3);
        }

        if (array_search($this->typeCalculate, Essential::Types) === false) {
            throw new MyException(4);
        }

        if ($this->typeCalculate == "eloboost" && count($this->DEFAULT_JOBX) != 9) {
            throw new MyException(1);
        }

        if ($this->typeCalculate == "duoboost" && count($this->DEFAULT_JOBX) != 6) {
            throw new MyException(1);
        }


        if ($this->typeCalculate == 'duoboost' && ($this->necessaryTools()
            ->convertETN2($this->currentElo) > $this->necessaryTools()
            ->convertETN2($this->desiredElo) || $this->necessaryTools()
            ->convertETN2($this->currentElo) == Calculator::ELO_ERROR || $this->necessaryTools()
            ->convertETN2($this->desiredElo) == Calculator::ELO_ERROR)) {
            throw new MyException(0);
        }
        if ($this->typeCalculate != 'duoboost' && ($this->necessaryTools()
            ->convertETN($this->currentElo) > $this->necessaryTools()
            ->convertETN($this->desiredElo) || $this->necessaryTools()
            ->convertETN($this->currentElo) == Calculator::ELO_ERROR || $this->necessaryTools()
            ->convertETN($this->desiredElo) == Calculator::ELO_ERROR || ($this->necessaryTools()
                ->correctDIV($this->currentElo, $this->desiredElo, $this->necessaryTools()
                    ->convertRTN($this->desiredDivision), $this->necessaryTools()
                    ->convertRTN($this->currentDivision))))) {
            throw new MyException(0);
        }

        if (!is_array($this->DEFAULT_JOBX) || $this->typeCalculate == 'eloboost' && (count($this->DEFAULT_JOBX) < 9) || $this->typeCalculate == 'duoboost' && (count($this->DEFAULT_JOBX) < 6)) {
            $error = !is_array($this->DEFAULT_JOBX) ?? 69;
            $error = $error != 69 ? 2 : 1;
            //$error = $error != 69 ? ($this->typeCalculate == 'elo' && count($this->DEFAULT_JOBX) < 9 ? 2 : 69) : 1;
            throw new MyException($error);
        }
    }

    private function calculateBooster()
    {

        $this->securityTesting();

        foreach ($this->DEFAULT_JOBX as $Elo) {

            if (!$this->StartS && $Elo["elo"] === $this->currentElo) {
                if (in_array(strtolower($this->currentElo), Calculator::DONT_HAVE_DIVISIONS, true)) {

                    $this->VallCD = $Elo["value"];
                    $ValorPorPrazoY = $Elo["deadline"];
                } else {
                    $this->VallCD = $Elo["installments"] * $this->necessaryTools()
                        ->convertRTN($this->currentDivision) - 1;
                    $ValorPorPrazoY = $Elo["deadline"] * $this->necessaryTools()
                        ->convertRTN($this->currentDivision) - 1;
                }
                $this->StartS = true;
            }

            if ($this->StartS && ($Elo["elo"] != $this->desiredElo) && ($Elo["elo"] != $this->currentElo)) {
                $this->TotalV += $Elo["value"];
                if (in_array(strtolower($Elo["elo"]), Calculator::DONT_HAVE_DIVISIONS, true)) {
                    $this->TotalD += $Elo["deadline"];
                } else {
                    $this->TotalD += $Elo["deadline"] * Calculator::DIVISIONS_THEAMOUNT;
                }
            }

            if ($this->StartS && $Elo["elo"] === $this->desiredElo) {
                if (in_array(strtolower($this->desiredElo), Calculator::DONT_HAVE_DIVISIONS, true)) {
                    $this->VallDD = $Elo["value"];
                    $ValorPorPrazoX = $Elo["deadline"];
                } else {
                    $this->VallDD = $Elo["installments"] * $this->necessaryTools()
                        ->correctMFL($this->necessaryTools()
                            ->convertRTN($this->desiredDivision));
                    $ValorPorPrazoX = $Elo["deadline"] * $this->necessaryTools()
                        ->correctMFL($this->necessaryTools()
                            ->convertRTN($this->desiredDivision));
                }
                if ($this->currentElo == $this->desiredElo) {

                    $this->TotalV = $Elo["installments"] * $this->necessaryTools()
                        ->multiplyEnd($this->necessaryTools()
                            ->convertRTN($this->currentDivision), $this->necessaryTools()
                            ->convertRTN($this->desiredDivision));
                } else {
                    $this->TotalV += ($this->VallDD + $this->VallCD);
                }

                $this->TotalD += $ValorPorPrazoY + $ValorPorPrazoX;
                $this->StartS = false;
            }
        }
    }

    public function Values()
    {
        return [
            "value" => $this->TotalV,
            "deadline" => $this->TotalD,
            "currentleague" => $this->currentElo,
            "desiredleague" => $this->desiredElo,
            "service" => $this->typeCalculate,
            "status" => true,
        ];
    }
}

/**
 * JOBXCalculator
 * @description: Class for calculating elobooster
 * @author Eduardo Castro <Skillerm>
 */
class JOBXCalculator
{

    /**
     * Constructor
     * @description: Initialize the class, sets all parameters
     * @param mixed $Opts
     * @example: $Opts = [
     * "lang" => "en-us",
     * "service" => "eloboost",
     * "table" => Array[],
     * "currentleague" => "bronze",
     * "currentdivision" => "I",
     * "desiredleague" => "diamond",
     * "desireddivision" => "III"
     * ]
     * @return void
     * @author Eduardo Castro <Skillerm>
     */
    public function __construct($Opts)
    {

        /*-- Set lang --*/
        $Opts["lang"] = $Opts["lang"] ?? "en-us";

        /*-- Set service --*/
        $Opts["service"] = $Opts["service"] ?? "eloboost";

        /*-- Set table --*/
        $Opts["table"] = $Opts["table"] ?? [];

        /*-- Set current league --*/
        $Opts["currentleague"] = $Opts["currentleague"] ?? null;

        /*-- Set current division --*/
        $Opts["currentdivision"] = $Opts["currentdivision"] ?? null;

        /*-- Set desired league --*/
        $Opts["desiredleague"] = $Opts["desiredleague"] ?? null;

        /*-- Set desired division --*/
        $Opts["desireddivision"] = $Opts["desireddivision"] ?? null;

        /*-- Set current elo --*/
        $Calculator = new Calculator($Opts);

        /*-- Set Values to return --*/
        $this->Values = $Calculator->Values();
    }

    /**
     * Values
     * @description: Returns the values of the calculator
     * @return array
     * @param value: It's the value, 10R$, 10$...
     * @param deadline: It's the deadline, 10 days, 10 weeks, 10 months...
     * @example: [
     * "value" => 0,
     * "deadline" => 0,
     * "currentleague" => "bronze",
     * "desiredleague" => "diamond",
     * "service" => "eloboost",
     * "status" => true
     * ]
     * @author Eduardo Castro <Skillerm>
     */
    public function Values()
    {
        return $this->Values;
    }
}