<?php

namespace SSitdikov\TelegraphAPI\Tests\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Client\TelegraphClient;
use SSitdikov\TelegraphAPI\Exception\ContentTextRequired;
use SSitdikov\TelegraphAPI\Exception\ShortNameRequiredException;
use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use SSitdikov\TelegraphAPI\Request\EditAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\EditPageRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\GetPageListRequest;
use SSitdikov\TelegraphAPI\Request\GetPageRequest;
use SSitdikov\TelegraphAPI\Request\GetViewsRequest;
use SSitdikov\TelegraphAPI\Request\RequestObject\ViewsRequestObject;
use SSitdikov\TelegraphAPI\Request\RevokeAccessTokenRequest;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;

class TelegraphClientTest extends TestCase
{

    /**
     * @var Account
     */
    private $account;

    /**
     * @var Page
     */
    private $page;
    /**
     * @var MockObject
     */
    private $client;

    public function setUp()
    {
        $shortName = md5(time());
        $this->account = new Account();
        $this->account->setShortName($shortName);

        $title = md5(random_bytes(16));
        $content = md5(random_bytes(16));
        $this->page = new Page();
        $this->page->setTitle($title);
        $this->page->setContent([$content]);

        $this->client = $this->getMockBuilder(Client::class)->getMock();

    }

    /**
     * @test
     */
    public function createAccount()
    {

        $accessToken = md5(random_bytes(16));
        $authUrl = md5(random_bytes(16));

        $responseContent = [
            'ok' => true,
            'result' => [
                'short_name' => $this->account->getShortName(),
                'author_name' => '',
                'author_url' => '',
                'auth_url' => $authUrl,
                'access_token' => $accessToken,
            ]
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $account = $telegraph->createAccount(
            new CreateAccountRequest($this->account)
        );

        $this->assertEquals($account->getAccessToken(), $accessToken);
        $this->assertEquals($account->getAuthUrl(), $authUrl);
    }

    private function getTelegraph($responseContent): TelegraphClient
    {
        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        return new TelegraphClient($this->client);
    }

    /**
     * @test
     * @depends createAccount
     */
    public function createAccountError()
    {
        $responseContent = [
            'ok' => false,
            'error' => 'SomeStringError'
        ];
        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->createAccount(
            new CreateAccountRequest($this->account)
        );
    }

    /**
     * @test
     * @depends createAccountError
     */
    public function createAccountErrorNotRequiredFields()
    {
        $responseContent = [
            'ok' => false,
            'error' => 'SHORT_NAME_REQUIRED'
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(ShortNameRequiredException::class);
        $telegraph->createAccount(
            new CreateAccountRequest($this->account)
        );
    }

    /**
     * @test
     */
    public function getAccountInfo()
    {
        $authUrl = md5(random_bytes(16));
        $accessToken = md5($authUrl . random_bytes(16));
        $pageCount = random_int(100, 9999);
        $responseContent = [
            'ok' => true,
            'result' => [
                'short_name' => $this->account->getShortName(),
                'author_name' => '',
                'author_url' => '',
                'auth_url' => $authUrl,
                'access_token' => $accessToken,
                'page_count' => $pageCount,
            ]
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $account = $telegraph->getAccountInfo(
            new GetAccountInfoRequest($this->account)
        );

        $this->assertEquals($pageCount, $account->getPageCount());
    }

    /**
     * @test
     * @depends getAccountInfo
     */
    public function getAccountInfoError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->getAccountInfo(
            new GetAccountInfoRequest($this->account)
        );
    }

    /**
     * @test
     */
    public function editAccountInfo()
    {
        $authUrl = md5(random_bytes(16));
        $accessToken = md5($authUrl . random_bytes(16));
        $pageCount = random_int(100, 9999);
        $shortName = md5(random_bytes(16));
        $authorName = md5(random_bytes(16));
        $authorUrl = md5(random_bytes(16));
        $this->account->setShortName($shortName);
        $this->account->setAuthorName($authorName);
        $this->account->setAuthorUrl($authorUrl);
        $responseContent = [
            'ok' => true,
            'result' => [
                'short_name' => $this->account->getShortName(),
                'author_name' => $authorName,
                'author_url' => $authorUrl,
                'auth_url' => $authUrl,
                'access_token' => $accessToken,
                'page_count' => $pageCount,
            ]
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $account = $telegraph->editAccountInfo(
            new EditAccountInfoRequest($this->account)
        );

        $this->assertEquals($shortName, $account->getShortName());
        $this->assertEquals($authorName, $account->getAuthorName());
        $this->assertEquals($authorUrl, $account->getAuthorUrl());
    }

    /**
     * @test
     * @depends editAccountInfo
     */
    public function editAccountInfoError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->editAccountInfo(
            new EditAccountInfoRequest($this->account)
        );
    }

    /**
     * @test
     */
    public function revokeAccessToken()
    {
        $newAccessToken = md5(random_bytes(16));
        $accessToken = md5(random_bytes(16));
        $authUrl = md5(random_bytes(16));
        $this->account->setAccessToken($accessToken);
        $responseContent = [
            'ok' => true,
            'result' => [
                'access_token' => $newAccessToken,
                'auth_url' => $authUrl,
            ]
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $account = $telegraph->revokeAccessToken(
            new RevokeAccessTokenRequest($this->account)
        );

        $this->assertEquals($newAccessToken, $account->getAccessToken());
        $this->assertEquals($authUrl, $account->getAuthUrl());
    }

    /**
     * @test
     * @depends revokeAccessToken
     */
    public function revokeAccessTokenError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->revokeAccessToken(
            new RevokeAccessTokenRequest($this->account)
        );
    }

    /**
     * @test
     */
    public function createPage()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
            ]
        ];

