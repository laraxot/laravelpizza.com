# Testing del Modulo Notify

## Configurazione

### TestCase Base

```php
namespace Modules\Notify\Tests;

use Modules\Notify\Providers\NotifyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }

    protected function getPackageProviders($app): array
    {
        return [
            NotifyServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
```

## Unit Tests

### TemplateTest

```php
final class TemplateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_template(): void
    {
        $template = Template::factory()->create([
            'name' => 'Test Template',
            'type' => TemplateType::EMAIL,
            'status' => TemplateStatus::DRAFT,
        ]);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => 'Test Template',
        ]);
    }

    /** @test */
    public function it_can_create_a_version(): void
    {
        $template = Template::factory()->create();

        $version = $template->createNewVersion([
            'content' => 'Test content',
            'metadata' => ['key' => 'value'],
        ]);

        $this->assertDatabaseHas('template_versions', [
            'id' => $version->id,
            'template_id' => $template->id,
            'version' => 1,
        ]);
    }

    /** @test */
    public function it_tracks_analytics_events(): void
    {
        $template = Template::factory()->create();

        $template->analytics()->create([
            'event_type' => 'sent',
            'event_data' => ['recipient' => 'test@example.com'],
            'occurred_at' => now(),
        ]);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event_type' => 'sent',
        ]);
    }
}
```

### TemplateServiceTest

```php
final class TemplateServiceTest extends TestCase
{
    private TemplateService $service;
    private MjmlService $mjmlService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mjmlService = $this->mock(MjmlService::class);
        $this->service = new TemplateService(
            new EloquentTemplateRepository(),
            $this->mjmlService,
            $this->app->make(EventDispatcher::class)
        );
    }

    /** @test */
    public function it_compiles_email_template(): void
    {
        $template = Template::factory()->create([
            'type' => TemplateType::EMAIL,
        ]);

        $version = $template->createNewVersion([
            'content' => '<mjml><mj-body><mj-text>Hello {{name}}</mj-text></mj-body></mjml>',
        ]);

        $this->mjmlService
            ->shouldReceive('compile')
            ->once()
            ->andReturn('<div>Hello John</div>');

        $result = $this->service->compileTemplate($template, [
            'name' => 'John',
        ]);

        $this->assertEquals('<div>Hello John</div>', $result);
    }
}
```

## Feature Tests

### TemplateControllerTest

```php
final class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_templates(): void
    {
        $user = User::factory()->create();
        Template::factory()->count(3)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/templates');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_create_template(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/templates', [
                'name' => 'New Template',
                'type' => TemplateType::EMAIL->value,
                'content' => 'Test content',
            ]);

        $response->assertCreated();
        $this->assertDatabaseHas('templates', [
            'name' => 'New Template',
        ]);
    }

    /** @test */
    public function it_validates_template_creation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/templates', [
                'name' => '',
                'type' => 'invalid',
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'type']);
    }
}
```

### NotificationTest

```php
final class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_notification(): void
    {
        Queue::fake();

        $template = Template::factory()->create([
            'type' => TemplateType::EMAIL,
        ]);

        $service = app(NotificationService::class);
        
        $service->send($template, ['test@example.com'], [
            'name' => 'John',
        ]);

        Queue::assertPushed(SendNotificationJob::class);
    }

    /** @test */
    public function it_tracks_notification_events(): void
    {
        Event::fake();

        $template = Template::factory()->create();
        $service = app(NotificationService::class);

        $service->trackEvent($template, 'sent', [
            'recipient' => 'test@example.com',
        ]);

        Event::assertDispatched(AnalyticsEventRecorded::class);
    }
}
```

## Browser Tests

### TemplateManagementTest

```php
final class TemplateManagementTest extends TestCase
{
    use RefreshDatabase;
    use LazilyRefreshDatabase;

    /** @test */
    public function it_can_create_template_through_ui(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit('/admin/templates/create')
                ->type('name', 'New Template')
                ->select('type', TemplateType::EMAIL->value)
                ->type('content', 'Test content')
                ->press('Create')
                ->assertPathIs('/admin/templates')
                ->assertSee('Template created successfully');
        });
    }

    /** @test */
    public function it_shows_validation_errors(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit('/admin/templates/create')
                ->press('Create')
                ->assertSee('The name field is required')
                ->assertSee('The type field is required');
        });
    }
}
```

## Factories

### TemplateFactory

