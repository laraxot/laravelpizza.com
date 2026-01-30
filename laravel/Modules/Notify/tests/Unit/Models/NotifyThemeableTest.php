<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notify\Models\NotifyThemeable;
use Tests\TestCase;

class NotifyThemeableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_can_create_notify_themeable(): void
    {
        $themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $this->assertDatabaseHas('notify_themeables', [
            'id' => $themeable->id,
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $this->assertInstanceOf(NotifyThemeable::class, $themeable);
    }

    /** @test */
    public function it_can_create_with_created_by_and_updated_by(): void
    {
        $themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_123',
            'updated_by' => 'user_123',
        ]);

        $this->assertDatabaseHas('notify_themeables', [
            'id' => $themeable->id,
            'model_type' => 'App\Models\Company',
            'model_id' => 789,
            'notify_theme_id' => 101,
            'created_by' => 'user_123',
            'updated_by' => 'user_123',
        ]);

        $this->assertEquals('user_123', $themeable->created_by);
        $this->assertEquals('user_123', $themeable->updated_by);
    }

    /** @test */
    public function it_can_update_notify_themeable(): void
    {
        $themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $themeable->update([
            'notify_theme_id' => 789,
            'updated_by' => 'user_456',
        ]);

        $this->assertDatabaseHas('notify_themeables', [
            'id' => $themeable->id,
            'notify_theme_id' => 789,
            'updated_by' => 'user_456',
        ]);

        $this->assertEquals(789, $themeable->fresh()->notify_theme_id);
        $this->assertEquals('user_456', $themeable->fresh()->updated_by);
    }

    /** @test */
    public function it_can_find_by_model_type_and_id(): void
    {
        $themeable = NotifyThemeable::create([
            'model_type' => 'App\Models\User',
            'model_id' => 123,
            'notify_theme_id' => 456,
        ]);

        $found = NotifyThemeable::where('model_type', 'App\Models\User')->where('model_id', 123)->first();

        $this->assertNotNull($found);
        $this->assertEquals($themeable->id, $found->id);
        $this->assertEquals('App\Models\User', $found->model_type);
        $this->assertEquals(123, $found->model_id);
        $this->assertEquals(456, $found->notify_theme_id);
    }

    /** @test */
    public function it_can_find_by_notify_theme_id(): void
    {
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

        $this->assertCount(2, $theme456Themeables);
        $this->assertCount(1, $theme789Themeables);
        $this->assertEquals(456, $theme456Themeables[0]->notify_theme_id);
        $this->assertEquals(456, $theme456Themeables[1]->notify_theme_id);
        $this->assertEquals(789, $theme789Themeables[0]->notify_theme_id);
    }

    /** @test */
    public function it_can_find_by_model_type(): void
    {
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

        $this->assertCount(2, $userThemeables);
        $this->assertCount(1, $companyThemeables);
        $this->assertEquals('App\Models\User', $userThemeables[0]->model_type);
        $this->assertEquals('App\Models\User', $userThemeables[1]->model_type);
        $this->assertEquals('App\Models\Company', $companyThemeables[0]->model_type);
    }

    /** @test */
    public function it_can_find_by_created_by(): void
    {
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

        $this->assertCount(2, $user123Themeables);
        $this->assertCount(1, $user456Themeables);
        $this->assertEquals('user_123', $user123Themeables[0]->created_by);
        $this->assertEquals('user_123', $user123Themeables[1]->created_by);
        $this->assertEquals('user_456', $user456Themeables[0]->created_by);
    }

    /** @test */
    public function it_can_find_by_updated_by(): void
    {
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

        $this->assertCount(2, $user123Themeables);
        $this->assertCount(1, $user456Themeables);
        $this->assertEquals('user_123', $user123Themeables[0]->updated_by);
        $this->assertEquals('user_123', $user123Themeables[1]->updated_by);
        $this->assertEquals('user_456', $user456Themeables[0]->updated_by);
    }

    /** @test */
    public function it_can_find_by_multiple_criteria(): void
    {
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

        $this->assertCount(1, $user123Themeables);
        $this->assertEquals('App\Models\User', $user123Themeables[0]->model_type);
        $this->assertEquals(123, $user123Themeables[0]->model_id);
        $this->assertEquals(456, $user123Themeables[0]->notify_theme_id);
        $this->assertEquals('user_123', $user123Themeables[0]->created_by);
    }

    /** @test */
    public function it_can_handle_null_values(): void
    {
        $themeable = NotifyThemeable::create([
            'model_type' => null,
            'model_id' => null,
            'notify_theme_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ]);

        $this->assertNull($themeable->model_type);
        $this->assertNull($themeable->model_id);
        $this->assertNull($themeable->notify_theme_id);
        $this->assertNull($themeable->created_by);
        $this->assertNull($themeable->updated_by);
    }

    /** @test */
    public function it_can_create_multiple_themeables(): void
    {
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

        $this->assertDatabaseCount('notify_themeables', 5);

        $userThemeables = NotifyThemeable::where('model_type', 'App\Models\User')->get();
        $companyThemeables = NotifyThemeable::where('model_type', 'App\Models\Company')->get();
        $orderThemeables = NotifyThemeable::where('model_type', 'App\Models\Order')->get();

        $this->assertCount(2, $userThemeables);
        $this->assertCount(2, $companyThemeables);
        $this->assertCount(1, $orderThemeables);

        $user1Themeables = NotifyThemeable::where('created_by', 'user_1')->get();
        $this->assertCount(3, $user1Themeables);
    }

    /** @test */
    public function it_can_find_by_date_range(): void
    {
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

        $this->assertCount(1, $todayThemeables);
        $this->assertCount(2, $recentThemeables); // yesterday and today
        $this->assertEquals('App\Models\User', $todayThemeables[0]->model_type);
        $this->assertEquals(2, $todayThemeables[0]->model_id);
    }
}
