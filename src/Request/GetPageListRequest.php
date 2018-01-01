<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Request;

use Psr\Http\Message\ResponseInterface;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\PageList;

class GetPageListRequest implements RequestInterface
{

    private $account;

    private $offset;
    private $limit;

    public function __construct(Account $account, $offset = 0, $limit = 50)
    {
        $this->account = $account;
        $this->offset = $offset;
        if ($limit > 200 || $limit < 0) $limit = 50;
        $this->limit = $limit;
    }

    public function getMethod(): string
    {
        return self::POST;
    }

    public function getUrlRequest(): string
    {
        return 'getPageList';
    }

    public function getParams(): array
    {
        $params = [
            'access_token' => $this->account->getAccessToken(),
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
        return ['json' => $params];
    }

    /**
     * @param ResponseInterface $response
     * @return PageList
     * @throws \Exception
     */
    public function handleResponse(ResponseInterface $response): PageList
    {
        $json = json_decode($response->getBody()->getContents());
        if ($json->ok === false && isset($json->error)) {
            throw new \Exception($json->error);
        }
        $pageList = new PageList();
        $pageList->setTotalCount($json->result->total_count);
        $pageList->setPages($json->result->pages);
        return $pageList;
    }

}