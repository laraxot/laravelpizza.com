<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Services;

use Modules\Seo\Services\MetatagService;
use PHPUnit\Framework\Assert;

it('sets all optional seo fields through service', function (): void {
    $service = new MetatagService();
    $published = now()->subDay();
    $modified = now();

    $service->setImage('https://example.test/image.png');
    $service->setLocale('it');
    $service->setType('article');
    $service->setSiteName('LaravelPizza');
    $service->setUrl('https://example.test/post');
    $service->setAuthor('Mario');
    $service->setPublishedTime($published);
    $service->setModifiedTime($modified);

    $meta = $service->get();

    Assert::assertSame('https://example.test/image.png', $meta->getImage());
    Assert::assertSame('it', $meta->getLocale());
    Assert::assertSame('article', $meta->getType());
    Assert::assertSame('LaravelPizza', $meta->getSiteName());
    Assert::assertSame('https://example.test/post', $meta->getUrl());
    Assert::assertSame('Mario', $meta->getAuthor());

    $publishedTime = $meta->getPublishedTime();
    $modifiedTime = $meta->getModifiedTime();
    Assert::assertNotNull($publishedTime);
    Assert::assertNotNull($modifiedTime);
    Assert::assertSame($published->format('c'), $publishedTime->format('c'));
    Assert::assertSame($modified->format('c'), $modifiedTime->format('c'));
});
