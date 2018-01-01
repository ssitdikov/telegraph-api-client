<?php

namespace SSitdikov\TelegraphAPI\Type\ContentType;

interface NodeElementTypeInterface extends \JsonSerializable
{
    public function jsonSerialize();
}