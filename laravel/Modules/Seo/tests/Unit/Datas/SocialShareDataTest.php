<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Datas;

use Modules\Seo\Datas\SocialShareData;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('creates instance with required url', function (): void {
    $data = new SocialShareData(url: 'https://laravelpizza.com');

    Assert::assertSame('https://laravelpizza.com', $data->url);
    Assert::assertNull($data->title);
    Assert::assertNull($data->text);
    Assert::assertNull($data->image);
    Assert::assertNull($data->hashtags);
    Assert::assertNull($data->via);
});

it('has default platforms list', function (): void {
    $data = new SocialShareData(url: 'https://laravelpizza.com');

    Assert::assertSame(
        ['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy'],
        $data->platforms,
    );
});

it('accepts all optional fields', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com/events/laravel-pizza-1',
        title: 'Laravel Pizza Meetup',
        text: 'Join us for pizza and Laravel!',
        image: 'https://laravelpizza.com/images/og.png',
        hashtags: 'laravel,php,meetup',
        via: 'laravelpizza',
        platforms: ['twitter', 'linkedin'],
    );

    Assert::assertSame('https://laravelpizza.com/events/laravel-pizza-1', $data->url);
    Assert::assertSame('Laravel Pizza Meetup', $data->title);
    Assert::assertSame('Join us for pizza and Laravel!', $data->text);
    Assert::assertSame('https://laravelpizza.com/images/og.png', $data->image);
    Assert::assertSame('laravel,php,meetup', $data->hashtags);
    Assert::assertSame('laravelpizza', $data->via);
    Assert::assertSame(['twitter', 'linkedin'], $data->platforms);
});

it('can override platforms with custom list', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com',
        platforms: ['twitter'],
    );

    Assert::assertSame(['twitter'], $data->platforms);
    Assert::assertCount(1, $data->platforms);
});

it('serializes to array via Spatie Data', function (): void {
    $data = new SocialShareData(
        url: 'https://laravelpizza.com',
        title: 'Laravel Pizza',
    );

    $array = $data->toArray();

    Assert::assertArrayHasKey('url', $array);
    Assert::assertSame('https://laravelpizza.com', $array['url']);
    Assert::assertArrayHasKey('title', $array);
    Assert::assertSame('Laravel Pizza', $array['title']);
});
