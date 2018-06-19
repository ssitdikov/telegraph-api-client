<?php

declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Tests\Page;

use PHPUnit\Framework\TestCase;
use SSitdikov\TelegraphAPI\Type\ContentType\ImageType;
use SSitdikov\TelegraphAPI\Type\ContentType\LinkType;
use SSitdikov\TelegraphAPI\Type\ContentType\ParagraphType;
use SSitdikov\TelegraphAPI\Type\ContentType\YoutubeType;
use SSitdikov\TelegraphAPI\Type\Page;

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
            'tag'      => 'a',
            'attrs'    => ['href' => 'https://github.com'],
            'children' => ['Test link'],
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
            'tag'   => 'img',
            'attrs' => [
                'src' => 'https://github.com/logo.png',
            ],
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
                'tag'      => 'p',
                'children' => [
                    'Test',
                ],
            ]),
            json_encode($paragraph)
        );

        $paragraph->addContentElement(
            clone $paragraph
        );

        $this->assertJson(
            json_encode([
                'tag'      => 'p',
                'children' => [
                    'Test',
                    [
                        'tag'      => 'p',
                        'children' => [
                            'Test',
                        ],
                    ],
                ],
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
                'tag'      => 'figure',
                'children' => [
                    [
                        'tag'   => 'iframe',
                        'attrs' => [
                            'src' => 'test',
                        ],
                    ],
                    [
                        'tag'      => 'figcaption',
                        'children' => [
                            'Caption',
                        ],
                    ],
                ],
            ]),
            json_encode($youtube)
        );
    }

    /**
     * @test
     */
    public function lastImageIssue()
    {
        $result = '[{"tag":"p","children":["First line"]},{"tag":"figure","children":[{"tag":"div","attrs":{"class":"figure_wrapper"},"children":[{"tag":"img","attrs":{"src":"http:\/\/telegra.ph\/file\/54c7e357b3062eb4c1d3a.png"}}]},{"tag":"figcaption","children":["reboot fax"]}]},{"tag":"p","children":["first picture"]},{"tag":"p","children":["second picture"]}]';

        $text = new ParagraphType();
        $text->setText('First line');

        $image = new ImageType();
        $image->setSrc('http://telegra.ph/file/54c7e357b3062eb4c1d3a.png');
        $image->setCaption('reboot fax');

        $text2 = new ParagraphType();
        $text2->setText('first picture');

        $text3 = new ParagraphType();
        $text3->setText('second picture');

        $page = new Page();
        $page->setContent([$text, $image, $text2, $text3]);

        $this->assertEquals($result, \json_encode($page->getContent()));
    }
}