```php
final class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(TemplateType::cases()),
            'status' => TemplateStatus::DRAFT,
            'tenant_id' => Tenant::factory(),
        ];
    }

    public function published(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => TemplateStatus::PUBLISHED,
        ]);
    }

    public function withVersion(array $versionData = []): self
    {
        return $this->afterCreating(function (Template $template) use ($versionData) {
            $template->createNewVersion(array_merge([
                'content' => $this->faker->randomHtml,
                'metadata' => [],
            ], $versionData));
        });
    }
}
```

## PHPStan

### phpstan.neon.dist

```neon
includes:
    - phpstan-baseline.neon

parameters:
    level: 5
    paths:
        - app
        - src
        - tests

    excludePaths:
        - tests/coverage
        - vendor

    ignoreErrors:
        - '#PHPDoc tag @mixin contains unknown class#'
        - '#Call to an undefined static method#'
```

## Continuous Integration

### GitHub Actions

```yaml
name: Tests

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v2

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite
        coverage: none

    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

    - name: Execute tests
      run: vendor/bin/phpunit --verbose

    - name: Execute static analysis
      run: vendor/bin/phpstan analyse
```

## Test Unitari

### Queueable Actions

#### SendNotificationActionTest
```php
final class SendNotificationActionTest extends TestCase
{
    use RefreshDatabase;

    private SendNotificationAction $action;
    private Template $template;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->action = app(SendNotificationAction::class);
        $this->template = Template::factory()->create();
        $this->user = User::factory()->create();
    }

    public function test_it_sends_notification(): void
    {
        // Arrange
        $data = ['name' => 'Test User'];
        $channels = ['mail'];
        
        // Act
        $result = $this->action->execute(
            recipient: $this->user,
            templateCode: $this->template->code,
            data: $data,
            channels: $channels
        );
        
        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseHas('notification_logs', [
            'template_id' => $this->template->id,
            'recipient_id' => $this->user->id,
            'recipient_type' => User::class,
        ]);
    }

    public function test_it_handles_invalid_template(): void
    {
        // Arrange
        $invalidCode = 'invalid-template';
        
        // Act & Assert
        $this->expectException(TemplateNotFoundException::class);
        
        $this->action->execute(
            recipient: $this->user,
            templateCode: $invalidCode,
            data: [],
            channels: ['mail']
        );
    }
}
```

#### TrackNotificationEventActionTest
```php
final class TrackNotificationEventActionTest extends TestCase
{
    use RefreshDatabase;

    private TrackNotificationEventAction $action;
    private NotificationLog $notification;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->action = app(TrackNotificationEventAction::class);
        $this->notification = NotificationLog::factory()->create();
    }

    public function test_it_tracks_delivery_event(): void
    {
        // Arrange
        $eventType = 'delivered';
        $eventData = ['ip' => '127.0.0.1'];
        
        // Act
        $result = $this->action->execute(
            notification: $this->notification,
            eventType: $eventType,
            eventData: $eventData
        );
        
        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseHas('template_analytics', [
            'notification_id' => $this->notification->id,
            'event_type' => $eventType,
        ]);
    }
}
```

### Modelli

#### TemplateTest
```php
final class TemplateTest extends TestCase
{
    use RefreshDatabase;

    private Template $template;

    protected function setUp(): void
    {
        parent::setUp();
        $this->template = Template::factory()->create();
    }

    public function test_it_creates_new_version(): void
    {
        // Arrange
        $data = [
            'content' => 'New content',
            'metadata' => ['key' => 'value']
        ];
        
        // Act
        $version = $this->template->createNewVersion($data);
        
        // Assert
        $this->assertEquals(1, $version->version);
        $this->assertEquals($data['content'], $version->content);
    }

    public function test_it_gets_latest_version(): void
    {
        // Arrange
        $this->template->createNewVersion(['content' => 'Version 1']);
        $this->template->createNewVersion(['content' => 'Version 2']);
        
        // Act
        $latest = $this->template->latestVersion();
        
        // Assert
        $this->assertEquals('Version 2', $latest->content);
    }
}
```

## Test di Integrazione

