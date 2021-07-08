<?php

namespace unl\OembedResource\Test;

use PHPUnit\Framework\TestCase;
use unl\OembedResource\OembedResource;

class OembedResourceTest extends TestCase
{
    /**
     * Tests valid resource types.
     */
    public function testResourceType(): void
    {
        $resource = new OembedResource('photo');
        $resource = new OembedResource('video');
        $resource = new OembedResource('link');
        $resource = new OembedResource('rich');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid resource type');
        $resource = new OembedResource('invalid');
    }

    /**
     * Tests valid response formats.
     */
    public function testResponseFormat(): void
    {
        $resource = new OembedResource('video');
        $resource->setWidth(320);
        $resource->setHeight(160);
        $resource->setHtml('<iframe></iframe>');

        $resource->generate();
        $resource->generate('json');
        $this->assertSame($resource->generate(), $resource->generate('json'));
        $resource->generate('xml');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid response format');
        $resource->generate('invalid');
    }

    /**
     * Tests setter and getter methods.
     */
    public function testSettersAndGetters(): void
    {
        $type = 'video';
        $resource = new OembedResource($type);

        $this->assertSame($type, $resource->getType());

        $title = 'My video';
        $resource->setTitle($title);
        $this->assertSame($title, $resource->getTitle());

        $author_name = 'John Smith';
        $resource->setAuthorName($author_name);
        $this->assertSame($author_name, $resource->getAuthorName());

        $author_url = 'https://example.com/author/jsmith';
        $resource->setAuthorUrl($author_name);
        $this->assertSame($author_name, $resource->getAuthorUrl());

        $provider_name = 'An Example oEmbed Provider';
        $resource->setProviderName($provider_name);
        $this->assertSame($provider_name, $resource->getProviderName());

        $provider_url = 'https://example.com';
        $resource->setProviderUrl($provider_url);
        $this->assertSame($provider_url, $resource->getProviderUrl());

        $cache_age = 86400;
        $resource->setCacheAge($cache_age);
        $this->assertSame($cache_age, $resource->getCacheAge());

        $thumbnail_url = 'https://example.com/video/123/thumbnail.jpg';
        $resource->setThumbnailUrl($thumbnail_url);
        $this->assertSame($thumbnail_url, $resource->getThumbnailUrl());

        $thumbnail_width = 320;
        $resource->setThumbnailWidth($thumbnail_width);
        $this->assertSame($thumbnail_width, $resource->getThumbnailWidth());

        $thumbnail_height = 160;
        $resource->setThumbnailHeight($thumbnail_height);
        $this->assertSame($thumbnail_height, $resource->getThumbnailHeight());

        $url = 'https://any-url.com';
        $resource->setUrl($url);
        $this->assertSame($url, $resource->getUrl());

        $width = 500;
        $resource->setWidth($width);
        $this->assertSame($width, $resource->getWidth());

        $height = 250;
        $resource->setHeight($height);
        $this->assertSame($height, $resource->getHeight());

        $html = '<iframe src="https://example.com/video/123/embed"></iframe>';
        $resource->setHtml($html);
        $this->assertSame($html, $resource->getHtml());
    }

