<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type;

class PageViews
{
    /**
     * @var int
     */
    private $views;

    public function __construct(int $views)
    {
        $this->setViews($views);
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     */
    public function setViews(int $views)
    {
        $this->views = $views;
    }
}
