<?php

namespace App\Rules;

use App\Checkout;

class Gift implements Rule
{
    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * @var array
     */
    private $sku;
    /**
     * @var array
     */
    private $giftedItem;

    /**
     * Gift constructor.
     *
     * @param Checkout $checkout
     * @param array $giftedItem
     * @param string $sku
     */
    public function __construct(Checkout $checkout, array $giftedItem, string $sku)
    {
        $this->checkout = $checkout;
        $this->sku = $sku;
        $this->giftedItem = $giftedItem;
    }

    /**
     * @return float
     */
    public function applyRule(): float
    {
        list($countGifts, $price) = $this->getGiftedItemProperties();
        $counter = 0;
        foreach ($this->checkout->getItems() as $key => $item) {
            if ($counter === $countGifts) {
                break;
            }
            if (in_array($item->getSku(), $this->giftedItem, true) !== false) {
                $this->checkout->removeItem($key);
                $counter++;
                $price -= $item->getPrice();
            }
        }

        return $price;
    }

    /**
     * @return array
     */
    private function getGiftedItemProperties(): array
    {
        $countGifts = 0;
        $price = [0];
        foreach ($this->checkout->getItems() as $item) {
            if ($item->getSku() === $this->sku) {
                $countGifts++;
                $price[] = $item->getPrice();
            }
        }

        return [$countGifts, array_sum($price)];
    }
}
