![TravisCI Status](https://travis-ci.com/unl/oEmbedResource.svg?branch=1.x.x)

# oEmbed Resource

The `OembedResource` class generates JSON and XML resource payloads to return to oEmbed requests.

## Install

Install this package via composer:

``` bash
composer require unl/oembedresource
```

## Usage

``` php
use unl\OembedResource\OembedResource;
...
// Instantiate OembedResource class and add oEmbed parameters as properties.
$resource = new OembedResource('video');
$resource->setTitle('My Video');
$resource->setHtml('<iframe src="https://example.com/video/123/embed" title="My Video" allowfullscreen frameborder="0"></iframe>');
$resource->setWidth(940);
$resource->setHeight(549);
$resource_payload = $resource->generate();

// At this point, return an HTTP response.
header('Content-Type: application/json+oembed');
echo $resource_payload;
die();
```

## Instantiate OembedResource class

The constructor requires a 'type' parameter for the type of resource being requested. Valid types include: `photo`, `video`, `link`, and `rich`.

``` php
$resource = new OembedResource('video');
```

## Add oEmbed parameters as class properties

The class provides GETTER and SETTER methods:

``` php
// Type
// Required to instantiate class.
$type= $resource->getType();

// Title (string)
// Optional
$resource->setTitle('My Video');
$title = $resource->getTitle();

// Author Name (string)
// Optional
$resource->setAuthorName('Mark Twain');
$author_name = $resource->getAuthorName();

// Author URL (string)
// Optional
$resource->setAuthorUrl('https://www.my-oembed-provider-service.com/mtwain');
$author_url = $resource->getAuthorUrl();

// Provider Name (string)
// Optional
$resource->setProviderName('My oEmbed Provider');
$provider_name = $resource->getProviderName();

// Provider URL (string)
// Optional
$resource->setProviderUrl('https://www.my-oembed-provider-service.com');
$provider_url = $resource->getProviderUrl();

// Cache Age (int)
// Optional
$resource->setCacheAge(86400);
$cache_age = $resource->getCacheAge();

// Thumbnail URL (string)
// Optional (If any thumbnail oEmbed parameter is set, then all three must be set.)
$resource->setThumbnailUrl('https://www.my-oembed-provider-service.com/video/123/thumbnail.jpg');
$thumbnail_url = $resource->getThumbnailUrl();

// Thumbnail Width (int)
// Optional (If any thumbnail oEmbed parameter is set, then all three must be set.)
$resource->setThumbnailWidth(940);
$thumbnail_width = $resource->getThumbnailWidth();

// Thumbnail Height (int)
// Optional (If any thumbnail oEmbed parameter is set, then all three must be set.)
$resource->setThumbnailHeight(549);
$thumbnail_height = $resource->getThumbnailHeight();

// URL (string)
// Required for 'photo' resources.
$resource->setUrl('https://www.my-oembed-provider-service.com/photo/123.jpg');
$url = $resource->getUrl();

// Width (int)
// Required for 'photo', 'video', and 'rich' resources.
$resource->setWidth(940);
$width = $resource->getWidth();

// Height (int)
// Required for 'photo', 'video', and 'rich' resources.
$resource->setHeight(940);
$height = $resource->getHeight();

// HTML (string)
// Required for 'video' and 'rich' resources.
$resource->setHtml('<iframe src="https://example.com/video/123/embed" title="My Video" allowfullscreen frameborder="0"></iframe>');
$html = $resource->getHtml();

```

## Generate response payload

To convert the `OembedResource` object into a JSON or XML string, call the `generate()` method:

``` php
// By default, JSON is generated.
$json_payload = $resource->generate();
$json_payload = $resource->generate('json');

// XML can also be generated.
$xml_payload = $resource->generate('xml');

```

## Send the response to the client

One the payload string has been generated, it's up to the instantiating code to return an HTTP response to the client. Consult your PHP framework docs (Laravel, Symfony, etc.). 

A quick and dirty return is provided below for JSON and XML:

``` php
// Send JSON response.
$resource_payload = $resource->generate();
header('Content-Type: application/json+oembed');
echo $resource_payload;
die();
```

``` php
// Send XML response.
$resource_payload = $resource->generate('xml');
header('Content-Type: text/xml+oembed');
echo $resource_payload;
die();
```
