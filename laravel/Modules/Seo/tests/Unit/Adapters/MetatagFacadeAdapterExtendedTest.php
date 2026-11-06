<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Adapters;

use Modules\Seo\Adapters\MetatagFacadeAdapter;
use PHPUnit\Framework\Assert;

uses(\Modules\Seo\Tests\TestCase::class);

it('sets all optional seo fields through adapter', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $published = now()->subDay();
    $modified = now();

    $adapter->setImage('https://example.test/image.png');
    $adapter->setLocale('it');
    $adapter->setType('article');
    $adapter->setSiteName('LaravelPizza');
    $adapter->setUrl('https://example.test/post');
    $adapter->setAuthor('Mario');
    $adapter->setPublishedTime($published);
    $adapter->setModifiedTime($modified);

    $meta = $adapter->get();

    Assert::assertSame('https://example.test/image.png', $meta->getImage());
    Assert::assertSame('it', $meta->getLocale());
    Assert::assertSame('article', $meta->getType());
    Assert::assertSame('LaravelPizza', $meta->getSiteName());
    Assert::assertSame('https://example.test/post', $meta->getUrl());
    Assert::assertSame('Mario', $meta->getAuthor());
    Assert::assertSame($published->format('c'), $meta->getPublishedTime()?->format('c'));
    Assert::assertSame($modified->format('c'), $meta->getModifiedTime()?->format('c'));
});
