## About
A little about:
System for elojob price/period calculations.
"Any problem, or usage suggestion as per provided guides.


### Usage

Example:
For example usage see this: <a target="_blank" href="https://github.com/skillerm/elojobx-calculator/blob/main/test/api.php">Api</a> 

Available leagues and divisions:
```php
$Leagues = ["ferro","bronze","prata","ouro","platina","diamante","mestre","grao-mestre","desafiante"];
$Divisions = ["I","II","III","IV"];
$Services = ["eloboost", "duoboost"];
```
The API receives values like:

```php
currentelo: ferro
currentdivision: IV
desiredelo: diamante
desireddivision: III
row: solo/duo
service: eloboost
```

With this payload, the api returned exactly:
```json
{
   "Value":347,
   "Deadline":23,
   "SelectElo":"ferro",
   "ToElo":"diamante",
   "Service":"eloboost",
   "status":true,
   "Url":"http:\/\/localhost\/buy"
}
```

<b>"Value":347</b> It's the total amount, 347R$ | 347$....

*Edit the values in the Essential.php file

I didn't make the project fully public, because I don't know if there will be many people using it.
If you want me to rephrase this, ask in the issues tab
