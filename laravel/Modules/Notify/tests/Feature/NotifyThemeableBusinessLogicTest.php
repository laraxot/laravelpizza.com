<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Notify\Models\NotifyTheme;
use Modules\Notify\Models\NotifyThemeable;

describe('Notify Themeable Business Logic', function () {
    it('can create notify themeable with basic information', function () {
        $theme = NotifyTheme::factory()->create();

        $themeableData = [
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme->id,
            'created_by' => 'admin@' . config('app.domain', 'example.com'),
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ];

        $themeable = NotifyThemeable::create($themeableData);

        expect('notify_themeables')->toBeInDatabase([
            'id' => $themeable->id,
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme->id,
            'created_by' => 'admin@' . config('app.domain', 'example.com'),
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->model_type)->toBe('App\Models\NotificationTemplate');
        expect($themeable->model_id)->toBe(123);
        expect($themeable->notify_theme_id)->toBe($theme->id);
    });

    it('can manage polymorphic relationships', function () {
        $theme = NotifyTheme::factory()->create();

        $themeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\EmailTemplate',
            'model_id' => 456,
            'notify_theme_id' => $theme->id,
        ]);

        expect($themeable->model_type)->toBe('App\Models\EmailTemplate');
        expect($themeable->model_id)->toBe(456);

        expect($themeable->morphTo())->toBeInstanceOf(MorphTo::class);
    });

    it('can handle different model types', function () {
        $theme = NotifyTheme::factory()->create();

        $modelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushTemplate',
            'App\Models\WhatsappTemplate',
        ];

        foreach ($modelTypes as $index => $modelType) {
            $themeable = NotifyThemeable::factory()->create([
                'model_type' => $modelType,
                'model_id' => $index + 1,
                'notify_theme_id' => $theme->id,
            ]);

            expect($themeable->model_type)->toBe($modelType);
            expect($themeable->model_id)->toBe($index + 1);
        }
    });

    it('can manage theme relationships', function () {
        $theme = NotifyTheme::factory()->create([
            'name' => config('app.name', 'Platform') . ' Professional',
            'description' => 'Tema professionale per ' . config('app.name', 'Platform'),
        ]);

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
        ]);

        expect($themeable->theme)->toBeInstanceOf(NotifyTheme::class);
        expect($themeable->theme->id)->toBe($theme->id);
        expect($themeable->theme->name)->toBe(config('app.name', 'Platform') . ' Professional');
    });

    it('can handle user tracking', function () {
        $theme = NotifyTheme::factory()->create();

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@' . config('app.domain', 'example.com'),
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->created_by)->toBe('developer@' . config('app.domain', 'example.com'));
        expect($themeable->updated_by)->toBe('admin@' . config('app.domain', 'example.com'));
        expect($themeable->created_at)->not->toBeNull();
        expect($themeable->updated_at)->not->toBeNull();
    });

    it('can manage multiple theme assignments', function () {
        $theme1 = NotifyTheme::factory()->create(['name' => 'Tema 1']);
        $theme2 = NotifyTheme::factory()->create(['name' => 'Tema 2']);
        $theme3 = NotifyTheme::factory()->create(['name' => 'Tema 3']);

        $themeable1 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme1->id,
        ]);

        $themeable2 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme2->id,
        ]);

        $themeable3 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme3->id,
        ]);

        expect(NotifyThemeable::where('model_type', 'App\Models\NotificationTemplate')->where('model_id', 123)->get())
            ->toHaveCount(3);
    });

    it('can handle theme switching', function () {
        $oldTheme = NotifyTheme::factory()->create(['name' => 'Tema Vecchio']);
        $newTheme = NotifyTheme::factory()->create(['name' => 'Tema Nuovo']);

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $oldTheme->id,
        ]);

        expect($themeable->notify_theme_id)->toBe($oldTheme->id);
        expect($themeable->theme->name)->toBe('Tema Vecchio');

        $themeable->update([
            'notify_theme_id' => $newTheme->id,
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->notify_theme_id)->toBe($newTheme->id);
        expect($themeable->theme->name)->toBe('Tema Nuovo');
        expect($themeable->updated_by)->toBe('admin@' . config('app.domain', 'example.com'));
    });

    it('can handle empty or null values gracefully', function () {
        $theme = NotifyTheme::factory()->create();

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'model_type' => null,
            'model_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ]);

        expect($themeable->model_type)->toBeNull();
        expect($themeable->model_id)->toBeNull();
        expect($themeable->created_by)->toBeNull();
        expect($themeable->updated_by)->toBeNull();
        expect($themeable->notify_theme_id)->not->toBeNull();
    });

    it('can validate model type consistency', function () {
        $theme = NotifyTheme::factory()->create();

        $validModelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushNotification',
            'App\Models\WhatsappMessage',
            'App\Models\InAppNotification',
        ];

        foreach ($validModelTypes as $modelType) {
            $themeable = NotifyThemeable::factory()->create([
                'model_type' => $modelType,
                'model_id' => rand(1, 1000),
                'notify_theme_id' => $theme->id,
            ]);

            expect($themeable->model_type)->toBe($modelType);
            expect($validModelTypes)->toContain($modelType);
        }
    });

    it('can manage theme inheritance', function () {
        $parentTheme = NotifyTheme::factory()->create([
            'name' => 'Tema Base',
            'description' => 'Tema base per tutte le notifiche',
        ]);

        $childTheme = NotifyTheme::factory()->create([
            'name' => 'Tema Specializzato',
            'description' => 'Tema specializzato per appuntamenti',
        ]);

        $baseThemeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $parentTheme->id,
        ]);

        $specializedThemeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $childTheme->id,
        ]);

        expect($baseThemeable->theme->name)->toBe('Tema Base');
        expect($specializedThemeable->theme->name)->toBe('Tema Specializzato');

        expect($baseThemeable->model_type)->toBe($specializedThemeable->model_type);
        expect($baseThemeable->model_id)->toBe($specializedThemeable->model_id);
    });

    it('can handle theme removal', function () {
        $theme = NotifyTheme::factory()->create();

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
        ]);

        expect($themeable->notify_theme_id)->not->toBeNull();
        expect($themeable->notify_theme_id)->toBe($theme->id);

        $themeable->update([
            'notify_theme_id' => null,
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->notify_theme_id)->toBeNull();
        expect($themeable->updated_by)->toBe('admin@' . config('app.domain', 'example.com'));
    });

    it('can manage audit trail', function () {
        $theme = NotifyTheme::factory()->create();

        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->created_by)->toBe('developer@' . config('app.domain', 'example.com'));
        expect($themeable->created_at)->not->toBeNull();

        $themeable->update([
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        expect($themeable->updated_by)->toBe('admin@' . config('app.domain', 'example.com'));
        expect($themeable->updated_at)->not->toBeNull();

        expect($themeable->created_at->lte($themeable->updated_at))->toBeTrue();
    });

    it('can handle bulk theme operations', function () {
        $theme1 = NotifyTheme::factory()->create(['name' => 'Tema 1']);
        $theme2 = NotifyTheme::factory()->create(['name' => 'Tema 2']);
        $theme3 = NotifyTheme::factory()->create(['name' => 'Tema 3']);

        $modelIds = [101, 102, 103, 104, 105];

        foreach ($modelIds as $modelId) {
            NotifyThemeable::factory()->create([
                'model_type' => 'App\Models\NotificationTemplate',
                'model_id' => $modelId,
                'notify_theme_id' => $theme1->id,
            ]);
        }

        $theme1Assignments = NotifyThemeable::where('notify_theme_id', $theme1->id)->get();
        expect($theme1Assignments)->toHaveCount(5);

        NotifyThemeable::where('notify_theme_id', $theme1->id)->update([
            'notify_theme_id' => $theme2->id,
            'updated_by' => 'admin@' . config('app.domain', 'example.com'),
        ]);

        $theme2Assignments = NotifyThemeable::where('notify_theme_id', $theme2->id)->get();
        expect($theme2Assignments)->toHaveCount(5);

        foreach ($theme2Assignments as $assignment) {
            expect($assignment->updated_by)->toBe('admin@' . config('app.domain', 'example.com'));
        }
    });
});
