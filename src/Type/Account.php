<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type;

class Account
{
    /**
     * @var string
     * @desc Length 1-32
     */
    private $shortName = '';
    /**
     * @var string
     * @desc Length 0-128
     */
    private $authorName = '';
    /**
     * @var string
     * @desc Length 0-512
     */
    private $authorUrl = '';
    private $accessToken = '';
    private $authUrl = '';
    private $pageCount = 0;

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorUrl(): string
    {
        return $this->authorUrl;
    }

    /**
     * @param string $authorUrl
     */
    public function setAuthorUrl(string $authorUrl)
    {
        $this->authorUrl = $authorUrl;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->authUrl;
    }

    /**
     * @param string $authUrl
     */
    public function setAuthUrl(string $authUrl)
    {
        $this->authUrl = $authUrl;
    }

    /**
     * @return int
     */
    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * @param int $pageCount
     */
    public function setPageCount(int $pageCount)
    {
        $this->pageCount = $pageCount;
    }
}
