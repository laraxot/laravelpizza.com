<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Notify\Models\BaseModel;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationTemplateVersion;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Tests\XotBasePest;
use Modules\Xot\Traits\Updater;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use function Safe\class_implements;

uses(TestCase::class);
/*
 * Scopo: ogni versione salvata di un NotificationTemplate e' un modello Notify con tracking
 * creator/updater e media, che sa ripristinare il template d'origine con restoreTemplate().
 * Allineato al model reale: il ripristino e' restoreTemplate() (non restore()), la factory e'
 * HasXotFactory (non Modules\Xot\Traits\HasFactory), HasMedia e' un'interfaccia, nessun HasUuids.
 */
describe('Notification Template Version', function (): void {
    test('extends base model', function (): void {
        $parent = (new ReflectionClass(NotificationTemplateVersion::class))->getParentClass();

        Assert::assertNotFalse($parent);
        Assert::assertSame(BaseModel::class, $parent->getName());
    });

    test('uses updater, xot factory and media traits', function (): void {
        $traits = class_uses_recursive(NotificationTemplateVersion::class);

        Assert::assertContains(Updater::class, $traits);
        Assert::assertContains(HasXotFactory::class, $traits);
        Assert::assertContains(InteractsWithMedia::class, $traits);
        Assert::assertContains(HasMedia::class, class_implements(NotificationTemplateVersion::class));
    });

    test('has correct fillable attributes', function (): void {
        Assert::assertSame([
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
        ], (new NotificationTemplateVersion)->getFillable());
    });

    test('casts channels, variables and conditions to array', function (): void {
        $casts = (new NotificationTemplateVersion)->getCasts();

        Assert::assertSame('array', $casts['channels']);
        Assert::assertSame('array', $casts['variables']);
        Assert::assertSame('array', $casts['conditions']);
    });

    test('declares template() as a belongsTo relation', function (): void {
        $method = new ReflectionMethod(NotificationTemplateVersion::class, 'template');

        XotBasePest::assertReflectionTypeName($method->getReturnType(), BelongsTo::class);
    });

    test('restoreTemplate returns the notification template', function (): void {
        $method = new ReflectionMethod(NotificationTemplateVersion::class, 'restoreTemplate');

        XotBasePest::assertReflectionTypeName($method->getReturnType(), NotificationTemplate::class);
    });

    test('exposes creator, updater and media relationships', function (): void {
        $reflection = new ReflectionClass(NotificationTemplateVersion::class);

        foreach (['creator', 'updater', 'media'] as $relation) {
            Assert::assertTrue($reflection->hasMethod($relation), $relation);
        }
    });

    test('has expected table name, primary key and timestamps', function (): void {
        $version = new NotificationTemplateVersion;

        Assert::assertSame('notification_template_versions', $version->getTable());
        Assert::assertSame('id', $version->getKeyName());
        Assert::assertTrue($version->usesTimestamps());
    });
});
