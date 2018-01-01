<?php

namespace SSitdikov\TelegraphAPI\Client;

use GuzzleHttp\Client;
use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use SSitdikov\TelegraphAPI\Request\EditAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\EditPageRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\GetPageListRequest;
use SSitdikov\TelegraphAPI\Request\GetPageRequest;
use SSitdikov\TelegraphAPI\Request\GetViewsRequest;
use SSitdikov\TelegraphAPI\Request\RequestInterface;
use SSitdikov\TelegraphAPI\Request\RevokeAccessTokenRequest;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;
use SSitdikov\TelegraphAPI\Type\PageList;
use SSitdikov\TelegraphAPI\Type\PageViews;

class TelegraphClient extends AbstractClient
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function doRequest(RequestInterface $request)
    {
        $response = $this->client->request(
            $request->getMethod(),
            $request->getUrlRequest(),
            $request->getParams()
        );
        return $request->handleResponse($response);
    }

    public function createAccount(CreateAccountRequest $createAccountRequest): Account
    {
        return $this->doRequest($createAccountRequest);
    }

    public function editAccountInfo(EditAccountInfoRequest $editAccountRequest): Account
    {
        return $this->doRequest($editAccountRequest);
    }

    public function getAccountInfo(GetAccountInfoRequest $getAccountInfoRequest): Account
    {
        return $this->doRequest($getAccountInfoRequest);
    }

    public function revokeAccessToken(RevokeAccessTokenRequest $revokeAccessTokenRequest): Account
    {
        return $this->doRequest($revokeAccessTokenRequest);
    }

    public function createPage(CreatePageRequest $createPageRequest): Page
    {
        return $this->doRequest($createPageRequest);
    }

    public function getPage(GetPageRequest $getPageRequest): Page
    {
        return $this->doRequest($getPageRequest);
    }

    public function editPage(EditPageRequest $editPageRequest): Page
    {
        return $this->doRequest($editPageRequest);
    }

    public function getPageList(GetPageListRequest $getPageListRequest): PageList
    {
        return $this->doRequest($getPageListRequest);
    }

    public function getViews(GetViewsRequest $getViewsRequest): PageViews
    {
        return $this->doRequest($getViewsRequest);
    }
}