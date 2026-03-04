<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Tests\TestCase;
use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\App;
use Mockery;

uses(TestCase::class);

it('verifies svg existence correctly', function (): void {
    $factory = Mockery::mock(IconFactory::class);
    App::instance(IconFactory::class, $factory);

    $factory->shouldReceive('svg')->with('heroicon-o-user')->once()->andReturn(new class { public function toHtml() { return '<svg></svg>'; } });
    $factory->shouldReceive('svg')->with('missing')->once()->andThrow(new \Exception('Missing icon'));

    $action = app(SvgExistsAction::class);

    expect($action->execute('heroicon-o-user'))->toBeTrue();
    expect($action->execute('missing'))->toBeFalse();
    expect($action->execute(''))->toBeFalse();
    
    Mockery::close();
});
