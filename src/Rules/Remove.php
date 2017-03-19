<?php

namespace App\Rules;

class Remove implements Rule
{
    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $value;

    /**
     * @var int
     */
    private $quantity;

    /**
     * Rule constructor.
     *
     * @param float $price
     * @param int $value
     * @param int $quantity
     */
    public function __construct(float $price, int $value, int $quantity)
    {
        $this->price = $price;
        $this->value = $value;
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function applyRule(): float
    {
        return ($this->price * $this->quantity) - ($this->price * $this->value);
    }
}
