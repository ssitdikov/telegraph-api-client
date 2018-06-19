<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Exception\ContentTextRequired;
use SSitdikov\TelegraphAPI\Type\Page;

class CreatePageRequest extends AbstractPageRequest
{
    public function getUrlRequest(): string
    {
        return 'createPage';
    }

    public function getParams(): array
    {
        $params = [
            'access_token' => $this->account->getAccessToken(),
            'title'        => $this->page->getTitle(),
            'content'      => $this->page->getContent(),
        ];
        if ($this->page->getAuthorName()) {
            $params['author_name'] = $this->page->getAuthorName();
        }
        if ($this->page->getAuthorUrl()) {
            $params['author_url'] = $this->page->getAuthorUrl();
        }
        if ($this->returnContent) {
            $params['return_content'] = true;
        }

        return ['json' => $params];
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ContentTextRequired
     * @throws \Exception
     *
     * @return \SSitdikov\TelegraphAPI\Type\Page
     */
    public function handleResponse(ResponseInterface $response): Page
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            switch ($json->error) {
                case 'CONTENT_TEXT_REQUIRED':
                    throw new ContentTextRequired();
                default:
                    throw new \Exception($json->error);
            }
        }
        $this->page->setTitle($json->result->title);
        $this->page->setPath($json->result->path);
        $this->page->setUrl($json->result->url);
        $this->page->setDescription($json->result->description);
        $this->page->setViews($json->result->views);
        if (isset($json->result->can_edit)) {
            $this->page->setCanEdit($json->result->can_edit);
        }
        if ($this->getReturnContent()) {
            $this->page->setContent($json->result->content);
        }

        return $this->page;
    }
}
