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
    abstract public function createAccount(CreateAccountRequest $createAccountRequest): Account;

    abstract public function editAccountInfo(EditAccountInfoRequest $editAccountInfoRequest): Account;

    abstract public function getAccountInfo(GetAccountInfoRequest $getAccountInfoRequest): Account;

    abstract public function revokeAccessToken(RevokeAccessTokenRequest $revokeAccessTokenRequest): Account;

    abstract public function createPage(CreatePageRequest $createPageRequest): Page;

    abstract public function getPage(GetPageRequest $getPageRequest): Page;

    abstract public function editPage(EditPageRequest $editPageRequest): Page;

    abstract public function getPageList(GetPageListRequest $getPageListRequest): PageList;

    abstract public function getViews(GetViewsRequest $getViewsRequest): PageViews;

}
