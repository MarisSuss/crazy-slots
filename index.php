<?php
use App\Field;
use App\Conditions;
use App\Player;
use App\Signs;

require_once 'app/Signs.php';
require_once 'app/Field.php';
require_once 'app/Conditions.php';
require_once 'app/Player.php';
// Autoloader? Never heard of it

// Greeting #1
echo str_repeat('$', 25) . PHP_EOL;
echo "Welcome to crazy slots!!!\n";
echo str_repeat('$', 25). PHP_EOL;

// Login
$name =(string) readline('Please enter user name: ');
$player = new Player($name);
echo "Welcome {$player->getName()}!\n";

// Simulates loading for more immersive experience
echo "Loading...\n";
sleep(2);

// Game
$field = new Field();
$pullFee = 100;

while (true)
{
    // Menu screen
    echo PHP_EOL;
    echo "Lucky {$player->getName()}'s balance is {$player->getBalance()} {$player->getNominal()}\n";
    echo "|1| Add money\n";
    echo "|2| Play the game\n";
    echo "|3| Info\n";
    echo "|4| Exit\n";

    $menuChoice = (int) readline('Option: ');

        // Add money
    if($menuChoice === 1){
        while (true)
        {
            echo PHP_EOL;
            echo "Lucky {$player->getName()}'s balance is {$player->getBalance()} {$player->getNominal()}\n";
            $balanceChoice = (int) readline("Type amount to add or press enter to return to main menu: ");

            if ($balanceChoice === 0) {
                break;
            } else if ($balanceChoice > 0) {
                $player->addBalance($balanceChoice);
            } else {
                echo "Error: wrong input\n";
            }
        }

        // Play the game
    } else if ($menuChoice === 2) {
        while (true)
        {
            echo PHP_EOL;
            echo "Lucky {$player->getName()}'s balance is {$player->getBalance()} {$player->getNominal()}\n";
            echo "|1| Play slots\n";
            echo "|2| Change size\n";
            echo "|3| Return to main menu\n";
            $gameChoice = (int) readline('Option: ');

            // Play slots
            if ($gameChoice === 1) {
                $field->createField();
                $field->displayField();

                while (true)
                {
                    echo PHP_EOL;
                    echo "Lucky {$player->getName()}'s balance is {$player->getBalance()} {$player->getNominal()}\n";
                    $slotsChoice = readline("Press enter to play or type 'give up' to return: ");
                    // Choice is an illusion, anything except precise 'give up' keeps user playing because profit

                    if ($slotsChoice == 'give up') {
                        break;
                    }

                    if ($player->getBalance() - $pullFee < 0) {
                        echo "Please add more money to play!\n";
                        break;
                    }

                    // Change symbols in $field and Take money for play
                    $field->shuffleField();
                    $field->displayField();
                    $player->addLoses($pullFee);
                    $player->takeFromBalance($pullFee);

                    // Check if Won and check how much to return
                    $conditions = new Conditions($field);
                    $conditions->createLines();
                    $conditions->createDiagonalTop();
                    $conditions->createDiagonalBottom();

                    // Checker is used so computer has to check conditions only once
                    $checker = 0;
                    $checker = $conditions->checkWinnings();
                    if ($checker > 0) {
                        $player->addGains($checker);
                        $player->addBalance($checker);
                        echo "Congratulations {$player->getName()}!\n You won $checker {$player->getNominal()}\n";
                    } else {
                        echo "Better luck next time!\n";
                    }
                }

            // Change size
            } else if ($gameChoice === 2) {

                echo PHP_EOL;
                $height = (int) readline('Choose height: ');
                $width = (int) readline('Choose width: ');
                $field->setHeight($height);
                $field->setWidth($width);

            } else if ($gameChoice === 3) {
                break;
            } else {
                echo "Error: wrong input\n";
            }
        }

        // Info
    } else if($menuChoice === 3) {
        echo PHP_EOL;

        // Information for player
        echo "Each play costs $pullFee{$player->getNominal()}\n";
        echo "Winning lines are rows and diagonals.\n";
        echo "You can earn money for multiple winning lines.\n";
        echo "If You change size diagonals go from the left side.\n";
        echo "Once they meet roof or floor, the line keeps going straight in the row.\n";
        echo "'{$field->getAllSigns()[0]}' earns " . $field->signValue($field->getAllSigns()[0]) . $player->getNominal() . PHP_EOL;
        echo "'{$field->getAllSigns()[1]}' earns " . $field->signValue($field->getAllSigns()[1]) . $player->getNominal() . PHP_EOL;
        echo "'{$field->getAllSigns()[2]}' earns " . $field->signValue($field->getAllSigns()[2]) . $player->getNominal() . PHP_EOL;
        echo PHP_EOL;

        $infoChoice = readline('To return press enter: ');

        // Exit
    } else if($menuChoice === 4) {
        break;

        // Error for wrong input in main menu
    } else {
        echo "Error: Sorry but wrong input maybe try Adding more money by choosing typing '1'\n";
    }
}

// Goodbye
if ($player->getStats() > 0) {
    echo "Congratulations {$player->getName()}'s total balance is {$player->getBalance()}{$player->getNominal()} ";
    echo "Which is {$player->getStats()} more than he started from!\n";
} else if ($player->getStats() < 0) {
    $positive = $player->getStats() * -1;
    echo "{$player->getName()}'s total balance is {$player->getBalance()}{$player->getNominal()} ";
    echo "Which is $positive{$player->getNominal()} less than he started from!\n";
    echo "You should try your luck again and earn that money back!\n";
} else {
    echo "{$player->getName()}'s balance didn't change from {$player->getBalance()}{$player->getNominal()}. ";
    echo "Did he even play the game?\n";
}

echo "Thank you for playing and goodbye!\n";
