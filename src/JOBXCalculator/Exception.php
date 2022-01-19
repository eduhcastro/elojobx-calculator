<?php


namespace JOBXCalculator\JOBXCalculator;

class MyException extends \Exception
{

    public function __construct($code = 99)
    {
        $this->code = $code;
    }

    protected function errorDetails($error)
    {
        $Details = array(
            array("Code" => 0, "Mensagem" => "Elo Invalido!"),
            array("Code" => 1, "Mensagem" => "Forneça uma tabela (Arrays) valida"),
            array("Code" => 2, "Mensagem" => "Sua tabela deve ter no minimo 9 Elos"),
            array("Code" => 99, "Mensagem" => "Desconhecido")
        );
        return array_search($error, array_column($Details, 'Code', "Mensagem"));
    }


    public function errorJOBX()
    {
        return array("Code" => $this->code, "Mensagem" => $this->errorDetails($this->code));
    }
}
