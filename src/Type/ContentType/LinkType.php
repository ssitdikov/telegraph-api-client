<?php

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class LinkType extends AbstractNodeElementType
{
    protected $tag = 'a';

    public function setHref($href)
    {
        $this->attrs['href'] = $href;
    }

    public function setText($text)
    {
        $this->children = [$text];
    }
}