### NotificationFlowTest
```php
final class NotificationFlowTest extends TestCase
{
    use RefreshDatabase;

    private SendNotificationAction $sendAction;
    private TrackNotificationEventAction $trackAction;
    private Template $template;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->sendAction = app(SendNotificationAction::class);
        $this->trackAction = app(TrackNotificationEventAction::class);
        $this->template = Template::factory()->create();
        $this->user = User::factory()->create();
    }

    public function test_complete_notification_flow(): void
    {
        // Arrange
        $data = ['name' => 'Test User'];
        $channels = ['mail'];
        
        // Act - Send
        $sendResult = $this->sendAction->execute(
            recipient: $this->user,
            templateCode: $this->template->code,
            data: $data,
            channels: $channels
        );
        
        // Assert - Send
        $this->assertTrue($sendResult);
        $notification = NotificationLog::first();
        $this->assertNotNull($notification);
        
        // Act - Track Delivery
        $deliveryResult = $this->trackAction->execute(
            notification: $notification,
            eventType: 'delivered',
            eventData: ['ip' => '127.0.0.1']
        );
        
        // Assert - Delivery
        $this->assertTrue($deliveryResult);
        $this->assertNotNull($notification->fresh()->delivered_at);
        
        // Act - Track Open
        $openResult = $this->trackAction->execute(
            notification: $notification,
            eventType: 'opened',
            eventData: ['user_agent' => 'Mozilla/5.0']
        );
        
        // Assert - Open
        $this->assertTrue($openResult);
        $this->assertNotNull($notification->fresh()->opened_at);
    }
}
```

## Test Feature

### NotificationManagementTest
```php
final class NotificationManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Template $template;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->template = Template::factory()->create();
    }

    public function test_admin_can_view_notifications(): void
    {
        // Arrange
        $notification = NotificationLog::factory()->create([
            'template_id' => $this->template->id
        ]);
        
        // Act
        $response = $this->actingAs($this->admin)
            ->get(route('admin.notifications.index'));
        
        // Assert
        $response->assertStatus(200)
            ->assertViewHas('notifications')
            ->assertSee($notification->id);
    }

    public function test_admin_can_delete_notification(): void
    {
        // Arrange
        $notification = NotificationLog::factory()->create([
            'template_id' => $this->template->id
        ]);
        
        // Act
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.notifications.destroy', $notification));
        
        // Assert
        $response->assertRedirect(route('admin.notifications.index'));
        $this->assertDatabaseMissing('notification_logs', [
            'id' => $notification->id
        ]);
    }
}
```

## Test Blade Components

### NotificationCardTest
```php
final class NotificationCardTest extends TestCase
{
    use RefreshDatabase;

    private NotificationLog $notification;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notification = NotificationLog::factory()->create();
    }

    public function test_it_renders_notification_card(): void
    {
        // Act
        $view = $this->blade(
            '<x-notify::notification-card :notification="$notification" />',
            ['notification' => $this->notification]
        );
        
        // Assert
        $view->assertSee($this->notification->id)
            ->assertSee($this->notification->template->name);
    }
}
```

## Test di Performance

### NotificationQueueTest
```php
final class NotificationQueueTest extends TestCase
{
    use RefreshDatabase;

    private SendNotificationAction $action;
    private Template $template;
    private Collection $users;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->action = app(SendNotificationAction::class);
        $this->template = Template::factory()->create();
        $this->users = User::factory()->count(100)->create();
    }

    public function test_it_handles_bulk_notifications(): void
    {
        // Arrange
        $startTime = microtime(true);
        
        // Act
        foreach ($this->users as $user) {
            $this->action->execute(
                recipient: $user,
                templateCode: $this->template->code,
                data: ['name' => $user->name],
                channels: ['mail']
            );
        }
        
        // Assert
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        
        $this->assertLessThan(5.0, $executionTime);
        $this->assertDatabaseCount('notification_logs', 100);
    }
}
```

## Test di Sicurezza

### NotificationSecurityTest
```php
final class NotificationSecurityTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Template $template;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->template = Template::factory()->create();
    }

    public function test_it_prevents_xss_in_notification_content(): void
    {
        // Arrange
        $maliciousData = [
            'name' => '<script>alert("xss")</script>'
        ];
        
        // Act
        $notification = NotificationLog::factory()->create([
            'template_id' => $this->template->id,
            'data' => $maliciousData
        ]);
        
        // Assert
        $this->assertStringNotContainsString(
            '<script>',
            $notification->content
        );
    }

    public function test_it_validates_template_access(): void
    {
        // Arrange
        $otherUser = User::factory()->create();
        
        // Act & Assert
        $this->expectException(UnauthorizedException::class);
        
        app(SendNotificationAction::class)->execute(
            recipient: $otherUser,
            templateCode: $this->template->code,
            data: [],
            channels: ['mail']
        );
    }
}
``` 