    /**
     * Tests generation and validation of video resources.
     *
     * @dataProvider generationValuesProvider
     */
    public function testResourceGeneration($type, $exception, $exception_message, $parameters, $expected_payloads): void
    {
        if ($exception) {
            $this->expectException(\Exception::class);
            $this->expectExceptionMessage($exception_message);
        }

        $resource = new OembedResource($type);
        if (isset($parameters['title'])) {
            $resource->setTitle($parameters['title']);
        }
        if (isset($parameters['author_name'])) {
            $resource->setAuthorName($parameters['author_name']);
        }
        if (isset($parameters['author_url'])) {
            $resource->setAuthorUrl($parameters['author_url']);
        }
        if (isset($parameters['provider_name'])) {
            $resource->setProviderName($parameters['provider_name']);
        }
        if (isset($parameters['provider_url'])) {
            $resource->setProviderUrl($parameters['provider_url']);
        }
        if (isset($parameters['cache_age'])) {
            $resource->setCacheAge($parameters['cache_age']);
        }
        if (isset($parameters['thumbnail_url'])) {
            $resource->setThumbnailUrl($parameters['thumbnail_url']);
        }
        if (isset($parameters['thumbnail_width'])) {
            $resource->setThumbnailWidth($parameters['thumbnail_width']);
        }
        if (isset($parameters['thumbnail_height'])) {
            $resource->setThumbnailHeight($parameters['thumbnail_height']);
        }
        if (isset($parameters['url'])) {
            $resource->setUrl($parameters['url']);
        }
        if (isset($parameters['width'])) {
            $resource->setWidth($parameters['width']);
        }
        if (isset($parameters['height'])) {
            $resource->setHeight($parameters['height']);
        }
        if (isset($parameters['html'])) {
            $resource->setHtml($parameters['html']);
        }

        // When an exception is caught, then the test ceases at that point.
        $json_payload = $resource->generate();
        $this->assertNotnull($json_payload);
        $xml_payload = $resource->generate('xml');
        $this->assertNotnull($xml_payload);

        if ($expected_payloads['json']) {
            $this->assertSame($expected_payloads['json'], $json_payload);
        }
        if ($expected_payloads['xml']) {
            $this->assertSame($expected_payloads['xml'], $xml_payload);
        }
    }

