<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use PHPUnit\Framework\Assert;
use Modules\Notify\Models\NotifyThemeable;
use Modules\Notify\Tests\TestCase;
use function Pest\Laravel\get;

uses(\Modules\Notify\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Notify\Tests\TestCase $this */
$this->disableExceptionHandling();
});

describe('Notify Themeable', function (): void {
    test('_can_create_notify_themeable', function (): void {
        /** @var \Modules\Notify\Tests\TestCase $this */
$themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);
        \assertNotifyTableHas('notify_themeables', [
            'id' => $themeable->id,
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        Assert::assertInstanceOf(NotifyThemeable::class, $themeable);
    });

    test('_can_create_with_created_by_and_updated_by', function (): void {
$themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_123',
            'updated_by' => 'user_123',
        ]);
        \assertNotifyTableHas('notify_themeables', [
            'id' => $themeable->id,
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_123',
            'updated_by' => 'user_123',
        ]);

        Assert::assertEquals('user_123', $themeable->created_by);
        Assert::assertEquals('user_123', $themeable->updated_by);
    });

    test('_can_update_notify_themeable', function (): void {
$themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $themeable->update([
            'notify_theme_id' => 789,
            'updated_by' => 'user_456',
        ]);
        \assertNotifyTableHas('notify_themeables', [
            'id' => $themeable->id,
            'notify_theme_id' => 789,
            'updated_by' => 'user_456',
        ]);

        Assert::assertEquals(789, \assertFreshModel($themeable, \Modules\Notify\Models\NotifyThemeable::class)->notify_theme_id);
        Assert::assertEquals('user_456', \assertFreshModel($themeable, \Modules\Notify\Models\NotifyThemeable::class)->updated_by);
    });

    test('_can_find_by_model_type_and_id', function (): void {
$themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $found = NotifyThemeable::where('model_type', 'App\Models\User')->where('model_id', 123)->first();

        Assert::assertNotNull($found);
        Assert::assertEquals($themeable->id, $found->id);
        Assert::assertEquals('App\Models\User', $found->model_type);
        Assert::assertEquals(123, $found->model_id);
        Assert::assertEquals(456, $found->notify_theme_id);
    });

    test('_can_find_by_notify_theme_id', function (): void {
NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 456,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Order',
            'model_id' => 101,
            'notify_theme_id' => 789,
        ]);

        $theme456Themeables = NotifyThemeable::where('notify_theme_id', 456)->get();
        $theme789Themeables = NotifyThemeable::where('notify_theme_id', 789)->get();

        Assert::assertCount(2, $theme456Themeables);
        Assert::assertCount(1, $theme789Themeables);
        Assert::assertEquals(456, \assertFirstModel($theme456Themeables, \Modules\Notify\Models\NotifyThemeable::class)->notify_theme_id);
        Assert::assertEquals(456, \assertFirstModel($theme456Themeables->slice(1), \Modules\Notify\Models\NotifyThemeable::class)->notify_theme_id);
        Assert::assertEquals(789, \assertFirstModel($theme789Themeables, \Modules\Notify\Models\NotifyThemeable::class)->notify_theme_id);
    });

    test('_can_find_by_model_type', function (): void {
NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 456,
            'notify_theme_id' => 789,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
        ]);

        $userThemeables = NotifyThemeable::where('model_type', 'App\Models\User')->get();
        $companyThemeables = NotifyThemeable::where('model_type', 'App\Models\Company')->get();

        Assert::assertCount(2, $userThemeables);
        Assert::assertCount(1, $companyThemeables);
        Assert::assertEquals('App\Models\User', \assertFirstModel($userThemeables, \Modules\Notify\Models\NotifyThemeable::class)->model_type);
        Assert::assertEquals('App\Models\User', \assertFirstModel($userThemeables->slice(1), \Modules\Notify\Models\NotifyThemeable::class)->model_type);
        Assert::assertEquals('App\Models\Company', \assertFirstModel($companyThemeables, \Modules\Notify\Models\NotifyThemeable::class)->model_type);
    });

    test('_can_find_by_created_by', function (): void {
NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
            'created_by' => 'user_123',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_456',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Order',
            'model_id' => 101,
            'notify_theme_id' => 789,
            'created_by' => 'user_123',
        ]);

        $user123Themeables = NotifyThemeable::where('created_by', 'user_123')->get();
        $user456Themeables = NotifyThemeable::where('created_by', 'user_456')->get();

        Assert::assertCount(2, $user123Themeables);
        Assert::assertCount(1, $user456Themeables);
        Assert::assertEquals('user_123', \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->created_by);
        Assert::assertEquals('user_123', \assertFirstModel($user123Themeables->slice(1), \Modules\Notify\Models\NotifyThemeable::class)->created_by);
        Assert::assertEquals('user_456', \assertFirstModel($user456Themeables, \Modules\Notify\Models\NotifyThemeable::class)->created_by);
    });

    test('_can_find_by_updated_by', function (): void {
NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
            'updated_by' => 'user_123',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'updated_by' => 'user_456',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Order',
            'model_id' => 101,
            'notify_theme_id' => 789,
            'updated_by' => 'user_123',
        ]);

        $user123Themeables = NotifyThemeable::where('updated_by', 'user_123')->get();
        $user456Themeables = NotifyThemeable::where('updated_by', 'user_456')->get();

        Assert::assertCount(2, $user123Themeables);
        Assert::assertCount(1, $user456Themeables);
        Assert::assertEquals('user_123', \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->updated_by);
        Assert::assertEquals('user_123', \assertFirstModel($user123Themeables->slice(1), \Modules\Notify\Models\NotifyThemeable::class)->updated_by);
        Assert::assertEquals('user_456', \assertFirstModel($user456Themeables, \Modules\Notify\Models\NotifyThemeable::class)->updated_by);
    });

    test('_can_find_by_multiple_criteria', function (): void {
NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
            'created_by' => 'user_123',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 456,
            'notify_theme_id' => 789,
            'created_by' => 'user_456',
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_123',
        ]);

        $user123Themeables = NotifyThemeable::where('model_type', 'App\Models\User')
            ->where('created_by', 'user_123')
            ->get();

        Assert::assertCount(1, $user123Themeables);
        Assert::assertEquals('App\Models\User', \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->model_type);
        Assert::assertEquals(123, \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->model_id);
        Assert::assertEquals(456, \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->notify_theme_id);
        Assert::assertEquals('user_123', \assertFirstModel($user123Themeables, \Modules\Notify\Models\NotifyThemeable::class)->created_by);
    });

    test('_can_handle_null_values', function (): void {
$themeable = NotifyThemeable::create([
            'model_type' => null,
            'model_id' => null,
            'notify_theme_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ]);

        Assert::assertNull($themeable->model_type);
        Assert::assertNull($themeable->model_id);
        Assert::assertNull($themeable->notify_theme_id);
        Assert::assertNull($themeable->created_by);
        Assert::assertNull($themeable->updated_by);
    });

    test('_can_create_multiple_themeables', function (): void {
$themeables = [
            [
                'model_type' => 'App\Models\User',
                'model_id' => 1,
                'notify_theme_id' => 101,
                'created_by' => 'user_1',
            ],
            [
                'model_type' => 'App\Models\User',
                'model_id' => 2,
                'notify_theme_id' => 102,
                'created_by' => 'user_2',
            ],
            [
                'model_type' => 'App\Models\Company',
                'model_id' => 1,
                'notify_theme_id' => 201,
                'created_by' => 'user_1',
            ],
            [
                'model_type' => 'App\Models\Company',
                'model_id' => 2,
                'notify_theme_id' => 202,
                'created_by' => 'user_2',
            ],
            [
                'model_type' => 'App\Models\Order',
                'model_id' => 1,
                'notify_theme_id' => 301,
                'created_by' => 'user_1',
            ],
        ];

        foreach ($themeables as $themeableData) {
            NotifyThemeable::create($themeableData);
        }

        Assert::assertSame(5, NotifyThemeable::query()->count());

        $userThemeables = NotifyThemeable::where('model_type', 'App\Models\User')->get();
        $companyThemeables = NotifyThemeable::where('model_type', 'App\Models\Company')->get();
        $orderThemeables = NotifyThemeable::where('model_type', 'App\Models\Order')->get();

        Assert::assertCount(2, $userThemeables);
        Assert::assertCount(2, $companyThemeables);
        Assert::assertCount(1, $orderThemeables);

        $user1Themeables = NotifyThemeable::where('created_by', 'user_1')->get();
        Assert::assertCount(3, $user1Themeables);
    });

    test('_can_find_by_date_range', function (): void {
$yesterday = now()->subDay();
        $today = now();
        $tomorrow = now()->addDay();

        NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 1,
            'notify_theme_id' => 101,
            'created_at' => $yesterday,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 2,
            'notify_theme_id' => 102,
            'created_at' => $today,
        ]);

        NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 1,
            'notify_theme_id' => 201,
            'created_at' => $tomorrow,
        ]);

        $todayThemeables = NotifyThemeable::whereDate('created_at', $today->toDateString())->get();
        $recentThemeables = NotifyThemeable::where('created_at', '>=', $yesterday)->get();

        Assert::assertCount(1, $todayThemeables);
        Assert::assertCount(2, $recentThemeables); // yesterday and today
        Assert::assertEquals('App\Models\User', \assertFirstModel($todayThemeables, \Modules\Notify\Models\NotifyThemeable::class)->model_type);
        Assert::assertEquals(2, \assertFirstModel($todayThemeables, \Modules\Notify\Models\NotifyThemeable::class)->model_id);
    });
});
