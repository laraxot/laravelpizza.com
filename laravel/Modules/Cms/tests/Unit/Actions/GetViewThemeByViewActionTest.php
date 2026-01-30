<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Actions\GetViewThemeByViewAction;

test('GetViewThemeByViewAction can be executed', function () {
    $action = new GetViewThemeByViewAction();

    expect($action)->toBeInstanceOf(GetViewThemeByViewAction::class);
});

test('GetViewThemeByViewAction returns string when executed with empty view', function () {
    $action = new GetViewThemeByViewAction();

    $result = $action->execute();

    expect($result)->toBeString();
});

test('GetViewThemeByViewAction returns string when executed with view', function () {
    $action = new GetViewThemeByViewAction();

    $result = $action->execute('test::view');

    expect($result)->toBeString();
});

test('GetViewThemeByViewAction returns original view when view does not exist', function () {
    $action = new GetViewThemeByViewAction();

    $view = 'nonexistent::view';
    $result = $action->execute($view);

    expect($result)->toBe($view);
});
