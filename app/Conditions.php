<?php
namespace App;

class Conditions extends Signs
{
    private Field $field;
    private array $lines = [];
    public array $diagonalTop = [];
    public array $diagonalBottom = [];

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    // Create win conditions for lines
    public function createLines(): void
    {
        for ($i = 0; $i < $this->field->getHeight(); $i++) {
            $this->lines []= [];
            for ($j = 0; $j < $this->field->getWidth(); $j++) {
                $this->lines[$i] []= [];
                $this->lines[$i][$j] []= $i;
                $this->lines[$i][$j] []= $j;
            }
        }
    }

    // Creates diagonal lines that move diagonally until they meet top or bottom
    // From the top
    public function createDiagonalTop(): void
    {
        $j = 0;
        for ($i = 0; $i < $this->field->getWidth(); $i++) {
            $this->diagonalTop []= [];
            $this->diagonalTop[$i] = [$j, $i];
            if ($j < $this->field->getHeight() - 1) {
                $j++;
            }
        }
    }
    // From the bottom
    public function createDiagonalBottom(): void
    {
        $j = $this->field->getHeight() - 1;
        for ($i = 0; $i < $this->field->getWidth(); $i++) {
            $this->diagonalBottom []= [];
            $this->diagonalBottom[$i] = [$j, $i];
            if ($j > 0) {
                $j--;
            }
        }
    }

    // Gather win conditions
    public function getAllWinConditions(): array
    {
        return [$this->lines, [$this->diagonalTop], [$this->diagonalBottom]];
    }

    // check if player wins and returns the amount
    public function checkWinnings(): int
    {
        $result = 0;
        foreach ($this->getAllWinConditions() as $conditions) {
            foreach ($conditions as $condition) {
                    for ($i = 0; $i < count($this->field->getAllSigns()); $i++) {
                        $conditionCounter = 0;
                        foreach ($condition as $position) {
                            [$x, $y] = $position;
                            if ($this->field->getField()[$x][$y]->getSign() !== $this->field->getAllSigns()[$i]) {
                                break;
                            }
                            $conditionCounter++;
                            if ($conditionCounter === $this->field->getWidth()) {
                                $sign = $this->field->getAllSigns()[$i];
                                $result += $this->signValue($sign); // Player can win multiple lines per pull
                            }
                        }
                    }
                }
            }
        return $result;
    }
}