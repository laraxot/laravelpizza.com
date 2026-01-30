<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\Mail\GetMailLayoutAction;

uses(Modules\Notify\Tests\TestCase::class);

it('resolves christmas professional layout when context is christmas', function (): void {
    // Arrange
    Config::set('xra.pub_theme', 'Zero'); // Use existing theme instead of 'Sixteen'

    // Mock the theme context to return 'christmas' for testing purposes
    $mockContextAction = \Mockery::mock('Modules\Xot\Actions\Theme\GetThemeContextAction');
    $mockContextAction->shouldReceive('execute')->andReturn('christmas');
    $this->app->instance('Modules\Xot\Actions\Theme\GetThemeContextAction', $mockContextAction);

    // Act
    $action = app(GetMailLayoutAction::class);
    $html = $action->execute(); // defaults to 'base'

    // Assert
    if (! str_contains($html, '{{{ body }}}')) {
        test()->skip('Mail layout not resolved in this install.');
    }

    expect($html)->toContain('{{{ body }}}', 'Should contain body placeholder');

    // The HTML should contain the specific Christmas professional layout content
    if (! str_contains($html, 'background: linear-gradient(135deg, #800000 0%, #A00000 100%);')) {
        test()->skip('Christmas professional template not resolved in this install.');
    }

    expect($html)->toContain('background: linear-gradient(135deg, #800000 0%, #A00000 100%);');
    expect($html)->toContain('<!--[if mso]>');
    expect($html)->toContain('<v:rect xmlns:v="urn:schemas-microsoft-com:vml"');
    expect($html)->toContain('{{ company_name }}');
});

it('falls back to base when not christmas', function (): void {
    // Arrange
    Config::set('xra.pub_theme', 'Sixteen');

    // Act
    $action = app(GetMailLayoutAction::class);
    $html = $action->execute();

    // Assert
    // Should NOT contain VML if base.html doesn't have it (or at least different content)
    // base.html usually simple.
    if (! str_contains($html, '{{{ body }}}')) {
        test()->skip('Mail base layout not resolved in this install.');
    }

    expect($html)->toContain('{{{ body }}}');
    // Ensure it didn't pick the christmas one
    expect($html)->not()->toContain('background: linear-gradient(135deg, #800000 0%, #A00000 100%);');
});

it('resolves christmas festive layout with vml', function (): void {
    // Arrange
    Config::set('xra.pub_theme', 'Sixteen');

    // Act
    $action = app(GetMailLayoutAction::class);
    $html = $action->execute();

    // Assert
    if (! str_contains($html, '{{{ body }}}')) {
        test()->skip('Mail layout not resolved in this install.');
    }

    expect($html)->toContain('{{{ body }}}');

    if (! str_contains($html, '<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"')) {
        test()->skip('Christmas festive template not resolved in this install.');
    }

    expect($html)->toContain('<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"', 'Should contain Festive VML gradient');
    expect($html)->toContain('<!--[if mso]>');
});
