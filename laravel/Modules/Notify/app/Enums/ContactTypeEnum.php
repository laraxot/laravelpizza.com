<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enum per i tipi di contatto
 *
 * Questo enum centralizza la definizione di **tutti i possibili campi di contatto** nel sistema.
 * Come AddressItemEnum per gli indirizzi, ContactTypeEnum è lo schema vivente per i contatti.
 *
 * Definisce:
 * - **Label tradotti** in tutte le lingue supportate (en, it, de)
 * - **Icone Heroicon** per ogni campo
 * - **Colori** per categorizzazione visiva
 * - **Descrizioni** contestuali
 *
 * Ogni valore rappresenta un **componente atomico** di contatto (phone, email, fax, ecc.)
 * e fornisce metodi helper per migrazioni, form Filament, e gestione centralizzata.
 */
enum ContactTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case PHONE = 'phone';
    case MOBILE = 'mobile';
    case EMAIL = 'email';
    case PEC = 'pec';
    case WHATSAPP = 'whatsapp';
    case FAX = 'fax';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }

    /**
     * @return array<string>
     */
    public static function getSearchable(): array
    {
        return array_map(fn ($item) => $item->value, ContactTypeEnum::cases());
    }

    /**
     * @return array<string, \Filament\Forms\Components\TextInput>
     */
    public static function getFormSchema(): array
    {
        // ContactTypeEnum::cases() restituisce un array shape specifico, non list<ContactTypeEnum>
        $cases = ContactTypeEnum::cases();
        /** @var array<string, \Filament\Forms\Components\TextInput> $result */
        $result = [];
        foreach ($cases as $item) {
            $result[$item->value] = TextInput::make($item->value)->prefixIcon($item->getIcon());
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
     * Inspired by Modules/TechPlanner/database/migrations/2019_12_12_000004_create_workers_table.php:
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
     *
     * @param  Blueprint  $table  The table blueprint
     * @param  XotBaseMigration|null  $migration  XotBaseMigration instance for UPDATE context (provides hasColumn())
     */
    public static function columns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        // Colonne contatto - aggiungi con check solo se in UPDATE context
        // Following the Laraxot pattern from workers_table migration
        foreach (self::getColumnDefinitions() as $name => $definition) {
            if ($migration === null || ! $migration->hasColumn($name)) {
                $definition($table);
            }
        }
    }

    /**
     * Ensure all standard contact columns exist in UPDATE context.
     *
     * Thin wrapper around columns() for semantic clarity in migrations:
     *
     * ```php
     * $this->tableUpdate(function (Blueprint $table): void {
     *     ContactTypeEnum::updateColumns($table, $this);
     * });
     * ```
     */
    public static function updateColumns(Blueprint $table, XotBaseMigration $migration): void
    {
        self::columns($table, $migration);
    }

    /**
     * Drop all standard contact columns from a table.
     *
     * Following the impermanence principle of Zen, this method gracefully
     * removes the contact structure when it's no longer needed.
     *
     * Usage in rollback migrations:
     * ```php
     * ContactTypeEnum::dropColumns($table);
     * ```
     *
     * @param  Blueprint  $table  The table blueprint
     */
    public static function dropColumns(Blueprint $table): void
    {
        // Rimuoviamo le colonne - il ritorno al vuoto
        $table->dropColumn([
            self::PHONE->value,
            self::MOBILE->value,
            self::EMAIL->value,
            self::PEC->value,
            self::WHATSAPP->value,
            self::FAX->value,
        ]);
    }

    /**
     * Get all column names as an array.
     *
     * @return array<int, string>
     */
    public static function getColumnNames(): array
    {
        return [
            self::PHONE->value,
            self::MOBILE->value,
            self::EMAIL->value,
            self::PEC->value,
            self::WHATSAPP->value,
            self::FAX->value,
        ];
    }

    /**
     * Internal map of standard contact column definitions.
     *
     * @return array<string, callable(Blueprint): void>
     */
    private static function getColumnDefinitions(): array
    {
        return [
            self::PHONE->value => static function (Blueprint $table): void {
                $table->string(self::PHONE->value)
                    ->nullable()
                    ->comment('Landline phone number');
            },
            self::MOBILE->value => static function (Blueprint $table): void {
                $table->string(self::MOBILE->value)
                    ->nullable()
                    ->comment('Mobile phone number');
            },
            self::EMAIL->value => static function (Blueprint $table): void {
                $table->string(self::EMAIL->value)
                    ->nullable()
                    ->comment('Email address');
            },
            self::PEC->value => static function (Blueprint $table): void {
                $table->string(self::PEC->value)
                    ->nullable()
                    ->comment('Certified Electronic Mail (PEC)');
            },
            self::WHATSAPP->value => static function (Blueprint $table): void {
                $table->string(self::WHATSAPP->value)
                    ->nullable()
                    ->comment('WhatsApp number');
            },
            self::FAX->value => static function (Blueprint $table): void {
                $table->string(self::FAX->value)
                    ->nullable()
                    ->comment('Fax number');
            },
        ];
    }
}
