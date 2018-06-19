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

interface ClientInterface
{
    public function createAccount(CreateAccountRequest $request): Account;

    public function editAccountInfo(EditAccountInfoRequest $request): Account;

    public function getAccountInfo(GetAccountInfoRequest $request): Account;

    public function revokeAccessToken(RevokeAccessTokenRequest $request): Account;

    public function createPage(CreatePageRequest $request): Page;

    public function getPage(GetPageRequest $request): Page;

    public function editPage(EditPageRequest $request): Page;

    public function getPageList(GetPageListRequest $request): PageList;

    public function getViews(GetViewsRequest $request): PageViews;
}
