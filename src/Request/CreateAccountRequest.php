<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Exception\ShortNameRequiredException;
use SSitdikov\TelegraphAPI\Type\Account;

class CreateAccountRequest extends AbstractAccountRequest
{
    public function getUrlRequest(): string
    {
        return 'createAccount';
    }

    public function getParams(): array
    {
        $params = [
            'short_name' => $this->account->getShortName(),
        ];
        if ($this->account->getAuthorName()) {
            $params['author_name'] = $this->account->getAuthorName();
        }
        if ($this->account->getAuthorUrl()) {
            $params['author_url'] = $this->account->getAuthorUrl();
        }

        return ['json' => $params];
    }

    /**
     * @param  ResponseInterface          $response
     * @throws ShortNameRequiredException
     * @throws \Exception
     * @return Account
     */
    public function handleResponse(ResponseInterface $response): Account
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            switch ($json->error) {
                case ('SHORT_NAME_REQUIRED'):
                    throw new ShortNameRequiredException();
            }
            throw new \Exception($json->error);
        }
        $this->account->setShortName($json->result->short_name);
        $this->account->setAuthorName($json->result->author_name);
        $this->account->setAuthorUrl($json->result->author_url);
        $this->account->setAuthUrl($json->result->auth_url);
        $this->account->setAccessToken($json->result->access_token);
        return $this->account;
    }
}
