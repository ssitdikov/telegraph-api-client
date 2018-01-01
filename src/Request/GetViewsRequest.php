<?php

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Request\RequestObject\ViewsRequestObject;
use SSitdikov\TelegraphAPI\Type\PageViews;

class GetViewsRequest implements RequestInterface
{

    private $viewsRequest;

    public function __construct(ViewsRequestObject $requestObject)
    {
        $this->viewsRequest = $requestObject;
    }
    public function getMethod(): string
    {
        return self::POST;
    }

    public function getUrlRequest(): string
    {
        return 'getViews/' . $this->viewsRequest->getPath();
    }

    public function getParams(): array
    {
        $params = [];
        if ($this->viewsRequest->getHour()){
            $params['hour'] = $this->viewsRequest->getHour();
            $params['day'] = $this->viewsRequest->getDay();
        }
        if ($this->viewsRequest->getDay()) {
            $params['day'] = $this->viewsRequest->getDay();
            $params['month'] = $this->viewsRequest->getMonth();
        }
        if ($this->viewsRequest->getMonth()) {
            $params['month'] = $this->viewsRequest->getMonth();
            $params['year'] = $this->viewsRequest->getYear();
        }
        return ['json' => $params];
    }

    public function handleResponse(ResponseInterface $response)
    {
       $json = json_decode($response->getBody()->getContents());
       if ($json->ok === false && isset($json->error)) {
           throw new \Exception($json->error);
       }

       return new PageViews($json->result->views);
    }

}