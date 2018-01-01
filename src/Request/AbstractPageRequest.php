<?php

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;

abstract class AbstractPageRequest implements RequestInterface
{

    protected $page;
    protected $account;
    protected $returnContent = false;

    public function __construct(Page $page, Account $account)
    {
        $this->page = $page;
        $this->account = $account;
    }

    public function isReturnContent($returnContent = true)
    {
        $this->returnContent = $returnContent;
    }

    public function getMethod(): string
    {
        return self::POST;
    }

    abstract public function getUrlRequest(): string;

    abstract public function getParams(): array;

    abstract public function handleResponse(ResponseInterface $response);

}