<?php

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class NodeElementType extends AbstractNodeElementType
{
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function addChildren($child)
    {
        $this->children[] = $child;
    }
}