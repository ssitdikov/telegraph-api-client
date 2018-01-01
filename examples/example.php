<?php

use SSitdikov\TelegraphAPI\Client\TelegraphClient;

use SSitdikov\TelegraphAPI\Type\Account;
require __DIR__ . '/../vendor/autoload.php';

$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegra.ph/']);

$telegraph = new TelegraphClient($client);

$account = new Account();
$account->setAuthorName('');
$account->setAuthorUrl('');
$account->setShortName('Vedomos.ti');
$account->setAccessToken('7180579c3d4c3c2a67b48311fb02e64153674606cfd8c4b89326a5777202');

try {
    $account = $telegraph->createAccount( new \SSitdikov\TelegraphAPI\Request\CreateAccountRequest($account));
    print $account->getAccessToken();
    print PHP_EOL;
} catch (\Exception $e) {}