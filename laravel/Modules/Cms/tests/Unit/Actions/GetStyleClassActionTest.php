<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Actions\GetStyleClassAction;

test('GetStyleClassAction can be instantiated', function () {
    $action = new GetStyleClassAction;

    expect($action)->toBeInstanceOf(GetStyleClassAction::class);
});

test('GetStyleClassAction execute returns string', function () {
    $action = new GetStyleClassAction;

    $result = $action->execute('');

    expect($result)->toBeString();
});

test('GetStyleClassAction execute throws exception when config is invalid', function () {
    config(['xra.pub_theme::invalid.class' => null]);

    $action = new GetStyleClassAction;

    expect(fn () => $action->execute('invalid'))->toThrow(\Exception::class);
});
