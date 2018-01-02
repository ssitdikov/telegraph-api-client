[![Build Status](https://travis-ci.org/ssitdikov/telegraph-api-client.svg?branch=master)](https://travis-ci.org/ssitdikov/telegraph-api-client)
[![Coverage Status](https://coveralls.io/repos/github/ssitdikov/telegraph-api-client/badge.svg?branch=master)](https://coveralls.io/github/ssitdikov/telegraph-api-client?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/38edcd896a7a47a3ba790cdf4167b7bc)](https://www.codacy.com/app/sitsalavat/telegraph-api-client?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ssitdikov/telegraph-api-client&amp;utm_campaign=Badge_Grade)

# Telegra.ph API PHP Client 
## О продукте
Данная библиотека предназначена для работы с сервисом [Telegra.ph](https://telegra.ph).

## Установка
Предполагается установка с использованием composer
```
composer require ssitdikov/telegraph-api-client
```

## Пример использования
### Создание аккаунта
```php
$telegraph = new TelegraphClient($client);

$account = new Account();
$account->setShortName('Test.Account');
try {
    $account = $telegraph->createAccount(
        new CreateAccountRequest($account)
    );
catch (\Exception $e) {
// ...
}

```

### Создание страницы
```php
$page = new Page();
$page->setTitle('Test article');
$page->setAuthorName( $account->getAuthorName() );

$link = new LinkType();
$link->setHref('https://github.com/ssitdikov');
$link->setText('Salavat Sitdikov github`s page');

$image = new ImageType();
$image->setSrc('https://telegram.org/file/811140775/1/Pc_4R_013Ow.144034/1c1eeaa592370d0b93');

$page->setContent([$link, $image,]);

$page = $telegraph->createPage(
    new CreatePageRequest($page, $account)
);
```

В настоящее время доступны следующие типы данных контента:
`ParagraphType`, `ImageType`, `LinkType`, `YoutubeType`.