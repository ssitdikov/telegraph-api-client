<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Client;

use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use SSitdikov\TelegraphAPI\Request\EditAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\EditPageRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\GetPageListRequest;
use SSitdikov\TelegraphAPI\Request\GetPageRequest;
use SSitdikov\TelegraphAPI\Request\GetViewsRequest;
use SSitdikov\TelegraphAPI\Request\RevokeAccessTokenRequest;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;
use SSitdikov\TelegraphAPI\Type\PageList;
use SSitdikov\TelegraphAPI\Type\PageViews;

abstract class AbstractClient implements ClientInterface
{
    abstract public function createAccount(CreateAccountRequest $request): Account;

    abstract public function editAccountInfo(EditAccountInfoRequest $request): Account;

    abstract public function getAccountInfo(GetAccountInfoRequest $request): Account;

    abstract public function revokeAccessToken(RevokeAccessTokenRequest $request): Account;

    abstract public function createPage(CreatePageRequest $request): Page;

    abstract public function getPage(GetPageRequest $request): Page;

    abstract public function editPage(EditPageRequest $request): Page;

    abstract public function getPageList(GetPageListRequest $request): PageList;

    abstract public function getViews(GetViewsRequest $request): PageViews;
}
