<?php

namespace unl\OembedResource;

/**
 * A class that generates an oEmbed resource to be returned to an oEmbed request.
 *
 * The instantiating code is responsible for returning the formatted resource as an HTTP response.
 *
 * @see https://oembed.com/
 */
class OembedResource
{

    /**
     * The resource type.
     *
     * @var string
     */
    protected $type;

    /**
     * The oEmbed version number.
     *
     * @var string
     */
    protected $version = '1.0';

    /**
     * A text title, describing the resource.
     *
     * @var string
     */
    protected $title;

    /**
     * The name of the author/owner of the resource.
     *
     * @var string
     */
    protected $author_name;

    /**
     * A URL for the author/owner of the resource.
     *
     * @var string
     */
    protected $author_url;

    /**
     * The name of the resource provider.
     *
     * @var string
     */
    protected $provider_name;

    /**
     * The url of the resource provider.
     *
     * @var string
     */
    protected $provider_url;

    /**
     * The suggested cache lifetime for this resource, in seconds.
     *
     * @var int
     */
    protected $cache_age;

    /**
     * A URL to a thumbnail image representing the resource.
     *
     * @var string
     */
    protected $thumbnail_url;

    /**
     * The width of the optional thumbnail (in pixels).
     *
     * @var int
     */
    protected $thumbnail_width;

    /**
     * The height of the optional thumbnail (in pixels).
     *
     * @var int
     */
    protected $thumbnail_height;

    /**
     * The URL of the resource.
     *
     * @var string
     */
    protected $url;

    /**
     * The resource width (in pixels).
     *
     * @var int
     */
    protected $width;

    /**
     * The resource height (in pixels).
     *
     * @var int
     */
    protected $height;

    /**
     * The HTML required to display the resource.
     *
     * @var string
     */
    protected $html;

    /**
     * Resource types.
     *
     * @var array
     */
    protected $resource_types = [
      'photo',
      'video',
      'link',
      'rich',
    ];

    /**
     * Response formats.
     *
     * @var array
     */
    protected $response_formats = ['json', 'xml'];

    /**
     * Constructs an OembedResource object.
     *
     * @param string $type
     *   The resource type.
     */
    public function __construct($type)
    {
        if (!in_array($type, $this->resource_types)) {
            throw new \Exception('Invalid resource type');
        }
        $this->type = $type;
    }

    /**
     * Sets the "type" parameter.
     *
     * @return string
     *   The "type" parameter.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the "title" parameter.
     *
     * @param string $title
     *   The "title" parameter.
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Gets the "title" parameter.
     *
     * @return string
     *   The "title" parameter.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the "author_name" parameter.
     *
     * @param string $author_name
     *   The "author_name" parameter.
     */
    public function setAuthorName(string $author_name)
    {
        $this->author_name = $author_name;
    }

    /**
     * Gets the "author_name" parameter.
     *
     * @return string
     *   The "author_name" parameter.
     */
    public function getAuthorName()
    {
        return $this->author_name;
    }

    /**
     * Sets the "author_url" parameter.
     *
     * @param string $author_url
     *   The "author_url" parameter.
     */
    public function setAuthorUrl(string $author_url)
    {
        $this->author_url = $author_url;
    }

    /**
     * Gets the "author_url" parameter.
     *
     * @return string
     *   The "author_url" parameter.
     */
    public function getAuthorUrl()
    {
        return $this->author_url;
    }

    /**
     * Sets the "provider_name" parameter.
     *
     * @param string $provider_name
     *   The "provider_name" parameter.
     */
    public function setProviderName(string $provider_name)
    {
        $this->provider_name = $provider_name;
    }

    /**
     * Gets the "provider_name" parameter.
     *
     * @return string
     *   The "provider_name" parameter.
     */
    public function getProviderName()
    {
        return $this->provider_name;
    }

