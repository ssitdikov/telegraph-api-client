<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Tests\Page;

use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Request\RequestInterface;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\ContentType\LinkType;
use SSitdikov\TelegraphAPI\Type\Page;

class CreatePageRequestTest extends TestCase
{

    /**
     * @test
     */
    public function simpleCreatePageRequest()
    {
        $title = md5(random_bytes(16));
        $accessToken = md5(random_bytes(16));
        $content = [];

        $page = new Page();
        $page->setTitle($title);
        $page->setContent($content);

        $account = new Account();
        $account->setAccessToken($accessToken);

        $request = new CreatePageRequest($page, $account);

        $this->assertEquals(RequestInterface::POST, $request->getMethod());
        $this->assertEquals('createPage', $request->getUrlRequest());

        $expectedParams = [
            'json' => [
                'access_token' => $accessToken,
                'title' => $title,
                'content' => $content,
            ]
        ];
        $this->assertEquals( $expectedParams, $request->getParams());
        $authorUrl = md5(random_bytes(16));
        $authorName = md5(random_bytes(16));

        $page->setAuthorUrl($authorUrl);
        $page->setAuthorName($authorName);

        $request = new CreatePageRequest($page, $account);

        $request->isReturnContent();
        $expectedParams = [
            'json' => [
                'access_token' => $accessToken,
                'title' => $title,
                'content' => $content,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
                'return_content' => true
            ]
        ];

        $this->assertEquals($expectedParams, $request->getParams());
    }

}
