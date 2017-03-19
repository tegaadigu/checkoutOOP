<?php

namespace App\Rules;

class Dummy implements Rule
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $quantity;

    /**
     * Rule constructor.
     *
     * @param float $price
     * @param int $quantity
     */
    public function __construct(float $price, int $quantity)
    {
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function applyRule(): float
    {
        return $this->price * $this->quantity;
    }
}
