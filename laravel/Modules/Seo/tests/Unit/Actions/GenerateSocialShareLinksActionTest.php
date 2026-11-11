<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Actions;

use Modules\Seo\Actions\GenerateSocialShareLinksAction;
use Modules\Seo\Datas\SocialShareData;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('generates social share links for all platforms', function (): void {
    $data = SocialShareData::from([
        'url' => 'https://example.com/page',
        'title' => 'Test Title',
        'text' => 'Check this out',
    ]);

    $links = app(GenerateSocialShareLinksAction::class)->execute($data);

    foreach (['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy'] as $key) {
        Assert::assertArrayHasKey($key, $links);
    }
    Assert::assertStringContainsString(urlencode('https://example.com/page'), (string) $links['facebook']);
    Assert::assertSame('https://example.com/page', $links['copy']);
});

it('includes via and hashtags in twitter link when provided', function (): void {
    $data = SocialShareData::from([
        'url' => 'https://example.com',
        'via' => 'myhandle',
        'hashtags' => 'laravel,php',
    ]);

    $links = app(GenerateSocialShareLinksAction::class)->execute($data);

    Assert::assertStringContainsString('via='.urlencode('myhandle'), (string) $links['twitter']);
    Assert::assertStringContainsString('hashtags='.urlencode('laravel,php'), (string) $links['twitter']);
});
