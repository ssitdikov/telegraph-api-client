<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type\ContentType;

interface NodeElementTypeInterface extends \JsonSerializable
{
    public function jsonSerialize();
}
