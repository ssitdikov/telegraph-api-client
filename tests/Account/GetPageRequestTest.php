<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Tests\Account;

use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\RequestInterface;
use SSitdikov\TelegraphAPI\Type\Account;

class GetPageRequestTest extends TestCase
{
    /**
     * @test
     */
    public function simpleGetAccountInfo()
    {
        $account = new Account();
        $accessToken = md5(random_bytes(16));
        $account->setAccessToken($accessToken);
        $request = new GetAccountInfoRequest($account);
        $request->setAccountFields(['short_name', 'author_name', 'author_url', 'auth_url', 'page_count']);

        $this->assertEquals(RequestInterface::POST, $request->getMethod());
        $this->assertEquals('getAccountInfo', $request->getUrlRequest());
        $expectedParams = [
            'json' => [
                'access_token' => $accessToken,
                'fields' => [
                    'short_name',
                    'author_name',
                    'author_url',
                    'auth_url',
                    'page_count',
                ],
            ],
        ];
        $this->assertEquals($expectedParams, $request->getParams());
    }
}
