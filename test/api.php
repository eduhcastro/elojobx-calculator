<?php
header('Content-Type: application/json; charset=utf-8');
$ParamsActual = ["atualelo" => "ferro", "atualdivisao" => "IV"];
$ParamsDesejo = ["deseelo" => "diamante", "desedivisao" => "III"];
$More = ["Fila" => "solo/duo", "servico" => "eloboost"];

require "../src/JOBXCalculator/Calculator.php";
require "../src/JOBXCalculator/Essential.php";
require "../src/JOBXCalculator/Exception.php";

use JOBXCalculator\JOBXCalculator\{DuoBooster, EloBooster, MyException};

const SERVICES = ["eloboost", "duoboost", "md10"];

$Parameters = array(
    'servico' =>          $More["servico"],
    'ligaatual' =>        $ParamsActual["atualelo"],
    'divisaoatual' =>     $ParamsActual["atualdivisao"],
    'ligadesejada' =>     $ParamsDesejo["deseelo"],
    'divisaodesejada' =>  $ParamsDesejo["desedivisao"],
);

if (!in_array(strtolower($More["servico"]), SERVICES, true)) {
    $Error = array("Code" => 4, "Mensagem" => 'Servico invalido');
    echo json_encode($Error);
    exit;
}

if ($Parameters["servico"] == 'duoboost') {
    $CalculateElo = new DuoBooster($Parameters);
}
if ($Parameters["servico"] == 'eloboost') {
    $CalculateElo = new EloBooster($Parameters);
}
if ($Parameters["servico"] == 'md10') {
    //$CalculateElo = new DuoBooster($Parameters);
}


try {

    $Resultados = $CalculateElo->startBooster();

    echo json_encode($Resultados);

    /**
     * @return array
     * @example: {"Value":347,"Deadline":23,"SelectElo":"ferro","ToElo":"diamante","Service":"eloboost","status":true,"Url":"http:\/\/localhost\/buy"}
     */
} catch (MyException $e) {
    echo json_encode($e->errorJOBX());
}
