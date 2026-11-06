<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Actions\Robots;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('closes every private area in every supported locale', function (): void {
    $lines = explode("\n", app(BuildRobotsTxtAction::class)->execute());

    foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
        foreach (BuildRobotsTxtAction::PRIVATE_SEGMENTS as $segment) {
            Assert::assertContains('Disallow: /'.$locale.'/'.$segment, $lines);
        }
    }
    Assert::assertContains('Disallow: /*/admin', $lines);
});

it('declares the sitemap with an absolute url and ends with a newline', function (): void {
    $robots = app(BuildRobotsTxtAction::class)->execute();

    Assert::assertStringStartsWith("User-agent: *\n", $robots);
    Assert::assertStringContainsString("\nSitemap: ".url('/sitemap.xml')."\n", $robots);
    Assert::assertStringEndsWith("\n", $robots);
});

it('serves plain text', function (): void {
    $response = app(BuildRobotsTxtAction::class)();

    Assert::assertSame(200, $response->getStatusCode());
    Assert::assertStringStartsWith('text/plain', (string) $response->headers->get('Content-Type'));
});
