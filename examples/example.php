<?php

use SSitdikov\TelegraphAPI\Client\TelegraphClient;
use SSitdikov\TelegraphAPI\Request\{
    CreateAccountRequest, EditAccountInfoRequest
};
use SSitdikov\TelegraphAPI\Request\{
    CreatePageRequest
};
use SSitdikov\TelegraphAPI\Type\{
    Account, Page
};
use SSitdikov\TelegraphAPI\Type\ContentType\{
    ImageType, LinkType
};

require __DIR__ . '/../vendor/autoload.php';

$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegra.ph/']);

$telegraph = new TelegraphClient($client);

$account = new Account();
$account->setShortName('Test.Account');
try {
    $account = $telegraph->createAccount(
        new CreateAccountRequest($account)
    );

    $account->setAuthorName('Test Name');
    $account = $telegraph->editAccountInfo(
        new EditAccountInfoRequest($account)
    );

    $page = new Page();
    $page->setTitle('Test article');
    $page->setAuthorName($account->getAuthorName());

    $link = new LinkType();
    $link->setHref('https://github.com/ssitdikov');
    $link->setText('Salavat Sitdikov github`s page');

    $image = new ImageType();
    $image->setSrc('https://telegram.org/file/811140775/1/Pc_4R_013Ow.144034/1c1eeaa592370d0b93');

    $page->setContent([$link, $image,]);

    $page = $telegraph->createPage(
        new CreatePageRequest($page, $account)
    );
} catch (\Exception $e) {
    // logger
}