## About
A little about:
System for elojob price/period calculations.
"Any problem, or usage suggestion as per provided guides.


### Usage

Example:
For example usage see this: <a target="_blank" href="https://github.com/skillerm/elojobx-calculator/tree/main/test">Apis</a> 

Available leagues,divisions and services:
```php
$Leagues = ["iron","bronze","silver","gold","platinum","diamond","master","grandmaster","challenger"];
$Divisions = ["I","II","III","IV"];
$Services = ["eloboost", "duoboost"];
```
To start, define your price table, deadlines.

```php
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
```

Then instantiate the class
```php
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
```


With this payload, the api returned exactly:
```json
{
   "value":295,
   "deadline":16,
   "currentleague":"bronze",
   "desiredleague":"diamond",
   "service":"eloboost",
   "status":true,
}
```

Every contribution is welcome!
