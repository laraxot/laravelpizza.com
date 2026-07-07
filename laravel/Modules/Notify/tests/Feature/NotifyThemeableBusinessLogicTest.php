<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Notify\Database\Factories\NotifyThemeableFactory;
use Modules\Notify\Database\Factories\NotifyThemeFactory;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Models\NotifyThemeable;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('Notify Themeable Business Logic', function () {
    it('can create notify themeable with basic information', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeableData = [
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme->id,
            'created_by' => 'admin@'.(string) config('app.domain', 'example.com'),
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ];

        $themeable = NotifyThemeable::create($themeableData);

        Assert::assertSame('App\Models\NotificationTemplate', $themeable->model_type);
        Assert::assertSame(123, $themeable->model_id);
        Assert::assertSame($theme->id, $themeable->notify_theme_id);
    });

    it('can manage polymorphic relationships', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeable = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\EmailTemplate',
            'model_id' => 456,
            'notify_theme_id' => $theme->id,
        ]);

        Assert::assertSame('App\Models\EmailTemplate', $themeable->model_type);
        Assert::assertSame(456, $themeable->model_id);
        Assert::assertInstanceOf(MorphTo::class, $themeable->morphTo());
    });

    it('can handle different model types', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $modelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushTemplate',
            'App\Models\WhatsappTemplate',
        ];

        foreach ($modelTypes as $index => $modelType) {
            $themeable = NotifyThemeableFactory::new()->createOne([
                'model_type' => $modelType,
                'model_id' => $index + 1,
                'notify_theme_id' => $theme->id,
            ]);

            Assert::assertSame($modelType, $themeable->model_type);
            Assert::assertSame($index + 1, $themeable->model_id);
        }
    });

    it('can manage theme relationships', function () {
        $appName = (string) config('app.name', 'Platform');
        $themeLabel = $appName.' Professional';
        $theme = NotifyThemeFactory::new()->createOne([
            'subject' => $themeLabel,
            'body' => 'Tema professionale per '.$appName,
        ]);

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $theme->id,
        ]);

        $linkedTheme = \notifyThemeForThemeable($themeable);
        Assert::assertSame($theme->id, $linkedTheme->id);
        Assert::assertSame($themeLabel, $linkedTheme->subject);
    });

    it('can handle user tracking', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@'.(string) config('app.domain', 'example.com'),
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ]);

        Assert::assertSame('developer@'.(string) config('app.domain', 'example.com'), $themeable->created_by);
        Assert::assertSame('admin@'.(string) config('app.domain', 'example.com'), $themeable->updated_by);
        Assert::assertNotNull($themeable->created_at);
        Assert::assertNotNull($themeable->updated_at);
    });

    it('can manage multiple theme assignments', function () {
        $theme1 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 1']);
        $theme2 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 2']);
        $theme3 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 3']);

        $themeable1 = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme1->id,
        ]);

        $themeable2 = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme2->id,
        ]);

        $themeable3 = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme3->id,
        ]);

        Assert::assertCount(3, NotifyThemeable::where('model_type', 'App\Models\NotificationTemplate')->where('model_id', 123)->get());
    });

    it('can handle theme switching', function () {
        $oldTheme = NotifyThemeFactory::new()->createOne(['subject' => 'Tema Vecchio']);
        $newTheme = NotifyThemeFactory::new()->createOne(['subject' => 'Tema Nuovo']);

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $oldTheme->id,
        ]);

        Assert::assertSame($oldTheme->id, $themeable->notify_theme_id);
        Assert::assertSame('Tema Vecchio', \notifyThemeForThemeable($themeable)->subject);
        $themeable->update([
            'notify_theme_id' => $newTheme->id,
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ]);

        Assert::assertSame($newTheme->id, $themeable->notify_theme_id);
        Assert::assertSame('Tema Nuovo', \notifyThemeForThemeable($themeable)->subject);
        Assert::assertSame('admin@'.(string) config('app.domain', 'example.com'), $themeable->updated_by);
    });

    it('can handle empty or null values gracefully', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $theme->id,
            'model_type' => null,
            'model_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Assert::assertNull($themeable->model_type);
        Assert::assertNull($themeable->model_id);
        Assert::assertNull($themeable->created_by);
        Assert::assertNull($themeable->updated_by);
        Assert::assertNotNull($themeable->notify_theme_id);
    });

    it('can validate model type consistency', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $validModelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushNotification',
            'App\Models\WhatsappMessage',
            'App\Models\InAppNotification',
        ];

        foreach ($validModelTypes as $modelType) {
            $themeable = NotifyThemeableFactory::new()->createOne([
                'model_type' => $modelType,
                'model_id' => rand(1, 1000),
                'notify_theme_id' => $theme->id,
            ]);

            Assert::assertSame($modelType, $themeable->model_type);
            Assert::assertContains($modelType, $validModelTypes);
        }
    });

    it('can manage theme inheritance', function () {
        $parentTheme = NotifyThemeFactory::new()->createOne([
            'subject' => 'Tema Base',
            'body' => 'Tema base per tutte le notifiche',
        ]);

        $childTheme = NotifyThemeFactory::new()->createOne([
            'subject' => 'Tema Specializzato',
            'body' => 'Tema specializzato per appuntamenti',
        ]);

        $baseThemeable = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $parentTheme->id,
        ]);

        $specializedThemeable = NotifyThemeableFactory::new()->createOne([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $childTheme->id,
        ]);

        Assert::assertSame('Tema Base', \notifyThemeForThemeable($baseThemeable)->subject);
        Assert::assertSame('Tema Specializzato', \notifyThemeForThemeable($specializedThemeable)->subject);
        Assert::assertSame($specializedThemeable->model_type, $baseThemeable->model_type);
        Assert::assertSame($specializedThemeable->model_id, $baseThemeable->model_id);
    });

    it('can handle theme removal', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $theme->id,
        ]);

        Assert::assertNotNull($themeable->notify_theme_id);
        Assert::assertSame($theme->id, $themeable->notify_theme_id);
        $themeable->update([
            'notify_theme_id' => null,
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ]);

        Assert::assertNull($themeable->notify_theme_id);
        Assert::assertSame('admin@'.(string) config('app.domain', 'example.com'), $themeable->updated_by);
    });

    it('can manage audit trail', function () {
        $theme = NotifyThemeFactory::new()->createOne();

        $themeable = NotifyThemeableFactory::new()->createOne([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@'.(string) config('app.domain', 'example.com'),
        ]);

        Assert::assertSame('developer@'.(string) config('app.domain', 'example.com'), $themeable->created_by);
        Assert::assertNotNull($themeable->created_at);
        $themeable->update([
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ]);

        Assert::assertSame('admin@'.(string) config('app.domain', 'example.com'), $themeable->updated_by);
        Assert::assertNotNull($themeable->updated_at);
        Assert::assertTrue($themeable->created_at->lte($themeable->updated_at));
    });

    it('can handle bulk theme operations', function () {
        $theme1 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 1']);
        $theme2 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 2']);
        $theme3 = NotifyThemeFactory::new()->createOne(['subject' => 'Tema 3']);

        $modelIds = [101, 102, 103, 104, 105];

        foreach ($modelIds as $modelId) {
            NotifyThemeableFactory::new()->createOne([
                'model_type' => 'App\Models\NotificationTemplate',
                'model_id' => $modelId,
                'notify_theme_id' => $theme1->id,
            ]);
        }

        $theme1Assignments = NotifyThemeable::where('notify_theme_id', $theme1->id)->get();
        Assert::assertCount(5, $theme1Assignments);
        NotifyThemeable::where('notify_theme_id', $theme1->id)->update([
            'notify_theme_id' => $theme2->id,
            'updated_by' => 'admin@'.(string) config('app.domain', 'example.com'),
        ]);

        $theme2Assignments = NotifyThemeable::where('notify_theme_id', $theme2->id)->get();
        Assert::assertCount(5, $theme2Assignments);
        foreach ($theme2Assignments as $assignment) {
            Assert::assertSame('admin@'.(string) config('app.domain', 'example.com'), $assignment->updated_by);
        }
    });
});
