<?php

namespace SSitdikov\TelegraphAPI\Tests\Page;

use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Type\ContentType\ImageType;
use SSitdikov\TelegraphAPI\Type\ContentType\LinkType;
use SSitdikov\TelegraphAPI\Type\ContentType\NodeElementType;
use SSitdikov\TelegraphAPI\Type\ContentType\ParagraphType;
use SSitdikov\TelegraphAPI\Type\ContentType\YoutubeType;

class ContentTypesTest extends TestCase
{

    /**
     * @test
     */
    public function linkType()
    {
        $link = new LinkType();
        $link->setText('Test link');
        $link->setHref('https://github.com');

        $this->assertJson(json_encode([
            'tag' => 'a',
            'attrs' => ['href' => 'https://github.com'],
            'children' => ['Test link']
        ]), json_encode($link));
    }

    /**
     * @test
     */
    public function imageType()
    {
        $image = new ImageType();
        $image->setSrc('https://github.com/logo.png');

        $this->assertJson(json_encode([
            'tag' => 'img',
            'attrs' => [
                'src' => 'https://github.com/logo.png',
            ]
        ]), json_encode($image));

        $image->setCaption('Test caption');

        $this->assertJson(json_encode([
            'tag' => 'figure',
            'children' => [
                [
                    'tag' => 'img',
                    'attrs' => ['src' => 'https://github.com/logo.png'],
                ],
                [
                    'tag' => 'figcaption',
                    'children' => [
                        'Test caption'
                    ]
                ]
            ]
        ]), json_encode($image));
    }

    /**
     * @test
     */
    public function paragraphType()
    {
        $paragraph = new ParagraphType();
        $paragraph->setText('Test');

        $this->assertJson(
            json_encode([
                'tag' => 'p',
                'children' => [
                    'Test'
                ]
            ]),
            json_encode($paragraph)
        );

        $paragraph->addContentElement(
            $paragraph
        );

        $this->assertJson(
            json_encode([
                'tag' => 'p',
                'children' => [
                    'Test',
                    [
                        'tag' => 'p',
                        'children' => [
                            'Test'
                        ]
                    ]
                ]
            ]),
            json_encode($paragraph)
        );
    }

    /**
     * @test
     */
    public function youtubeType()
    {
        $youtube = new YoutubeType();
        $youtube->setSrc('test');
        $youtube->setCaption('Caption');

        $this->assertJson(
            json_encode([
                'tag' => 'figure',
                'children' => [
                    [
                        'tag' => 'iframe',
                        'attrs' => [
                            'src' => 'test',
                        ]
                    ],
                    [
                        'tag' => 'figcaption',
                        'children' => [
                            'Caption'
                        ]
                    ]
                ]
            ]),
            json_encode($youtube)
        );
    }

    /**
     * @test
     */
    public function nodeElementType()
    {
        $node = new NodeElementType();
        $node->setTag('em');
        $node->setChildren(['test']);
        $node->addChildren('rest');

        $this->assertJson(json_encode([
            'tag' => 'em',
            'children' => [
                'test', 'rest'
            ]
        ]),
            json_encode($node));
    }
}
