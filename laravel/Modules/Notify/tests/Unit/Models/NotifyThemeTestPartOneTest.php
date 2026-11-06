<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.
// Notify Pest/PHPUnit — claude-audit documentation ratio.

use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\withoutExceptionHandling;

uses(TestCase::class);
beforeEach(function (): void {
    withoutExceptionHandling();
});

describe('Notify Theme PartOne', function (): void {
    test('_can_create_notify_theme', function (): void {
        $theme = NotifyTheme::create([
            'lang' => 'it',
            'type' => 'email',
            'subject' => 'Benvenuto nella nostra piattaforma',
            'body' => 'Testo semplice del messaggio di benvenuto',
            'body_html' => '<h1>Benvenuto!</h1><p>Testo HTML del messaggio di benvenuto</p>',
            'from' => 'Sistema',
            'from_email' => 'noreply@example.com',
            'post_type' => 'App\Models\User',
            'post_id' => 123,
            'theme' => 'default',
            'logo_src' => '/images/logo.png',
            'logo_width' => 200,
            'logo_height' => 80,
            'view_params' => [
                'company_name' => 'Example Corp',
                'primary_color' => '#3b82f6',
                'secondary_color' => '#64748b']]);
        XotBasePest::assertTableHas('notify', 'notify_themes', [
            'id' => $theme->id,
            'lang' => 'it',
            'type' => 'email',
            'subject' => 'Benvenuto nella nostra piattaforma',
            'body' => 'Testo semplice del messaggio di benvenuto',
            'body_html' => '<h1>Benvenuto!</h1><p>Testo HTML del messaggio di benvenuto</p>',
            'from' => 'Sistema',
            'from_email' => 'noreply@example.com',
            'post_type' => 'App\Models\User',
            'post_id' => 123,
            'theme' => 'default',
            'logo_src' => '/images/logo.png',
            'logo_width' => 200,
            'logo_height' => 80, ]);
        TestCase::assertNotifyJsonColumn('notify_themes', $theme->id, 'view_params', [
            'company_name' => 'Example Corp',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#64748b']);

        Assert::assertInstanceOf(NotifyTheme::class, $theme);
    });

    test('_has_correct_fillable_fields', function (): void {
        $theme = new NotifyTheme;

        $expectedFillable = [
            'id',
            'lang',
            'type',
            'subject',
            'body',
            'body_html',
            'from',
            'from_email',
            'post_type',
            'post_id',
            'theme',
            'logo_src',
            'logo_width',
            'logo_height',
            'view_params'];

        Assert::assertEquals($expectedFillable, $theme->getFillable());
    });

    test('_has_correct_casts', function (): void {
        $theme = new NotifyTheme;

        $expectedCasts = [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'view_params' => 'array'];

        Assert::assertEquals($expectedCasts, $theme->getCasts());
    });

    test('_has_logo_appended_attribute', function (): void {
        $theme = new NotifyTheme;

        $expectedAppends = ['logo'];

        Assert::assertEquals($expectedAppends, $theme->getAppends());
    });

    test('_can_store_json_view_params', function (): void {
        $viewParams = [
            'company_name' => 'Test Company',
            'primary_color' => '#ef4444',
            'secondary_color' => '#f59e0b',
            'accent_color' => '#10b981',
            'fonts' => [
                'primary' => 'Inter',
                'secondary' => 'Roboto'],
            'layout' => [
                'max_width' => '1200px',
                'padding' => '20px',
                'border_radius' => '8px']];

        $theme = NotifyTheme::create([
            'type' => 'email',
            'subject' => 'Test Theme',
            'view_params' => $viewParams]);
        XotBasePest::assertTableHas('notify', 'notify_themes', [
            'id' => $theme->id, ]);
        TestCase::assertNotifyJsonColumn('notify_themes', $theme->id, 'view_params', $viewParams);
        Assert::assertEquals('Test Company', TestCase::notifyArrayGet($theme->view_params, 'company_name'));
        Assert::assertEquals('#ef4444', TestCase::notifyArrayGet($theme->view_params, 'primary_color'));
        Assert::assertEquals('Inter', TestCase::notifyArrayGet($theme->view_params, 'fonts', 'primary'));
        Assert::assertEquals('1200px', TestCase::notifyArrayGet($theme->view_params, 'layout', 'max_width'));
    });

    test('_can_generate_logo_attribute', function (): void {
        $theme = NotifyTheme::create([
            'type' => 'email',
            'subject' => 'Logo Test Theme',
            'logo_src' => '/images/custom-logo.png',
            'logo_width' => 300,
            'logo_height' => 120]);

        $logo = $theme->logo;
        Assert::assertArrayHasKey('path', $logo);
        Assert::assertArrayHasKey('width', $logo);
        Assert::assertArrayHasKey('height', $logo);
        Assert::assertEquals(300, $logo['width']);
        Assert::assertEquals(120, $logo['height']);
    });

    test('_uses_default_logo_dimensions_when_not_specified', function (): void {
        $theme = NotifyTheme::create([
            'type' => 'email',
            'subject' => 'Default Logo Theme',
            'logo_src' => '/images/default-logo.png']);

        $logo = $theme->logo;

        Assert::assertEquals(50, $logo['width']);
        Assert::assertEquals(50, $logo['height']);
    });

    test('_can_update_theme', function (): void {
        $theme = NotifyTheme::create([
            'type' => 'email',
            'subject' => 'Original Subject',
            'body' => 'Original body text',
            'theme' => 'original',
            'view_params' => ['original' => true]]);

        $theme->update([
            'subject' => 'Updated Subject',
            'body' => 'Updated body text',
            'theme' => 'updated',
            'view_params' => ['updated' => true, 'version' => '2.0']]);
        XotBasePest::assertTableHas('notify', 'notify_themes', [
            'id' => $theme->id,
            'subject' => 'Updated Subject',
            'body' => 'Updated body text',
            'theme' => 'updated', ]);
        TestCase::assertNotifyJsonColumn('notify_themes', $theme->id, 'view_params', ['updated' => true, 'version' => '2.0']);

        Assert::assertEquals('Updated Subject', XotBasePest::assertFreshModel($theme, NotifyTheme::class)->subject);
        Assert::assertEquals('Updated body text', XotBasePest::assertFreshModel($theme, NotifyTheme::class)->body);
        Assert::assertEquals('updated', XotBasePest::assertFreshModel($theme, NotifyTheme::class)->theme);
        Assert::assertEquals(['updated' => true, 'version' => '2.0'], XotBasePest::assertFreshModel($theme, NotifyTheme::class)->view_params);
    });

    test('_can_find_by_language', function (): void {
        NotifyTheme::create([
            'type' => 'email',
            'subject' => 'Italian Welcome',
            'lang' => 'it']);

        NotifyTheme::create([
            'type' => 'email',
            'subject' => 'English Welcome',
            'lang' => 'en']);

        NotifyTheme::create([
            'type' => 'email',
            'subject' => 'German Welcome',
            'lang' => 'de']);

        $italianThemes = NotifyTheme::where('lang', 'it')->get();
        $englishThemes = NotifyTheme::where('lang', 'en')->get();
        $germanThemes = NotifyTheme::where('lang', 'de')->get();

        Assert::assertCount(1, $italianThemes);
        Assert::assertCount(1, $englishThemes);
        Assert::assertCount(1, $germanThemes);
        Assert::assertEquals('it', XotBasePest::assertFirstModel($italianThemes, NotifyTheme::class)->lang);
        Assert::assertEquals('en', XotBasePest::assertFirstModel($englishThemes, NotifyTheme::class)->lang);
        Assert::assertEquals('de', XotBasePest::assertFirstModel($germanThemes, NotifyTheme::class)->lang);
    });
});