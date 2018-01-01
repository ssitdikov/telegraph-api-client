<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Type\ContentType;


class ImageType extends AbstractNodeElementType
{
    protected $tag = 'img';

    public function setSrc($src)
    {
        $this->attrs['src'] = $src;
    }

    public function setCaption($caption)
    {
        $this->tag = 'figure';

        $image = [
            'tag' => 'img',
            'attrs' => [
                'src' => $this->attrs['src']
            ]
        ];
        $this->attrs = [];

        $captionElement = [
            'tag' => 'figcaption',
            'children' => [
                $caption
            ]
        ];

        $this->children = [
            $image,
            $captionElement
        ];
    }
}