<?php
namespace App;

class Field extends Signs
{
    private array $field;
    private int $height = 3;
    private int $width = 5;

    public function __construct(int $height = 3, int $width = 5)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function getField(): array
    {
        return $this->field;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    // Makes $field into 3D array filled with sign objects
    public function createField(): void
    {
        $this->field = [];
        for ($i = 0; $i < $this->getHeight(); $i++) {
            $this->field[] = [];
            for ($j = 0; $j < $this->getWidth(); $j++) {
                $this->field[$i] []= new Signs;
            }
        }
    }

    // MUST be used after createField() to display $field array to user
    public function displayField (): void
    {
        echo str_repeat('=',$this->getWidth() / 2 * 3 - 3) . "SLOTS" . str_repeat('=',$this->getWidth() / 2 * 3 - 2) . PHP_EOL;
        foreach ($this->field as $row) {
            foreach ($row as $slot) {
                echo "|{$slot->getSign()}|";
            }
            echo "\n";
        }
        echo str_repeat('=', $this->getWidth() * 3) . PHP_EOL;
    }

    // Shuffles $field array Signs objects with help of Signs->allSigns array
    public function shuffleField(): void
    {
        foreach ($this->field as $row) {
            foreach ($row as $sign) {
                $sign->getRandomSign();
            }
        }
    }
}