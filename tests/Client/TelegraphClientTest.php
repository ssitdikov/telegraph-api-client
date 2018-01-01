<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Tests\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use SSitdikov\TelegraphAPI\Client\TelegraphClient;
use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Exception\ShortNameRequiredException;
use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Type\Account;

class TelegraphClientTest extends TestCase
{

    /**
     * @var Account
     */
    private $account;
    /**
     * @var MockObject
     */
    private $client;

    public function setUp()
    {
        $shortName = md5(time());
        $this->account = new Account();
        $this->account->setShortName($shortName);

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
        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        $telegraph = new TelegraphClient($this->client);
        $account = $telegraph->createAccount(
            new CreateAccountRequest($this->account)
        );

        $this->assertEquals($account->getAccessToken(), $accessToken);
        $this->assertEquals($account->getAuthUrl(), $authUrl);
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
        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        $telegraph = new TelegraphClient($this->client);

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

        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        $telegraph = new TelegraphClient($this->client);

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

        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        $telegraph = new TelegraphClient($this->client);

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

        $response = new Response(200, [], json_encode($responseContent));
        $this->client->expects($this->once())->method('request')->willReturn($response);

        $telegraph = new TelegraphClient($this->client);

        $this->expectException(\Exception::class);
        $telegraph->getAccountInfo(
            new GetAccountInfoRequest($this->account)
        );
    }

}
