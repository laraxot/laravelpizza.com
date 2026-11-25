<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

/**
 * Data Transfer Object contract for strongly-typed data transport.
 *
 * Implementations should be immutable value objects that validate
 * data in the constructor and provide type-safe access to properties.
 *
 * Benefits:
 * - Type safety across boundaries (HTTP, queue, events)
 * - Validation at creation time
 * - Immutability prevents accidental mutations
 * - Clear contract for what data flows between layers
 *
 * Example:
 *     class UserCreateData extends BaseData implements DataContract {
 *         public function __construct(
 *             public readonly string $name,
 *             public readonly string $email,
 *             public readonly string $password,
 *         ) {
 *             $this->validate();
 *         }
 *
 *         protected function validate(): void {
 *             Assert::email($this->email);
 *             Assert::minLength($this->password, 8);
 *         }
 *     }
 */
interface DataContract
{
    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Validate the DTO data.
     *
     * Should throw an exception if validation fails.
     *
     * @throws \InvalidArgumentException
     * @throws \Webmozart\Assert\InvalidArgumentException
     */
    public function validate(): void;
}