        $request = new CreatePageRequest($this->page, $this->account);

        $returnContent = rand(0, 1) === 1 ? true : false;

        if ($returnContent) {
            $content = [
                ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
            ];
            $responseContent['result']['content'] = $content;
            $request->isReturnContent();
        }

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->createPage(
            $request
        );

        $this->assertEquals($title, $page->getTitle());
        $this->assertEquals($path, $page->getPath());
        $this->assertEquals($url, $page->getUrl());
        $this->assertEquals($description, $page->getDescription());
        $this->assertEquals($views, $page->getViews());
        $this->assertEquals($canEdit, $page->isCanEdit());
        $this->assertEquals($returnContent, $request->getReturnContent());
        if ($returnContent) {
            $this->assertJson(json_encode($content), json_encode($page->getContent()));
        }
    }

    /**
     * @test
     */
    public function createPageWithContent()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $imageUrl = md5(random_bytes(16));
        $content = [
            ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
        ];
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
                'content' => $content,
                'image_url' => $imageUrl,
            ]
        ];

        $request = new CreatePageRequest($this->page, $this->account);
        $request->isReturnContent();

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->createPage(
            $request
        );

        $this->assertJson(json_encode($content), json_encode($page->getContent()));
    }

    /**
     * @test
     * @depends createPage
     */
    public function createPageErrorContentRequired()
    {
        $errorString = 'CONTENT_TEXT_REQUIRED';
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(ContentTextRequired::class);
        $telegraph->createPage(
            new CreatePageRequest($this->page, $this->account)
        );
    }

    /**
     * @test
     * @depends createPageErrorContentRequired
     */
    public function createPageError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->createPage(
            new CreatePageRequest($this->page, $this->account)
        );
    }

    /**
     * @test
     */
    public function getPage()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $imageUrl = md5(random_bytes(16));
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
                'image_url' => $imageUrl,
            ]
        ];

        $request = new GetPageRequest($this->page, $this->account);

        $returnContent = rand(0, 1) === 1 ? true : false;

        if ($returnContent) {
            $content = [
                ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
            ];
            $responseContent['result']['content'] = $content;
            $request->isReturnContent();
        }

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->getPage(
            $request
        );

        $this->assertEquals($title, $page->getTitle());
        $this->assertEquals($path, $page->getPath());
        $this->assertEquals($url, $page->getUrl());
        $this->assertEquals($description, $page->getDescription());
        $this->assertEquals($views, $page->getViews());
        $this->assertEquals($canEdit, $page->isCanEdit());
        $this->assertEquals($imageUrl, $page->getImageUrl());
        $this->assertEquals($returnContent, $request->getReturnContent());
        if ($returnContent) {
            $this->assertJson(json_encode($content), json_encode($page->getContent()));
        }
    }

    /**
     * @test
     */
    public function getPageWithContent()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $imageUrl = md5(random_bytes(16));
        $content = [
            ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
        ];
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
                'content' => $content,
                'image_url' => $imageUrl,
            ]
        ];

        $request = new GetPageRequest($this->page, $this->account);
        $request->isReturnContent();

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->getPage(
            $request
        );

        $this->assertJson(json_encode($content), json_encode($page->getContent()));
    }

    /**
     * @test
     * @depends getPage
     */
    public function getPageError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->getPage(
            new GetPageRequest($this->page, $this->account)
        );
    }

    /**
     * @test
     */
    public function editPage()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $imageUrl = md5(random_bytes(16));
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
                'image_url' => $imageUrl,
            ]
        ];

        $request = new EditPageRequest($this->page, $this->account);

        $returnContent = rand(0, 1) === 1 ? true : false;

        if ($returnContent) {
            $content = [
                ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
            ];
            $responseContent['result']['content'] = $content;
            $request->isReturnContent();
        }

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->editPage(
            $request
        );

        $this->assertEquals($title, $page->getTitle());
        $this->assertEquals($path, $page->getPath());
        $this->assertEquals($url, $page->getUrl());
        $this->assertEquals($description, $page->getDescription());
        $this->assertEquals($views, $page->getViews());
        $this->assertEquals($canEdit, $page->isCanEdit());
        $this->assertEquals($imageUrl, $page->getImageUrl());
        $this->assertEquals($returnContent, $request->getReturnContent());
        if ($returnContent) {
            $this->assertJson(json_encode($content), json_encode($page->getContent()));
        }
    }

    /**
     * @test
     */
    public function editPageWithContent()
    {
        $title = md5(random_bytes(16));
        $path = md5(random_bytes(16));
        $url = md5(random_bytes(16));
        $description = md5(random_bytes(16));
        $views = random_int(1, 999);
        $canEdit = rand(0, 1) === 1 ? true : false;
        $imageUrl = md5(random_bytes(16));
        $content = [
            ['tag' => 'a', 'attrs' => ['href' => 'link'], 'children' => ['text']]
        ];
        $responseContent = [
            'ok' => true,
            'result' => [
                'title' => $title,
                'path' => $path,
                'url' => $url,
                'description' => $description,
                'views' => $views,
                'can_edit' => $canEdit,
                'content' => $content,
                'image_url' => $imageUrl,
            ]
        ];

        $authorName = md5(random_bytes(16));
        $authorUrl = md5(random_bytes(16));
        $this->page->setAuthorName($authorName);
        $this->page->setAuthorUrl($authorUrl);
        $request = new EditPageRequest($this->page, $this->account);
        $request->isReturnContent();

        $telegraph = $this->getTelegraph($responseContent);

        $page = $telegraph->editPage(
            $request
        );

        $this->assertJson(json_encode($content), json_encode($page->getContent()));
    }

    /**
     * @test
     */
    public function editPageError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->editPage(
            new EditPageRequest($this->page, $this->account)
        );
    }

    /**
     * @test
     */
    public function getPageList()
    {
        $totalCount = random_int(1, 999);
        $responseContent = [
            'ok' => true,
            'result' => [
            'pages' => [],
            'total_count' => $totalCount
                ]
        ];

        $telegraph = $this->getTelegraph($responseContent);
        $offset = random_int(1, 99);
        $limit = random_int(1, 99);
        $request = new GetPageListRequest($this->account, $offset, $limit);
        $pageList = $telegraph->getPageList(
            $request
        );

        $this->assertEquals([
            'json' => [
                'access_token' => $this->account->getAccessToken(),
                'limit' => $limit,
                'offset' => $offset,
            ]
        ], $request->getParams());

        $this->assertEquals($totalCount, $pageList->getTotalCount());
        /**
         * @todo Check pages result
         */
        $this->assertEquals([], $pageList->getPages());

        $request = new GetPageListRequest($this->account, 0, 250);
        $this->assertEquals([
            'json' => [
                'access_token' => $this->account->getAccessToken(),
                'limit' => 50,
                'offset' => 0,
            ]
        ], $request->getParams());
    }

    /**
     * @test
     */
    public function getPageListError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->getPageList(
            new GetPageListRequest($this->account, 0, 0)
        );
    }

    /**
     * @test
     */
    public function getPageViews()
    {
        $views = random_int(1, 99);
        $responseContent = [
            'ok' => true,
            'result' => [
                'views' => $views,
            ]
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $requestObject = new ViewsRequestObject();
        $path = md5(random_bytes(16));
        $year = random_int(2000,2017);
        $month = random_int(1, 12);
        $day = random_int(1, 30);
        $hour = random_int(0, 24);
        $requestObject->setPath($path);
        $requestObject->setYear($year);
        $requestObject->setMonth($month);
        $requestObject->setDay($day);
        $requestObject->setHour($hour);

        $request = new GetViewsRequest($requestObject);
        $this->assertEquals([
            'json' => [
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'hour' => $hour
            ]
        ], $request->getParams());

        $viewPage = $telegraph->getViews($request);
        $this->assertEquals($views, $viewPage->getViews());
    }

    /**
     * @test
     */
    public function getViewsError()
    {
        $errorString = md5(random_bytes(16));
        $responseContent = [
            'ok' => false,
            'error' => $errorString
        ];

        $telegraph = $this->getTelegraph($responseContent);

        $this->expectException(\Exception::class);
        $telegraph->getViews(
            new GetViewsRequest(
                new ViewsRequestObject()
            )
        );
    }

}
