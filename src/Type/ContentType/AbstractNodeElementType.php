<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class AbstractNodeElementType implements NodeElementTypeInterface
{
    protected $tag;
    protected $attrs = [];
    protected $children = [];

    public function jsonSerialize()
    {
        $result = [
            'tag' => $this->tag,
        ];
        if (!empty($this->attrs)) {
            $result['attrs'] = $this->attrs;
        }
        if (!empty($this->children)) {
            $result['children'] = $this->children;
        }
        return $result;
    }
}