    /**
     * Sets the "provider_url" parameter.
     *
     * @param string $provider_url
     *   The "provider_url" parameter.
     */
    public function setProviderUrl(string $provider_url)
    {
        $this->provider_url = $provider_url;
    }

    /**
     * Gets the "provider_url" parameter.
     *
     * @return string
     *   The "provider_url" parameter.
     */
    public function getProviderUrl()
    {
        return $this->provider_url;
    }

    /**
     * Sets the "cache_age" parameter.
     *
     * @param string $cache_age
     *   The "cache_age" parameter (in seconds).
     */
    public function setCacheAge(int $cache_age)
    {
        $this->cache_age = $cache_age;
    }

    /**
     * Gets the "cache_age" parameter.
     *
     * @return int
     *   The "cache_age" parameter (in seconds).
     */
    public function getCacheAge()
    {
        return $this->cache_age;
    }

    /**
     * Sets the "thumbnail_url" parameter.
     *
     * @param string $thumbnail_url
     *   The "thumbnail_url" parameter.
     */
    public function setThumbnailUrl(string $thumbnail_url)
    {
        $this->thumbnail_url = $thumbnail_url;
    }

    /**
     * Gets the "thumbnail_url" parameter.
     *
     * @return string
     *   The "thumbnail_url" parameter.
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnail_url;
    }

    /**
     * Sets the "thumbnail_width" parameter.
     *
     * @param string $thumbnail_width
     *   The "thumbnail_width" parameter (in pixels).
     */
    public function setThumbnailWidth(int $thumbnail_width)
    {
        $this->thumbnail_width = $thumbnail_width;
    }

    /**
     * Gets the "thumbnail_width" parameter.
     *
     * @return int
     *   The "thumbnail_width" parameter (in pixels).
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnail_width;
    }

    /**
     * Sets the "thumbnail_height" parameter.
     *
     * @param string $thumbnail_height
     *   The "thumbnail_height" parameter.
     */
    public function setThumbnailHeight(int $thumbnail_height)
    {
        $this->thumbnail_height = $thumbnail_height;
    }

    /**
     * Gets the "thumbnail_height" parameter.
     *
     * @return int
     *   The "thumbnail_height" parameter (in pixels).
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnail_height;
    }

    /**
     * Sets the "url" parameter.
     *
     * @param string $url
     *   The "url" parameter.
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Gets the "url" parameter.
     *
     * @return string
     *   The "url" parameter.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the "width" parameter.
     *
     * @param string $width
     *   The "width" parameter.
     */
    public function setWidth(int $width)
    {
        $this->width = $width;
    }

    /**
     * Gets the "width" parameter.
     *
     * @return int
     *   The "width" parameter.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the "height" parameter.
     *
     * @param string $height
     *   The "height" parameter.
     */
    public function setHeight(int $height)
    {
        $this->height = $height;
    }

    /**
     * Gets the "height" parameter.
     *
     * @return int
     *   The "height" parameter.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the "html" parameter.
     *
     * @param string $html
     *   The "html" parameter.
     */
    public function setHtml(string $html)
    {
        $this->html = $html;
    }

