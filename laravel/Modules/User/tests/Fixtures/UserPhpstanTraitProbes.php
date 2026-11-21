<?php

declare(strict_types=1);

namespace Modules\User\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Traits\BaseUserUniqueNameAttribute;

/**
 * PHPStan host for BaseUserUniqueNameAttribute (otherwise unused trait).
 */
final class UserUniqueNameAttributeProbe extends Model
{
    use BaseUserUniqueNameAttribute;

    /** @var string */
    protected $table = 'users';

    public ?string $email = 'probe@example.test';

    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<string, mixed>  $options
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute((string) $key, $value);
        }

        return true;
    }

    private function shouldAvoidNamePersistenceDuringTests(): bool
    {
        return true;
    }
}
