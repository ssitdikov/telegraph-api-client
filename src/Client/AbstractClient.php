<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Client;

use SSitdikov\TelegraphAPI\Request\CreateAccountRequest;
use SSitdikov\TelegraphAPI\Request\CreatePageRequest;
use SSitdikov\TelegraphAPI\Request\EditAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\EditPageRequest;
use SSitdikov\TelegraphAPI\Request\GetAccountInfoRequest;
use SSitdikov\TelegraphAPI\Request\GetPageListRequest;
use SSitdikov\TelegraphAPI\Request\GetPageRequest;
use SSitdikov\TelegraphAPI\Request\GetViewsRequest;
use SSitdikov\TelegraphAPI\Request\RevokeAccessTokenRequest;
use SSitdikov\TelegraphAPI\Type\Account;
use SSitdikov\TelegraphAPI\Type\Page;
use SSitdikov\TelegraphAPI\Type\PageList;
use SSitdikov\TelegraphAPI\Type\PageViews;

/**
 * Class AbstractClient
 *
 * @author Salavat Sitdikov <sitsalavat@gmail.com>
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * Request for account creation
     *
     * @param CreateAccountRequest $request Create account request
     *
     * @return Account
     */
    abstract public function createAccount(CreateAccountRequest $request): Account;

    /**
     * Edit account information request
     *
     * @param EditAccountInfoRequest $request Request
     *
     * @return Account
     */
    abstract public function editAccountInfo(EditAccountInfoRequest $request): Account;

    /**
     * Get account information
     *
     * @param GetAccountInfoRequest $request Request
     *
     * @return Account
     */
    abstract public function getAccountInfo(GetAccountInfoRequest $request): Account;

    /**
     * Revoke access token request
     *
     * @param RevokeAccessTokenRequest $request Request
     *
     * @return Account
     */
    abstract public function revokeAccessToken(RevokeAccessTokenRequest $request): Account;

    /**
     * Create page request
     *
     * @param CreatePageRequest $request Request
     *
     * @return Page
     */
    abstract public function createPage(CreatePageRequest $request): Page;

    /**
     * Get information about page
     *
     * @param GetPageRequest $request Request
     *
     * @return Page
     */
    abstract public function getPage(GetPageRequest $request): Page;

    /**
     * Edit page request
     *
     * @param EditPageRequest $request Request
     *
     * @return Page
     */
    abstract public function editPage(EditPageRequest $request): Page;

    /**
     * Page list request
     *
     * @param GetPageListRequest $request Request
     *
     * @return PageList
     */
    abstract public function getPageList(GetPageListRequest $request): PageList;

    /**
     * Get page views request
     *
     * @param GetViewsRequest $request Request
     *
     * @return PageViews
     */
    abstract public function getViews(GetViewsRequest $request): PageViews;
}