    /**
     * Gets the "html" parameter.
     *
     * @return string
     *   The "html" parameter.
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Validates the resource object.
     */
    protected function validateResource()
    {
        switch ($this->type) {
            case 'photo':
                if (empty($this->url)) {
                    throw new \Exception('URL parameter required for photo resource');
                } elseif (empty($this->width)) {
                    throw new \Exception('Width parameter required for photo resource');
                } elseif (empty($this->height)) {
                    throw new \Exception('Height parameter required for photo resource');
                }
                break;
            case 'video':
                if (empty($this->html)) {
                    throw new \Exception('HTML parameter required for video resource');
                } elseif (empty($this->width)) {
                    throw new \Exception('Width parameter required for video resource');
                } elseif (empty($this->height)) {
                    throw new \Exception('Height parameter required for video resource');
                }
                break;
            case 'link':
                // No required parameters specifically for 'link' resources.
                break;
            case 'rich':
                if (empty($this->html)) {
                    throw new \Exception('HTML parameter required for rich resource');
                } elseif (empty($this->width)) {
                    throw new \Exception('Width parameter required for rich resource');
                } elseif (empty($this->height)) {
                    throw new \Exception('Height parameter required for rich resource');
                }
                break;
        }

        // If any thumbnail parameter is specified, then all three are required.
        if (
            !empty($this->thumbnail_url)
            || !empty($this->thumbnail_width)
            || !empty($this->thumbnail_height)
        ) {
            if (empty($this->thumbnail_url)) {
                throw new \Exception('Thumbnail URL is required');
            } elseif (empty($this->thumbnail_width)) {
                throw new \Exception('Thumbnail Width is required');
            } elseif (empty($this->thumbnail_height)) {
                throw new \Exception('Thumbnail Height is required');
            }
        }
    }

    /**
     * Generates a formatted version of the resource.
     *
     * @param string $format
     *   The response format ("json" or "xml").
     *
     * @return string
     *   The formatted resource.
     */
    public function generate($format = 'json')
    {
        if (!in_array($format, $this->response_formats)) {
            throw new \Exception('Invalid response format');
        }
        $this->validateResource();

        $payload = [];
        $payload['type'] = $this->type;
        $payload['version'] = $this->version;
        if (!empty($this->title)) {
            $payload['title'] = $this->title;
        }
        if (!empty($this->author_name)) {
            $payload['author_name'] = $this->author_name;
        }
        if (!empty($this->author_url)) {
            $payload['author_url'] = $this->author_url;
        }
        if (!empty($this->provider_name)) {
            $payload['provider_name'] = $this->provider_name;
        }
        if (!empty($this->provider_url)) {
            $payload['provider_url'] = $this->provider_url;
        }
        if (!empty($this->cache_age)) {
            $payload['cache_age'] = $this->cache_age;
        }
        if (!empty($this->thumbnail_url)) {
            $payload['thumbnail_url'] = $this->thumbnail_url;
        }
        if (!empty($this->thumbnail_width)) {
            $payload['thumbnail_width'] = $this->thumbnail_width;
        }
        if (!empty($this->thumbnail_height)) {
            $payload['thumbnail_height'] = $this->thumbnail_height;
        }
        if ($this->type == 'photo' && !empty($this->url)) {
            $payload['url'] = $this->url;
        }
        if (
            in_array($this->type, ['photo', 'video', 'rich'])
            && !empty($this->width)
        ) {
            $payload['width'] = $this->width;
        }
        if (
            in_array($this->type, ['photo', 'video', 'rich'])
            && !empty($this->height)
        ) {
            $payload['height'] = $this->height;
        }
        if (
            in_array($this->type, ['video', 'rich'])
            && !empty($this->html)
        ) {
            $payload['html'] = $this->html;
        }

        if ($format == 'json') {
            return json_encode($payload);
        } elseif ($format == 'xml') {
            $root = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?><oembed></oembed>";
            $xml = new \SimpleXMLElement($root);
            foreach ($payload as $key => $value) {
                if ($key !== 'html') {
                    $xml->addChild($key, $value);
                } else {
                    $this->addChildWithCData($key, $value, $xml);
                }
            }
            return $xml->asXml();
        }
    }

    /**
     * Adds a CDATA-formatted child element to an SimpleXMLElement element.
     *
     * @param string $name
     *   Name of property that should contain CDATA.
     * @param string $value
     *   Value that should be formatted as CDATA.
     * @param \SimpleXMLElement $xml
     *   The XML element.
     */
    protected function addChildWithCData($name, $value, $xml)
    {
        $new = $xml->addChild($name);
        $base = dom_import_simplexml($new);
        $docOwner = $base->ownerDocument;
        $base->appendChild($docOwner->createCDATASection($value));
    }
}
