<?php

namespace SSitdikov\TelegraphAPI\Client;

use SSitdikov\TelegraphAPI\Request\{
    CreateAccountRequest, CreatePageRequest, EditAccountInfoRequest, EditPageRequest, GetAccountInfoRequest, GetPageListRequest, GetPageRequest, GetViewsRequest, RevokeAccessTokenRequest
};
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;
use SSitdikov\TelegraphAPI\Type\PageList;
use SSitdikov\TelegraphAPI\Type\PageViews;

interface ClientInterface
{

    public function createAccount(CreateAccountRequest $createAccountRequest): Account;

    public function editAccountInfo(EditAccountInfoRequest $editAccountInfoRequest): Account;

    public function getAccountInfo(GetAccountInfoRequest $getAccountInfoRequest): Account;

    public function revokeAccessToken(RevokeAccessTokenRequest $revokeAccessTokenRequest): Account;

    public function createPage(CreatePageRequest $createPageRequest): Page;

    public function getPage(GetPageRequest $getPageRequest): Page;

    public function editPage(EditPageRequest $editPageRequest): Page;

    public function getPageList(GetPageListRequest $getPageListRequest): PageList;

    public function getViews(GetViewsRequest $getViewsRequest): PageViews;
}