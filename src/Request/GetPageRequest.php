<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Page;

class GetPageRequest extends AbstractPageRequest
{

    public function getUrlRequest(): string
    {
        return 'getPage/' . $this->page->getPath();
    }

    public function getParams(): array
    {
        $params = [
            'return_content' => $this->returnContent
        ];
        return ['json' => $params];
    }

    public function handleResponse(ResponseInterface $response): Page
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            throw new \Exception($json->error);
        }
        $this->page->setTitle($json->result->title);
        $this->page->setPath($json->result->path);
        $this->page->setUrl($json->result->url);
        $this->page->setDescription($json->result->description);
        $this->page->setViews($json->result->views);
        if (isset($json->result->can_edit)) {
            $this->page->setCanEdit($json->result->can_edit);
        }
        if ($this->returnContent) {
            $this->page->setContent($json->result->content);
        }
        return $this->page;
    }

}