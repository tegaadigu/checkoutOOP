<?php

namespace App;

class Product
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $price;

    /**
     * Product constructor.
     *
     * @param string $sku
     * @param string $name
     * @param string $price
     */
    public function __construct(string $sku, string $name, string $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }
}
