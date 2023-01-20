<?php
namespace App;

class Signs
{
    private string $empty = 'O';
    private array $allSigns = ['@', '#', '$']; // Order symbols ending with rarest (it's needed latter when checking payout)
    private string $sign = '';

    public function __construct(string $empty = 'O', array $allSigns = ['@', '#', '$'])
    {
        $this->empty = $empty;
        $this->allSigns = $allSigns;
    }

    public function setEmpty(string $empty): void
    {
        $this->empty = $empty;
    }

    public function getEmpty(): string
    {
        return $this->empty;
    }

    public function setAllSigns(array $allSigns): void
    {
        $this->allSigns = $allSigns;
    }

    public function getAllSigns(): array
    {
        return $this->allSigns;
    }

    public function getSign(): string
    {
        if ($this->sign === '') {
            return $this->getEmpty();
        } else {
            return $this->sign;
        }
    }

    public function setSign($sign): void
    {
        $this->sign = $sign;
    }

    // Change this to change sign chance or count
    public function getRandomSign(): void
    {
        $randomNumber = rand(0, 100);
        if ($randomNumber < 10) {
            $this->sign = $this->allSigns[2];
        } else if ($randomNumber <= 40) {
            $this->sign = $this->allSigns[1];
        } else {
            $this->sign = $this->allSigns[0];
        }
    }

    public function signValue($sign): int
    {
        if ($sign === $this->allSigns[2]) {
            return 1000;
        } else if ($sign === $this->allSigns[1]) {
            return 500;
        } else if ($sign === $this->allSigns[0]){
            return 200;
        }
    }
}