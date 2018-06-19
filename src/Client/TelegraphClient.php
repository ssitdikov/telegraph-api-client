<?php declare(strict_types=1);

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

    public function __construct(Client $client = null)
    {
        if (null === $client) {
            $client = new Client(['base_uri' => 'https://api.telegra.ph/']);
        }
        $this->client = $client;
    }

    public function createAccount(CreateAccountRequest $request): Account
    {
        return $this->doRequest($request);
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

    public function editAccountInfo(EditAccountInfoRequest $request): Account
    {
        return $this->doRequest($request);
    }

    public function getAccountInfo(GetAccountInfoRequest $request): Account
    {
        return $this->doRequest($request);
    }

    public function revokeAccessToken(RevokeAccessTokenRequest $request): Account
    {
        return $this->doRequest($request);
    }

    public function createPage(CreatePageRequest $request): Page
    {
        return $this->doRequest($request);
    }

    public function getPage(GetPageRequest $request): Page
    {
        return $this->doRequest($request);
    }

    public function editPage(EditPageRequest $request): Page
    {
        return $this->doRequest($request);
    }

    public function getPageList(GetPageListRequest $request): PageList
    {
        return $this->doRequest($request);
    }

    public function getViews(GetViewsRequest $request): PageViews
    {
        return $this->doRequest($request);
    }
}
