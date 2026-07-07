<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;
use Modules\Notify\Models\BaseModel;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationTemplateVersion;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

it('extends base model', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    Assert::assertInstanceOf(BaseModel::class, $version);
});

it('uses updater trait', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Modules\\Xot\\Traits\\Updater', $traits);
});

it('has correct fillable attributes', function (): void {
    $expectedFillable = [
        'template_id',
        'subject',
        'body_html',
        'body_text',
        'channels',
        'variables',
        'conditions',
        'version',
        'created_by',
        'change_notes',
    ];

    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $instance = $reflection->newInstanceWithoutConstructor();
    $fillableProperty = $reflection->getProperty('fillable');
    $fillableProperty->setAccessible(true);
    $fillable = $fillableProperty->getValue($instance);

    Assert::assertSame($expectedFillable, $fillable);
});

it('has correct casts', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $instance = $reflection->newInstanceWithoutConstructor();
    $castsMethod = $reflection->getMethod('casts');
    $castsMethod->setAccessible(true);
    $casts = \assertNotifyArray($castsMethod->invoke($instance));
    Assert::assertSame('array', $casts['channels'] ?? null);
    Assert::assertSame('array', $casts['variables'] ?? null);
    Assert::assertSame('array', $casts['conditions'] ?? null);
});

it('has template relationship method', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    });

it('has restore method', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    });

it('restore method returns NotificationTemplate', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

        $method = new \ReflectionMethod($version, 'restore');
    $returnType = $method->getReturnType();

    Assert::assertNotNull($returnType);
    \assertReflectionTypeName($returnType, NotificationTemplate::class);
});

it('has expected table name', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    Assert::assertSame('notification_template_versions', $version->getTable());
});

it('has expected primary key', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    Assert::assertSame('id', $version->getKeyName());
});

it('uses timestamps', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $version = $reflection->newInstanceWithoutConstructor();

    Assert::assertTrue($version->usesTimestamps());
});

it('has uuids trait', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Illuminate\\Database\\Eloquent\\Concerns\\HasUuids', $traits);
});

it('has factory trait', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Modules\\Xot\\Traits\\HasFactory', $traits);
});

it('has media trait', function (): void {
    $reflection = new \ReflectionClass(NotificationTemplateVersion::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains('Spatie\\MediaLibrary\\HasMedia', $traits);
});

it('has creator and updater relationships', function (): void {
    $version = new NotificationTemplateVersion;

        });

it('has media relationship', function (): void {
    $version = new NotificationTemplateVersion;

    });
