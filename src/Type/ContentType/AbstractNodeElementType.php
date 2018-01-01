<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class AbstractNodeElementType implements NodeElementTypeInterface
{

    protected $tag;
    protected $attrs = [];
    protected $children = [];

    public function jsonSerialize()
    {
        return [
            'tag' => $this->tag,
            'attrs' => $this->attrs,
            'children' => $this->children,
        ];
    }
}