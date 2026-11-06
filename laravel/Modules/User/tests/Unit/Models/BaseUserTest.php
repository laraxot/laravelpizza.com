<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Notifications\Notifiable;
use Modules\User\Models\BaseUser;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * BaseUser e' astratta: il soggetto del test e' una sottoclasse anonima su una tabella dedicata.
 * Che sia un Model/Authenticatable e' garantito dai tipi (extends), quindi non si asserisce a runtime.
 */
function makeBaseUserSubject(): BaseUser
{
    return new class extends BaseUser {
        protected $table = 'test_users';
    };
}

test('base user has correct table name', function (): void {
    expect(makeBaseUserSubject()->getTable())->toBe('test_users');
});

test('base user has notification trait', function (): void {
    expect(class_uses_recursive(makeBaseUserSubject()))->toContain(Notifiable::class);
});
