<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;

abstract class AbstractAccountRequest implements RequestInterface
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getMethod(): string
    {
        return self::POST;
    }

    abstract public function getUrlRequest(): string;

    abstract public function getParams(): array;

    abstract public function handleResponse(ResponseInterface $response): Account;
}
