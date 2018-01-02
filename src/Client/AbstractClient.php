<?php

namespace SSitdikov\TelegraphAPI\Client;

use SSitdikov\TelegraphAPI\Request\{
    CreateAccountRequest, CreatePageRequest, EditAccountInfoRequest, EditPageRequest, GetAccountInfoRequest, GetPageListRequest, GetPageRequest, GetViewsRequest, RevokeAccessTokenRequest
};
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
