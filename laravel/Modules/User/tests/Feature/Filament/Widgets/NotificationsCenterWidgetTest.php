<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\Auth\NotificationsCenterWidget;
use Modules\User\Tests\TestCase;

use function Pest\Laravel\get;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('redirects guests from notifiche page', function (): void {
    $response = get('/it/area-personale/notifications');

    $response->assertRedirect();
});

it('uses notifications center widget view', function (): void {
    $widget = new NotificationsCenterWidget();
    $reflection = new ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);
    $view = $property->getValue($widget);

    Assert::assertSame('user::widgets.auth.notifications-center-widget', $view);
});
