<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;

class GetAccountInfoRequest extends AbstractAccountRequest
{
    private $fields = ['short_name', 'author_name', 'author_url', 'auth_url', 'page_count'];

    public function setAccountFields($fields)
    {
        $this->fields = $fields;
    }

    public function getUrlRequest(): string
    {
        return 'getAccountInfo';
    }

    public function getParams(): array
    {
        $params = [
            'access_token' => $this->account->getAccessToken(),
            'fields'       => $this->fields,
        ];

        return ['json' => $params];
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws \Exception
     *
     * @return Account
     */
    public function handleResponse(ResponseInterface $response): Account
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            throw new \Exception($json->error);
        }
        $account = new Account();
        if (in_array('short_name', $this->fields)) {
            $account->setShortName($json->result->short_name);
        }
        if (in_array('author_name', $this->fields)) {
            $account->setAuthorName($json->result->author_name);
        }
        if (in_array('author_url', $this->fields)) {
            $account->setAuthorUrl($json->result->author_url);
        }
        if (in_array('auth_url', $this->fields)) {
            $account->setAuthUrl($json->result->auth_url);
        }
        if (in_array('page_count', $this->fields)) {
            $account->setPageCount($json->result->page_count);
        }
        $account->setAccessToken($this->account->getAccessToken());

        return $account;
    }
}
