<?php
/*
|--------------------------------------------------------------------------
| JOBXCalculator Exception
|--------------------------------------------------------------------------
|
| MyException class is used to handle exceptions.
| @author Eduardo Castro <Skillerm>
| 2022-20-01
*/

namespace SkillerM\JOBXCalculator;

class MyException extends \Exception
{

    public function __construct($code = 99, $lang = "en-us")
    {
        require dirname(dirname(__FILE__)) . "../langs/" . $lang . ".php";
        $this->Erros = $Erros;
        $this->code = $code;
    }

    public function errorDetails($error)
    {
        $Details = array(
            array("Code" => 0, "Message" => $this->Erros["0"]),
            array("Code" => 1, "Message" =>  $this->Erros["1"]),
            array("Code" => 2, "Message" =>  $this->Erros["2"]),
            array("Code" => 3, "Message" => $this->Erros["3"]),
            array("Code" => 4, "Message" => $this->Erros["4"]),
            array("Code" => 99, "Message" =>  $this->Erros["99"])
        );
        return array_search($error, array_column($Details, 'Code', "Message"));
    }


    /**
     * errorJOBX
     * @return array
     * @throws MyException
     * @author Eduardo Castro <Skillerm>
     */
    public function errorJOBX()
    {
        return array("Code" => $this->code, "Message" => $this->errorDetails($this->code));
    }
}
