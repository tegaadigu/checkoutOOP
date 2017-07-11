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

$line = '';
do{
echo "Enter product SKU [mbp, vga, ipd]\nEnter product SKU or checkout to end: ";
$handle = fopen ("php://stdin","r");
$line = trim(fgets($handle));
if($line == 'checkout'){
    echo "Total Price:". $checkout->total()."\n";
    exit;
}
$checkout->scan($productObjArray[$line]);
}while($line = 'yes');
echo "\n";
echo "Thank you, continuing...\n";


