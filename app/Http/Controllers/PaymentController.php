<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    $client = new \Adyen\Client();
$client->setEnvironment(\Adyen\Environment::TEST);
$client->setXApiKey("YOUR_X-API-KEY");
$service = new \Adyen\Service\Checkout($client);

$params = array(
    "countryCode" => "NL",
    "shopperLocale" => "nl-NL",
    "amount" => array(
        "currency" => "EUR",
        "value" => 1000
    ),
    "channel" => "Web",
    "merchantAccount" => "YOUR_MERCHANT_ACCOUNT"
);
$result = $service->paymentMethods($params);


$client = new \Adyen\Client();
$client->setEnvironment(\Adyen\Environment::TEST);
$client->setXApiKey("YOUR_X-API-KEY");
$service = new \Adyen\Service\Checkout($client);

$params = array(
    "paymentMethod" => array(
        "type" => "scheme",
        "encryptedCardNumber" => "test_4111111111111111",
        "encryptedExpiryMonth" => "test_03",
        "encryptedExpiryYear" => "test_2030",
        "encryptedSecurityCode" => "test_737"
    ),
    "amount" => array(
        "currency" => "EUR",
        "value" => 1000
    ),
    "reference" => "YOUR_ORDER_NUMBER",
    "returnUrl" => "https://your-company.com/checkout?shopperOrder=12xy..",
    "merchantAccount" => "YOUR_MERCHANT_ACCOUNT"
);
$result = $service->payments($params);

}
