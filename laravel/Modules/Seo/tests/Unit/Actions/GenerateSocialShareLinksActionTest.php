<?php

declare(strict_types=1);

use Modules\Seo\Actions\GenerateSocialShareLinksAction;
use Modules\Seo\Data\SocialShareData;
use Tests\TestCase;

uses(TestCase::class);

it('generates social share links for all platforms', function () {
    $data = SocialShareData::from([
        'url' => 'https://example.com/page',
        'title' => 'Test Title',
        'text' => 'Check this out',
    ]);

    $action = new GenerateSocialShareLinksAction();
    $links = $action->execute($data);

    expect($links)->toBeArray()
        ->toHaveKeys(['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy'])
        ->and($links['facebook'])->toContain(urlencode('https://example.com/page'))
        ->and($links['copy'])->toBe('https://example.com/page');
});

it('includes via and hashtags in twitter link when provided', function () {
    $data = SocialShareData::from([
        'url' => 'https://example.com',
        'via' => 'myhandle',
        'hashtags' => 'laravel,php',
    ]);

    $action = new GenerateSocialShareLinksAction();
    $links = $action->execute($data);

    expect($links['twitter'])->toContain('via='.urlencode('myhandle'))
        ->and($links['twitter'])->toContain('hashtags='.urlencode('laravel,php'));
});
