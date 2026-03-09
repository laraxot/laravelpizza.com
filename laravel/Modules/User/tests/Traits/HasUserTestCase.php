<?php

declare(strict_types=1);

namespace Modules\User\Tests\Traits;

use Modules\User\Models\User;

/**
 * Trait HasUserTestCase.
 *
 * Provides type-safe $user property for Pest test cases.
 * This trait resolves PHPStan property.notFound errors by explicitly
 * declaring the $user property that is commonly used in tests.
 *
 * Usage in Pest tests:
 *
 * ```php
 * uses(HasUserTestCase::class);
 *
 * beforeEach(function () {
 *     $this->user = User::factory()->create();
 * });
 *
 * it('can access user', function () {
 *     expect($this->user)->toBeInstanceOf(User::class);
 * });
 * ```
 *
 * @property User $user The authenticated user instance for testing
 */
trait HasUserTestCase
{
    /**
     * The user instance for testing.
     *
     * Typically initialized in beforeEach() with User::factory()->create()
     */
    protected User $user;
}
