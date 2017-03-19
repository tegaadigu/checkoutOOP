<?php

namespace App;

class Checkout
{
    /**
     * @var array
     */
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @param Product $item
     */
    public function scan(Product $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return float
     */
    public function total(): float
    {
        if (empty($this->items)) {
            return 0.0;
        }
        $itemBreakdown = $this->processItems();
        $prices = [];
        $priceRule = new PricingRules($this);
        foreach ($itemBreakdown as $sku => $breakdown) {
            $prices[] = $priceRule->applyRule($sku, $breakdown['quantity'], $breakdown['price']);
        }

        return array_sum($prices);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $index
     */
    public function removeItem(int $index)
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
        }
    }

    /**
     * @return array
     */
    private function processItems(): array
    {
        $itemBreakdown = [];
        foreach ($this->items as $item) {
            $itemBreakdown[$item->getSku()]['price'] = $item->getPrice();
            if (isset($itemBreakdown[$item->getSku()]['quantity'])) {
                $itemBreakdown[$item->getSku()]['quantity'] += 1;
            } else {
                $itemBreakdown[$item->getSku()]['quantity'] = 1;
            }
        }

        return $itemBreakdown;
    }
}   
