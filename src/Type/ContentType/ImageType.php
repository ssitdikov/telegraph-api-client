<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Type\ContentType;

class ImageType extends AbstractNodeElementType
{
    protected $tag = 'img';

    /**
     * Caption text.
     *
     * @var string Caption
     */
    private $caption = '';

    /**
     * Set image source.
     *
     * @param string $src Image source path
     */
    public function setSrc(string $src): void
    {
        $this->attrs['src'] = $src;
    }

    /**
     * Set image caption.
     *
     * @param string $caption Image caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    public function jsonSerialize()
    {
        $this->tag = 'figure';

        $image = [
            'tag'   => 'img',
            'attrs' => [
                'src' => $this->attrs['src'],
            ],
        ];

        $imageDiv = [
            'tag'   => 'div',
            'attrs' => [
                'class' => 'figure_wrapper',
            ],
            'children' => [
                $image,
            ],
        ];

        $this->attrs = [];

        $children = [
            $imageDiv,
        ];

        if ($this->caption) {
            $captionElement = [
                'tag'      => 'figcaption',
                'children' => [
                    $this->caption,
                ],
            ];
            $children[] = $captionElement;
        }

        $this->children = $children;

        return parent::jsonSerialize();
    }
}
