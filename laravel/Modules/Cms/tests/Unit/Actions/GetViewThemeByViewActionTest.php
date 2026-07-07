<?php

declare(strict_types=1);

use Modules\Cms\Actions\GetViewThemeByViewAction;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('GetViewThemeByViewAction can be executed', function () {
    $action = new GetViewThemeByViewAction();

    Assert::assertInstanceOf(GetViewThemeByViewAction::class, $action);
});

test('GetViewThemeByViewAction returns string when executed with empty view', function () {
    $action = new GetViewThemeByViewAction();

    $result = $action->execute();
});

test('GetViewThemeByViewAction returns string when executed with view', function () {
    $action = new GetViewThemeByViewAction();

    $result = $action->execute('test::view');
});

test('GetViewThemeByViewAction returns original view when view does not exist', function () {
    $action = new GetViewThemeByViewAction();

    $view = 'nonexistent::view';
    $result = $action->execute($view);

    Assert::assertSame($view, $result);
});
