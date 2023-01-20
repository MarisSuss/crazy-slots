<?php
namespace App;

class Player
{
    private string $name = 'Default username';
    private int $balance = 0;
    private string $nominal = '$';
    private int $loses = 0;
    private int $gains = 0;
    /*
     * Nominal could be given as user choice,
     * but it would waste users time and patience
     * instead of spending money on slots
     */

    public function __construct(string $name = 'Default user', int $balance = 0, string $nominal = '$')
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->nominal = $nominal;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function addBalance(int $addAmount): void
    {
        $this->balance += $addAmount;
    }

    public function takeFromBalance(int $takeAmount): void
    {
        $this->balance -= $takeAmount;
    }

    public function getNominal(): string
    {
        return $this->nominal;
    }

    public function getStats(): int
    {
        return $this->gains - $this->loses;
    }

    public function addGains($value): void
    {
        $this->gains += $value;
    }
    public function addLoses($value): void
    {
        $this->loses += $value;
    }
}