    /**
     * Data provider for testResourceGeneration().
     */
    public function generationValuesProvider(): array
    {
        return [
            // Valid photo resource
            'photo:valid' => [
                'type' => 'photo',
                'exception' => false,
                'exception_message' => '',
                'parameters' => [
                    'url' => 'https://example.com/photo/123.jpg',
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Photo resource with missing URL parameter.
            'photo:missing_url_param' => [
                'type' => 'photo',
                'exception' => true,
                'exception_message' => 'URL parameter required for photo resource',
                'parameters' => [
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Photo resource with missing width parameter.
            'photo:missing_width_param' => [
                'type' => 'photo',
                'exception' => true,
                'exception_message' => 'Width parameter required for photo resource',
                'parameters' => [
                    'url' => 'https://example.com/photo/123.jpg',
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Photo resource with missing height parameter.
            'photo:missing_height_param' => [
                'type' => 'photo',
                'exception' => true,
                'exception_message' => 'Height parameter required for photo resource',
                'parameters' => [
                    'url' => 'https://example.com/photo/123.jpg',
                    'width' => 320,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Valid video resource with all parameters populated.
            'photo:output' => [
                'type' => 'photo',
                'exception' => false,
                'exception_message' => null,
                'parameters' => [
                    'html' => '<iframe</iframe>', // Should not render.
                    'width' => 320,
                    'height' => 160,
                    'title' => 'My video',
                    'author_name' => 'John Smith',
                    'author_url' => 'https://example.com/author/jsmith',
                    'provider_name' => 'An Example oEmbed Provider',
                    'provider_url' => 'https://example.com',
                    'cache_age' => 86400,
                    'thumbnail_url' => 'https://example.com/photo/123/thumbnail.jpg',
                    'thumbnail_width' => 320,
                    'thumbnail_height' => 160,
                    'url' => 'https://example.com/photo/123.jpg',
                ],
                'expected_payloads' => [
                    // phpcs:disable Generic.Files.LineLength
                    'json' => '{"type":"photo","version":"1.0","title":"My video","author_name":"John Smith","author_url":"https:\/\/example.com\/author\/jsmith","provider_name":"An Example oEmbed Provider","provider_url":"https:\/\/example.com","cache_age":86400,"thumbnail_url":"https:\/\/example.com\/photo\/123\/thumbnail.jpg","thumbnail_width":320,"thumbnail_height":160,"url":"https:\/\/example.com\/photo\/123.jpg","width":320,"height":160}',
                    'xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oembed><type>photo</type><version>1.0</version><title>My video</title><author_name>John Smith</author_name><author_url>https://example.com/author/jsmith</author_url><provider_name>An Example oEmbed Provider</provider_name><provider_url>https://example.com</provider_url><cache_age>86400</cache_age><thumbnail_url>https://example.com/photo/123/thumbnail.jpg</thumbnail_url><thumbnail_width>320</thumbnail_width><thumbnail_height>160</thumbnail_height><url>https://example.com/photo/123.jpg</url><width>320</width><height>160</height></oembed>
',
                    // phpcs:enable
                ],
            ],
            // Valid video resource.
            'video:valid' => [
                'type' => 'video',
                'exception' => false,
                'exception_message' => '',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Video resource with missing HTML parameter.
            'video:missing_html_param' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'HTML parameter required for video resource',
                'parameters' => [
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Video resource with missing width parameter.
            'video:missing_width_param' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'Width parameter required for video resource',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Video resource with missing height parameter.
            'video:missing_height_param' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'Height parameter required for video resource',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Valid video resource with all parameters populated.
            'video:output' => [
                'type' => 'video',
                'exception' => false,
                'exception_message' => null,
                'parameters' => [
                    'html' => '<iframe src="https://example.com/video/123/embed"></iframe>',
                    'width' => 320,
                    'height' => 160,
                    'title' => 'My video',
                    'author_name' => 'John Smith',
                    'author_url' => 'https://example.com/author/jsmith',
                    'provider_name' => 'An Example oEmbed Provider',
                    'provider_url' => 'https://example.com',
                    'cache_age' => 86400,
                    'thumbnail_url' => 'https://example.com/video/123/thumbnail.jpg',
                    'thumbnail_width' => 320,
                    'thumbnail_height' => 160,
                    'url' => 'https://any-url.com', // Should not render.
                ],
                'expected_payloads' => [
                    // phpcs:disable Generic.Files.LineLength
                    'json' => '{"type":"video","version":"1.0","title":"My video","author_name":"John Smith","author_url":"https:\/\/example.com\/author\/jsmith","provider_name":"An Example oEmbed Provider","provider_url":"https:\/\/example.com","cache_age":86400,"thumbnail_url":"https:\/\/example.com\/video\/123\/thumbnail.jpg","thumbnail_width":320,"thumbnail_height":160,"width":320,"height":160,"html":"<iframe src=\"https:\/\/example.com\/video\/123\/embed\"><\/iframe>"}',
                    'xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oembed><type>video</type><version>1.0</version><title>My video</title><author_name>John Smith</author_name><author_url>https://example.com/author/jsmith</author_url><provider_name>An Example oEmbed Provider</provider_name><provider_url>https://example.com</provider_url><cache_age>86400</cache_age><thumbnail_url>https://example.com/video/123/thumbnail.jpg</thumbnail_url><thumbnail_width>320</thumbnail_width><thumbnail_height>160</thumbnail_height><width>320</width><height>160</height><html><![CDATA[<iframe src="https://example.com/video/123/embed"></iframe>]]></html></oembed>
',
                    // phpcs:enable
                ],
            ],
            // Video resource with missing thumbnail url parameter.
            'video:empty_thumbnail_url' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'Thumbnail URL is required',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                    'height' => 160,
                    'thumbnail_width' => 320,
                    'thumbnail_height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Video resource with missing thumbnail width parameter.
            'video:empty_thumbnail_width' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'Thumbnail Width is required',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                    'height' => 160,
                    'thumbnail_url' => 'https://example.com/video/123/thumbnail.jpg',
                    'thumbnail_height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Video resource with missing thumbnail height parameter.
            'video:empty_thumbnail_height' => [
                'type' => 'video',
                'exception' => true,
                'exception_message' => 'Thumbnail Height is required',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                    'height' => 160,
                    'thumbnail_url' => 'https://example.com/video/123/thumbnail.jpg',
                    'thumbnail_width' => 320,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Valid link resource with all parameters populated.
            'link:output' => [
                'type' => 'link',
                'exception' => false,
                'exception_message' => null,
                'parameters' => [
                    'html' => '<iframe src="https://example.com/video/123/embed"></iframe>', // Should not render.
                    'width' => 320, // Should not render.
                    'height' => 160, // Should not render.
                    'title' => 'My link',
                    'author_name' => 'John Smith',
                    'author_url' => 'https://example.com/author/jsmith',
                    'provider_name' => 'An Example oEmbed Provider',
                    'provider_url' => 'https://example.com',
                    'cache_age' => 86400,
                    'thumbnail_url' => 'https://example.com/thumbnails/link-123.jpg',
                    'thumbnail_width' => 320,
                    'thumbnail_height' => 160,
                    'url' => 'https://any-url.com', // Should not render.
                ],
                'expected_payloads' => [
                    // phpcs:disable Generic.Files.LineLength
                    'json' => '{"type":"link","version":"1.0","title":"My link","author_name":"John Smith","author_url":"https:\/\/example.com\/author\/jsmith","provider_name":"An Example oEmbed Provider","provider_url":"https:\/\/example.com","cache_age":86400,"thumbnail_url":"https:\/\/example.com\/thumbnails\/link-123.jpg","thumbnail_width":320,"thumbnail_height":160}',
                    'xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oembed><type>link</type><version>1.0</version><title>My link</title><author_name>John Smith</author_name><author_url>https://example.com/author/jsmith</author_url><provider_name>An Example oEmbed Provider</provider_name><provider_url>https://example.com</provider_url><cache_age>86400</cache_age><thumbnail_url>https://example.com/thumbnails/link-123.jpg</thumbnail_url><thumbnail_width>320</thumbnail_width><thumbnail_height>160</thumbnail_height></oembed>
',
                    // phpcs:enable
                 ],
            ],
            // Valid rich resource.
            'rich:valid' => [
                'type' => 'rich',
                'exception' => false,
                'exception_message' => '',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Rich resource with missing HTML parameter.
            'rich:missing_html_param' => [
                'type' => 'rich',
                'exception' => true,
                'exception_message' => 'HTML parameter required for rich resource',
                'parameters' => [
                    'width' => 320,
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Rich resource with missing width parameter.
            'rich:missing_width_param' => [
                'type' => 'rich',
                'exception' => true,
                'exception_message' => 'Width parameter required for rich resource',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'height' => 160,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Rich resource with missing height parameter.
            'rich:missing_height_param' => [
                'type' => 'rich',
                'exception' => true,
                'exception_message' => 'Height parameter required for rich resource',
                'parameters' => [
                    'html' => '<iframe></iframe>',
                    'width' => 320,
                ],
                'expected_payloads' => [
                    'json' => null,
                    'xml' => null,
                ],
            ],
            // Valid rich resource with all parameters populated.
            'rich:output' => [
                'type' => 'rich',
                'exception' => false,
                'exception_message' => null,
                'parameters' => [
                    'html' => '<iframe src="https://example.com/rich/123/embed"></iframe>',
                    'width' => 320,
                    'height' => 160,
                    'title' => 'My video',
                    'author_name' => 'John Smith',
                    'author_url' => 'https://example.com/author/jsmith',
                    'provider_name' => 'An Example oEmbed Provider',
                    'provider_url' => 'https://example.com',
                    'cache_age' => 86400,
                    'thumbnail_url' => 'https://example.com/rich/123/thumbnail.jpg',
                    'thumbnail_width' => 320,
                    'thumbnail_height' => 160,
                    'url' => 'https://any-url.com', // Should not render.
                ],
                'expected_payloads' => [
                    // phpcs:disable Generic.Files.LineLength
                    'json' => '{"type":"rich","version":"1.0","title":"My video","author_name":"John Smith","author_url":"https:\/\/example.com\/author\/jsmith","provider_name":"An Example oEmbed Provider","provider_url":"https:\/\/example.com","cache_age":86400,"thumbnail_url":"https:\/\/example.com\/rich\/123\/thumbnail.jpg","thumbnail_width":320,"thumbnail_height":160,"width":320,"height":160,"html":"<iframe src=\"https:\/\/example.com\/rich\/123\/embed\"><\/iframe>"}',
                    'xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oembed><type>rich</type><version>1.0</version><title>My video</title><author_name>John Smith</author_name><author_url>https://example.com/author/jsmith</author_url><provider_name>An Example oEmbed Provider</provider_name><provider_url>https://example.com</provider_url><cache_age>86400</cache_age><thumbnail_url>https://example.com/rich/123/thumbnail.jpg</thumbnail_url><thumbnail_width>320</thumbnail_width><thumbnail_height>160</thumbnail_height><width>320</width><height>160</height><html><![CDATA[<iframe src="https://example.com/rich/123/embed"></iframe>]]></html></oembed>
',
                    // phpcs:enable
                ],
            ],
        ];
    }
}
