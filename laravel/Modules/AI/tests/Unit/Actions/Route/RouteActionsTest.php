<?php

declare(strict_types=1);
use Modules\Xot\Actions\Route\BuildLanguageUrlAction;
use Modules\Xot\Actions\Route\BuildNestedRouteNameAction;
use Modules\Xot\Actions\Route\IsAdminRouteAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('executes the converted route use cases through the container', function (): void {
    Assert::assertTrue(app(IsAdminRouteAction::class)->execute(['in_admin' => true]));
    Assert::assertSame(
        'admin.container0.container1.edit',
        app(BuildNestedRouteNameAction::class)->execute(['in_admin' => true, 'n' => 1, 'act' => 'edit']),
    );
    Assert::assertSame('?', app(BuildLanguageUrlAction::class)->execute());
});
