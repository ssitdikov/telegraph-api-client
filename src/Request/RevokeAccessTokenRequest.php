<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Request;


use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;

class RevokeAccessTokenRequest extends AbstractAccountRequest
{

    public function getUrlRequest(): string
    {
        return 'revokeAccessToken';
    }

    public function getParams(): array
    {
        $response = ['access_token' => $this->account->getAccessToken()];
        return ['json' => $response];
    }

    public function handleResponse(ResponseInterface $response): Account
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            throw new \Exception($json->error);
        }

        $this->account->setAccessToken($json->result->access_token);
        $this->account->setAuthUrl($json->result->auth_url);

        return $this->account;
    }

}