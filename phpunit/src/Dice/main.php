<?php

namespace Mos\Dice;

require __DIR__.'/../../vendor/autoload.php';

$num = 5;

$hand = new DiceHand();
for ($i = 1; $i <= $num; ++$i) {
    if (1 === $i % 2) {
        $hand->Add(new DiceGraphic());
    } else {
        $hand->Add(new Dice());
    }
}

$hand->roll();

echo 'The number of dices are: '.$hand->getNumberDices()."\n";

$dice = $hand->getString();
foreach ($dice as $dieStr) {
    echo $dieStr.' ';
}
echo "\n";
