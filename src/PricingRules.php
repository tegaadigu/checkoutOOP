<?php

namespace App;

use App\Rules\Discount;
use App\Rules\Dummy;
use App\Rules\Gift;
use App\Rules\Remove;
use App\Rules\Rule;

class PricingRules
{
    /**
     * @var mixed
     */
    private $config;

    /**
     * @var Checkout
     */
    private $checkout;

    /**
     * PricingRules constructor.
     *
     * @param Checkout $checkout
     */
    public function __construct(Checkout $checkout)
    {
        $this->config = json_decode(file_get_contents('config.json'))->pricing_rules;
        $this->checkout = $checkout;
    }

    /**
     * @param string $sku
     * @param int $quantity
     * @param float $price
     *
     * @return float
     * @throws \Exception
     */
    public function applyRule(string $sku, int $quantity, float $price): float
    {
        if (!property_exists($this->config, $sku)) {
            return $price * $quantity;
        }

        $rules = $this->config->{$sku};
        $ruleObj = null;
        foreach ($rules as $rule) {
            if ($quantity < $rule->quantity) {
                continue;
            }
            $ruleObj = $this->createRule($rule->type, $price, $rule->value, $quantity, $sku);
            break;
        }

        if ($ruleObj === null) {
            return $price * $quantity;
        }

        return $ruleObj->applyRule();
    }

    /**
     * @param string $type
     *
     * @param float $price
     * @param $value
     *
     * @param int $quantity
     *
     * @param string $sku
     *
     * @return Rule
     */
    private function createRule(string $type, float $price, $value, int $quantity, string $sku): Rule
    {
        switch ($type) {
            case 'REMOVE':
                return new Remove($price, $value, $quantity);
            case 'DISCOUNT':
                return new Discount($price, $value, $quantity);
            case 'GIFT':
                return new Gift($this->checkout, $value, $sku);
            default:
                return new Dummy($price, $quantity);
        }
    }
}
