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
    ImageType, LinkType, ParagraphType
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
    $image->setSrc('http://telegra.ph/file/54c7e357b3062eb4c1d3a.png');

    $text = new ParagraphType();
    $text->setText('Some of example');

    $linkText = new ParagraphType();
    $linkText->addContentElement($link);

    $page->setContent([$linkText, $text, $image, $text, $linkText]);

    $page = $telegraph->createPage(
        new CreatePageRequest($page, $account)
    );
} catch (\Exception $e) {
    // logger
}