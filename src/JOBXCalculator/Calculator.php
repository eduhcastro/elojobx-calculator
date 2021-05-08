<?php
namespace JOBXCalculator\JOBXCalculator;

class Calculator
{
    protected const DIVISIONS_THEAMOUNT = 4;
    protected const ELO_ERROR = 100;
    protected const DONT_HAVE_DIVISIONS = ['mestre', 'grao-mestre', 'desafiante'];

    protected $TotalV = 0; // Value Price Total
    protected $TotalD = 0; // Deadline Total
    protected $StartS = false; // Start Calculator
    protected $VallCD = 0; // Value Divisions Courrent
    protected $VallDD = 0; // Value Divisions Disered
    

    public function __construct($options)
    {
        $this->currentElo = $options['ligaatual'];
        $this->desiredElo = $options['ligadesejada'];
        $this->currentDivision = $options['divisaoatual'];
        $this->desiredDivision = $options['divisaodesejada'];
    }

    protected function necessaryTools()
    {
        return new Essential();
    }

    public function setJOBX($z)
    {
        return $this->DEFAULT_JOBX = $z;
    }

    protected function securityTesting()
    {
        if ($this->typeCalculate == 'duoboost' && ($this->necessaryTools()
            ->convertETN2($this->currentElo) > $this->necessaryTools()
            ->convertETN2($this->desiredElo) || $this->necessaryTools()
            ->convertETN2($this->currentElo) == Calculator::ELO_ERROR || $this->necessaryTools()
            ->convertETN2($this->desiredElo) == Calculator::ELO_ERROR))
        {
            throw new MyException(0);
        }
        if ($this->typeCalculate != 'duoboost' && ($this->necessaryTools()
            ->convertETN($this->currentElo) > $this->necessaryTools()
            ->convertETN($this->desiredElo) || $this->necessaryTools()
            ->convertETN($this->currentElo) == Calculator::ELO_ERROR || $this->necessaryTools()
            ->convertETN($this->desiredElo) == Calculator::ELO_ERROR || ($this->necessaryTools()
            ->correctDIV($this->currentElo, $this->desiredElo, $this->necessaryTools()
            ->convertRTN($this->desiredDivision) , $this->necessaryTools()
            ->convertRTN($this->currentDivision)))))
        {

            throw new MyException(0);

        }

        if (!is_array($this->DEFAULT_JOBX) || $this->typeCalculate == 'eloboost' && (count($this->DEFAULT_JOBX) < 9) || $this->typeCalculate == 'duoboost' && (count($this->DEFAULT_JOBX) < 6))
        {
            $error = !is_array($this->DEFAULT_JOBX) ?? 69;
            $error = $error != 69 ? 2 : 1;
            //$error = $error != 69 ? ($this->typeCalculate == 'elo' && count($this->DEFAULT_JOBX) < 9 ? 2 : 69) : 1;
            throw new MyException($error);
        }
    }

    public function calculateBooster()
    {

        $this->securityTesting();

        foreach ($this->DEFAULT_JOBX as $Elo)
        {

            if (!$this->StartS && $Elo["elo"] === $this->currentElo)
            {
                if (in_array(strtolower($this->currentElo) , Calculator::DONT_HAVE_DIVISIONS, true))
                {

                    $this->VallCD = $Elo["value"];
                    $ValorPorPrazoY = $Elo["prazo"];

                }
                else
                {
                    $this->VallCD = $Elo["parcelado"] * $this->necessaryTools()
                        ->convertRTN($this->currentDivision) - 1;
                    $ValorPorPrazoY = $Elo["prazo"] * $this->necessaryTools()
                        ->convertRTN($this->currentDivision) - 1;

                }
                $this->StartS = true;
            }

            if ($this->StartS && ($Elo["elo"] != $this->desiredElo) && ($Elo["elo"] != $this->currentElo))
            {
                $this->TotalV += $Elo["value"];
                if (in_array(strtolower($Elo["elo"]) , Calculator::DONT_HAVE_DIVISIONS, true))
                {
                    $this->TotalD += $Elo["prazo"];
                }
                else
                {
                    $this->TotalD += $Elo["prazo"] * Calculator::DIVISIONS_THEAMOUNT;
                }
            }

            if ($this->StartS && $Elo["elo"] === $this->desiredElo)
            {
                if (in_array(strtolower($this->desiredElo) , Calculator::DONT_HAVE_DIVISIONS, true))
                {
                    $this->VallDD = $Elo["value"];
                    $ValorPorPrazoX = $Elo["prazo"];
                }
                else
                {
                    $this->VallDD = $Elo["parcelado"] * $this->necessaryTools()
                        ->correctMFL($this->necessaryTools()
                        ->convertRTN($this->desiredDivision));
                    $ValorPorPrazoX = $Elo["prazo"] * $this->necessaryTools()
                        ->correctMFL($this->necessaryTools()
                        ->convertRTN($this->desiredDivision));

                }
                if ($this->currentElo == $this->desiredElo)
                {

                    $this->TotalV = $Elo["parcelado"] * $this->necessaryTools()
                        ->multiplyEnd($this->necessaryTools()
                        ->convertRTN($this->currentDivision) , $this->necessaryTools()
                        ->convertRTN($this->desiredDivision));

                }
                else
                {
                    $this->TotalV += ($this->VallDD + $this->VallCD);
                }

                $this->TotalD += $ValorPorPrazoY + $ValorPorPrazoX;
                $this->StartS = false;
            }
        }
    }

}

class EloBooster extends Calculator
{

    public $DEFAULT_JOBX = Essential::DEFAULT_JOBX_ELO;

    public function startBooster()
    {
        $this->typeCalculate = 'eloboost';
        $this->calculateBooster();
        return array(
            "Value" => $this->TotalV,
            "Deadline" => $this->TotalD,
            "SelectElo" => $this->currentElo,
            "ToElo" => $this->desiredElo,
            "Service" => $this->typeCalculate,
            "status" => true,
            "Url" => "http://localhost/buy"
        );
    }

}
class DuoBooster extends Calculator
{

    protected $DEFAULT_JOBX = Essential::DEFAULT_JOBX_DUOBOOSTER;

    public function startBooster()
    {
        $this->typeCalculate = 'duoboost';
        $this->calculateBooster();
        return array(
            "Value" => $this->TotalV,
            "Deadline" => $this->TotalD,
            "SelectElo" => $this->currentElo,
            "ToElo" => $this->desiredElo,
            "Service" => $this->typeCalculate,
            "status" => true,
            "Url" => "http://localhost/buy"
        );
    }

}

