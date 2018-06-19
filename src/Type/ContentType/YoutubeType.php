<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class YoutubeType extends AbstractNodeElementType
{
    protected $tag = 'figure';

    public function setSrc($src)
    {
        $element = [
            'tag' => 'iframe',
            'attrs' => [
                'src' => '/embed/youtube?url='.rawurlencode($src),
            ],
        ];
        $this->children = [$element];
    }

    public function setCaption($caption)
    {
        $this->children[] = [
            'tag' => 'figcaption',
            'children' => [
                $caption,
            ],
        ];
    }
}
