<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Cms\Actions\Head\ResolveWrittenLocalesAction;
use PHPUnit\Framework\Assert;

test('written locales keep only the languages with a non-empty title', function (): void {
    $action = new ResolveWrittenLocalesAction();

    Assert::assertSame(['it', 'en'], $action->fromRaw('{"it":"Home","en":"Home page","de":"","es":"   "}'));
    Assert::assertSame(['it'], $action->fromRaw(['it' => 'Home', 'en' => null]));
});

test('written locales mean no restriction when the title is not a language map', function (): void {
    $action = new ResolveWrittenLocalesAction();

    Assert::assertNull($action->fromRaw('Home'));
    Assert::assertNull($action->fromRaw('{non json'));
    Assert::assertNull($action->fromRaw(null));
});

test('a language counts as written only when its content exists too, not just its title', function (): void {
    $action = new ResolveWrittenLocalesAction();
    $title = '{"it":"Servizi","en":"Services"}';

    Assert::assertSame(['it'], $action->fromRaw($title, '{"it":[{"type":"content"}]}'));
    Assert::assertSame(['it'], $action->fromRaw($title, ['it' => [['type' => 'content']], 'en' => []]));
    Assert::assertSame(['it', 'en'], $action->fromRaw($title, ['it' => [['type' => 'content']], 'en' => [['type' => 'content']]]));
});

test('a language with only a hero block is not written: it would be a thin page paired by hreflang to a full one', function (): void {
    $action = new ResolveWrittenLocalesAction();
    $title = '{"it":"Chi siamo","en":"About us"}';

    Assert::assertSame(['it'], $action->fromRaw($title, ['it' => [['type' => 'hero'], ['type' => 'values']], 'en' => [['type' => 'hero']]]));
    Assert::assertSame([], $action->fromRaw($title, ['it' => [['type' => 'hero']], 'en' => [['type' => 'hero'], ['type' => 'hero']]]));
});

test('a block without a readable type counts as body content, so unknown block shapes never hide a page', function (): void {
    $action = new ResolveWrittenLocalesAction();
    $title = '{"it":"Servizi","en":"Services"}';

    Assert::assertSame(['it', 'en'], $action->fromRaw($title, ['it' => [['type' => 'hero'], 'plain html'], 'en' => [['data' => ['x' => 1]]]]));
});

test('content that is not split by language does not restrict the written languages', function (): void {
    $action = new ResolveWrittenLocalesAction();
    $title = '{"it":"Servizi","en":"Services"}';

    Assert::assertSame(['it', 'en'], $action->fromRaw($title, [['type' => 'hero']]));
    Assert::assertSame(['it', 'en'], $action->fromRaw($title, null));
    Assert::assertSame(['it', 'en'], $action->fromRaw($title, 'plain html'));
});

test('robots policy hides every private area listed once for head, sitemap and robots.txt', function (): void {
    $policy = new ResolveRobotsPolicyAction();

    foreach (ResolveRobotsPolicyAction::HIDDEN_SEGMENTS as $segment) {
        Assert::assertFalse($policy->isIndexable('en/'.$segment.'/anything', ['it', 'en']), $segment);
    }

    Assert::assertTrue($policy->isIndexable('en/faq', ['it', 'en']));
    Assert::assertTrue($policy->isIndexable('', ['it', 'en']));
});
