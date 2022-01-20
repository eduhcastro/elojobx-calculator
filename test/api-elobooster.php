<?php
require "../src/JOBXCalculator/JOBXCalculator.php";

use SkillerM\JOBXCalculator\{JOBXCalculator, MyException};

try {

    /**
     * EloBoost
     * @var array
     * @author Eduardo Castro <Skillerm>
     * @desc EloBoost is an array with the elo and the value of the elo 
     * (It must have 9 values).
     * @param elo:  Elo Name
     * @param value: Price of the elo, R$, USD, etc.
     * @param installments: Number of installments
     * @param deadline: Number of days to finalize the service
     */
    $EloBoost = [
        array("elo" => "iron",      "value" => 28,     "installments" => 7,   "deadline" => 1),
        array("elo" => "bronze",    "value" => 32,     "installments" => 8,   "deadline" => 1),
        array("elo" => "silver",    "value" => 48,     "installments" => 12,  "deadline" => 1),
        array("elo" => "gold",      "value" => 60,     "installments" => 15,  "deadline" => 1),
        array("elo" => "platinum",  "value" => 80,     "installments" => 20,  "deadline" => 1),
        array("elo" => "diamond",   "value" => 200,    "installments" => 50,  "deadline" => 2),
        array("elo" => "master",    "value" => 160,    "installments" => 0,   "deadline" => 4),
        array("elo" => "grandmaster", "value" => 900,   "installments" => 0,   "deadline" => 7),
        array("elo" => "challenger", "value" => 2000,  "installments" => 0,   "deadline" => 15)
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
        "service" => "eloboost",
        "table" => $EloBoost,
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
