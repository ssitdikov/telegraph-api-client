<?php

namespace SSitdikov\TelegraphAPI\Tests\Account;

use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Request\RequestInterface;
use SSitdikov\TelegraphAPI\Type\Account;

class CreateAccountRequestTest extends TestCase
{

    /**
     * @test
     */
    public function simpleCreateAccount()
    {
        $account = new Account();
        $shortName = md5(random_bytes(16));
        $authorName = md5(random_bytes(16));
        $authorUrl = md5(random_bytes(16));
        $account->setShortName($shortName);
        $account->setAuthorName($authorName);
        $account->setAuthorUrl($authorUrl);
        $request = new CreateAccountRequest($account);

        $this->assertEquals(RequestInterface::POST, $request->getMethod());
        $this->assertEquals('createAccount', $request->getUrlRequest());
        $expectedParams = [
            'json' => [
                'short_name' => $shortName,
                'author_name' => $authorName,
                'author_url' => $authorUrl,
            ]
        ];
        $this->assertEquals($expectedParams, $request->getParams());
    }


}
