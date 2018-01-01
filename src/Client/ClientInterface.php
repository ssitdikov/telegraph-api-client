<?php

namespace SSitdikov\TelegraphAPI\Client;

use SSitdikov\TelegraphAPI\Request\{
    CreateAccountRequest, CreatePageRequest, EditAccountInfoRequest, EditPageRequest, GetAccountInfoRequest, GetPageRequest, RevokeAccessTokenRequest
};
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;

interface ClientInterface
{

    public function createAccount(CreateAccountRequest $createAccountRequest): Account;

    public function editAccountInfo(EditAccountInfoRequest $editAccountInfoRequest): Account;

    public function getAccountInfo(GetAccountInfoRequest $getAccountInfoRequest): Account;

    public function revokeAccessToken(RevokeAccessTokenRequest $revokeAccessTokenRequest): Account;

    public function createPage(CreatePageRequest $createPageRequest): Page;

    public function getPage(GetPageRequest $getPageRequest): Page;

    public function editPage(EditPageRequest $editPageRequest): Page;
}