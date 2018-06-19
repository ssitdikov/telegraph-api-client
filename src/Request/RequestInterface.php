<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;

interface RequestInterface
{
    const POST = 'post';
    const GET = 'get';

    public function getMethod(): string;

    public function getUrlRequest(): string;

    public function getParams(): array;

    public function handleResponse(ResponseInterface $response);
}
