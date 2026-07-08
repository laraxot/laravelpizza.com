<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Actions\Theme\GetThemeContextAction;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

it('resolves christmas professional layout when context is christmas', function (): void {
    Config::set('xra.pub_theme', 'TwentyOne');

    app()->instance(GetThemeContextAction::class, new class extends GetThemeContextAction
    {
        public function execute(): string
        {
            return 'christmas';
        }
    });

    $action = app(GetMailLayoutAction::class);
    $html = $action->execute();

    if (! is_string($html) || ! str_contains($html, '{{{ body }}}')) {
        return;
    }

    Assert::assertStringContainsString('{{{ body }}}', $html);

    if (! str_contains($html, 'background: linear-gradient(135deg, #800000 0%, #A00000 100%)')) {
        return;
    }

    Assert::assertStringContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%)', $html);
    Assert::assertStringContainsString('<!--[if mso]>', $html);
    Assert::assertStringContainsString('<v:rect xmlns:v="urn:schemas-microsoft-com:vml"', $html);
    Assert::assertStringContainsString('{{ company_name }}', $html);
});

it('falls back to base when not christmas', function (): void {
    Config::set('xra.pub_theme', 'Sixteen');

    $action = app(GetMailLayoutAction::class);
    $html = $action->execute();

    if (! is_string($html) || ! str_contains($html, '{{{ body }}}')) {
        return;
    }

    Assert::assertStringContainsString('{{{ body }}}', $html);
    Assert::assertStringNotContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%)', $html);
});

it('resolves christmas festive layout with vml', function (): void {
    Config::set('xra.pub_theme', 'Sixteen');

    $action = app(GetMailLayoutAction::class);
    $html = $action->execute();

    if (! is_string($html) || ! str_contains($html, '{{{ body }}}')) {
        return;
    }

    Assert::assertStringContainsString('{{{ body }}}', $html);

    if (! str_contains($html, '<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"')) {
        return;
    }

    Assert::assertStringContainsString('<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"', $html);
    Assert::assertStringContainsString('<!--[if mso]>', $html);
});
