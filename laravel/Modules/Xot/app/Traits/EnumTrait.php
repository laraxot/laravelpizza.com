<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Filament\Traits\TransTrait;

trait EnumTrait
{
    use TransTrait;

    public function getLabel(): string
    {
        return $this->transClass(static::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(static::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(static::class, $this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(static::class, $this->value.'.description');
    }

    /**
     * @return array<string>
     */
    public static function getSearchable(): array
    {
        return array_map(fn ($item) => (string) $item->value, static::cases());
    }

    /**
     * @return array<int|string, TextInput>
     */
    public static function getFormSchema(): array
    {
        // ContactTypeEnum::cases() restituisce un array shape specifico, non list<ContactTypeEnum>
        $cases = static::cases();
        /** @var array<string, TextInput> $result */
        $result = [];
        foreach ($cases as $item) {
            $name = (string) $item->value;
            $result[$name] = TextInput::make($name)->prefixIcon($item->getIcon());
        }

        return $result;
    }

    /**
     * Add all standard contact columns to a migration table.
     *
     * Following the philosophy of AddressItemEnum::columns() and the Laraxot
     * XotBaseMigration pattern (inspired by workers_table migration).
     *
     * This method intelligently handles BOTH CREATE and UPDATE contexts:
     * - **CREATE context** ($migration = null): Adds all columns directly
     * - **UPDATE context** ($migration provided): Loops with hasColumn() checks like workers_table
     *
     * The method embodies:
     * - **Logic**: Mathematical precision with conditional column addition
     * - **Philosophy**: Single Source of Truth (DRY principle)
     * - **Politics**: Centralized governance of contact fields structure
     * - **Religion**: Strong typing through enum values
     * - **Zen**: Form without form - one method adapts to both contexts
     *
     * Inspired by Modules/<nome progetto>/database/migrations/2019_12_12_000004_create_workers_table.php:
     * ```php
     * $address_components = Place::$address_components;
     * foreach ($address_components as $el) {
     *     if (! $this->hasColumn($el)) {
     *         $table->string($el)->nullable();
     *     }
     * }
     * ```
     *
     * Usage in migrations:
     * ```php
     * // In CREATE block (no hasColumn checks needed):
     * $this->tableCreate(function (Blueprint $table): void {
     *     $table->id();
     *     ContactTypeEnum::columns($table); // migration = null, adds all
     * });
     *
     * // In UPDATE block (with hasColumn checks):
     * $this->tableUpdate(function (Blueprint $table): void {
     *     ContactTypeEnum::columns($table, $this); // loops with checks
     * });
     * ```
     */
    /**
     * @param Blueprint             $table     The table blueprint
     * @param XotBaseMigration|null $migration XotBaseMigration instance for UPDATE context (provides hasColumn())
     */
    public static function columns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        // if (! method_exists(static::class, 'getColumnDefinitions')) {
        //    return;
        // }

        foreach (static::getColumnDefinitions() as $name => $definition) {
            if (null === $migration || ! $migration->hasColumn($name)) {
                $definition($table);
            }
        }
    }

    /**
     * Ensure all standard contact columns exist in UPDATE context.
     */
    public static function updateColumns(Blueprint $table, XotBaseMigration $migration): void
    {
        static::columns($table, $migration);
    }

    /**
     * Drop all standard contact columns from a table.
     */
    public static function dropColumns(Blueprint $table): void
    {
        $table->dropColumn(static::getColumnNames());
    }

    /**
     * Get all column names as an array.
     *
     * @return array<int, string>
     */
    public static function getColumnNames(): array
    {
        return array_map(fn ($case) => (string) $case->value, static::cases());
    }

    /**
     * Internal map of standard column definitions.
     * This should be overridden in the enum class if needed.
     *
     * @return array<string, callable(Blueprint): void>
     */
    public static function getColumnDefinitions(): array
    {
        return [];
    }
}
