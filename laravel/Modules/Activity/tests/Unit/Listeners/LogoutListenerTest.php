<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Listeners;

use Illuminate\Auth\Events\Logout;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Tests\TestCase;
use ReflectionMethod;
use ReflectionNamedType;

uses(TestCase::class);

/*
 * Contratto di firma del listener: Laravel risolve il listener dall'evento tipizzato in handle().
 * Il comportamento (ritorno anticipato senza utente, activity "logout") e' in
 * LoginLogoutListenerBehaviorTest; esistenza classe/metodo in tests/Unit/LogoutListenerTest.
 */
test('logout listener handle accepts exactly one Logout event', function (): void {
    $parameters = new ReflectionMethod(LogoutListener::class, 'handle')->getParameters();

    expect($parameters)->toHaveCount(1);

    $type = $parameters[0]->getType();
    $typeName = $type instanceof ReflectionNamedType ? $type->getName() : null;

    expect($typeName)->toBe(Logout::class);
});
