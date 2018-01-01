<?php

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;

class EditAccountInfoRequest extends AbstractAccountRequest
{

    public function getUrlRequest(): string
    {
        return 'editAccountInfo';
    }

    public function getParams(): array
    {
        $params = [
            'access_token' => $this->account->getAccessToken(),
        ];

        if ($this->account->getShortName()) {
            $params['short_name'] = $this->account->getShortName();
        }

        if ($this->account->getAuthorName()) {
            $params['author_name'] = $this->account->getAuthorName();
        }

        if ($this->account->getAuthorUrl()) {
            $params['author_url'] = $this->account->getAuthorUrl();
        }

        return ['json' => $params];
    }

    /**
     * @param ResponseInterface $response
     * @return Account
     * @throws \Exception
     */
    public function handleResponse(ResponseInterface $response): Account
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            throw new \Exception($json->error);
        }
        $this->account->setAuthorName($json->result->author_name);
        $this->account->setAuthorUrl($json->result->author_url);
        $this->account->setShortName($json->result->short_name);
        return $this->account;
    }

}