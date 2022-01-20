<?php
require "../src/JOBXCalculator/JOBXCalculator.php";

use SkillerM\JOBXCalculator\{JOBXCalculator, MyException};

try {

    /**
     * DuoBoost
     * @var array
     * @author Eduardo Castro <Skillerm>
     * @desc DuoBoost is an array with the elo and the value of the elo 
     * (It must have 6 values).
     * @param elo:  Elo Name
     * @param value: Price of the elo, R$, USD, etc.
     * @param installments: Number of installments
     * @param deadline: Number of days to finalize the service
     */
    $DuoBoost = [
        array("elo" => "iron",      "value" => 56,    "installments" => 14,  "deadline" => 1),
        array("elo" => "bronze",    "value" => 64,    "installments" => 16,  "deadline" => 1),
        array("elo" => "silver",    "value" => 96,    "installments" => 24,  "deadline" => 1),
        array("elo" => "gold",      "value" => 120,   "installments" => 30,  "deadline" => 1),
        array("elo" => "platinum",  "value" => 160,   "installments" => 40,  "deadline" => 1),
        array("elo" => "diamond",   "value" => 400,   "installments" => 100, "deadline" => 2)
    ];

    /**
     * EloCalculator JOBXCalculator
     * @var JOBXCalculator
     * @author Eduardo Castro <Skillerm>
     * @param lang: Language (en-us, pt-br)
     * @param service: Service name (eloboost, duoboost)
     * @param table: Table of the service (Array[elo, value, installments, deadline])
     * @param currentleague: Current league (iron, bronze, silver...)
     * @param currentdivision: Current division (I, II, III, IV)
     * @param desiredleague: Desired league ( desiredleague > currentleagueiron AND bronze, silver...)
     * @param desireddivision: Desired division  (I, II, III, IV)
     */
    $EloCalculator = new JOBXCalculator([
        "lang" => "en-us",
        "service" => "duoboost",
        "table" => $DuoBoost,
        "currentleague" => "bronze",
        "currentdivision" => "I",
        "desiredleague" => "diamond",
        "desireddivision" => "III",
    ]);

    var_dump(

        /**
         * Values
         * @var array
         * @author Eduardo Castro <Skillerm>
         * @param value: USD, R$, etc.
         * @param deadline: Number of days to finalize the service
         * @param currentleague: Current league (iron, bronze, silver...)
         * @param desiredleague : Desired league (iron, bronze, silver...)
         * @param service: Service name (eloboost, duoboost)
         * @param status: Boolean
         */
        $EloCalculator->Values()
    );
} catch (MyException $e) {

    var_dump(

        /**
         * ErrorJOBX
         * @var array
         * @author Eduardo Castro <Skillerm>
         * @param error: Error message
         * @param status: Boolean
         */
        $e->errorJOBX()
    );
}
