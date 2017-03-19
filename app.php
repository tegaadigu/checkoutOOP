<?php

include __DIR__ . '/vendor/autoload.php';

use App\Checkout;
use App\Product;

$config = json_decode(file_get_contents('config.json'));

$productObjArray = [];

foreach ($config->products as $product) {
    $productObjArray[$product->sku] = new Product($product->sku, $product->name, $product->price);
}
$checkout = new Checkout();

$checkout->scan($productObjArray['mbp']);
$checkout->scan($productObjArray['vga']);
$checkout->scan($productObjArray['ipd']);

echo $checkout->total();
