<?php

namespace SSitdikov\TelegraphAPI\Client;

use GuzzleHttp\Client;
use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use SSitdikov\TelegraphAPI\Request\EditAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\EditPageRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\GetPageRequest;
use SSitdikov\TelegraphAPI\Request\RequestInterface;
use SSitdikov\TelegraphAPI\Request\RevokeAccessTokenRequest;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;

class TelegraphClient extends AbstractClient
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createAccount(CreateAccountRequest $createAccountRequest): Account
    {
        return $this->doRequest($createAccountRequest);
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
}