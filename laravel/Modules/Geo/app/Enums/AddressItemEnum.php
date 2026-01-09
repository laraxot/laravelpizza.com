<?php

declare(strict_types=1);

namespace Modules\Geo\Enums;

use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enum per i driver SMS supportati.
 *
 * Questo enum centralizza la gestione dei driver SMS disponibili
 * e fornisce metodi helper per ottenere le opzioni e le etichette.
 */
enum AddressItemEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case PHONE = 'phone';
    case NAME = 'name';
    case DESCRIPTION = 'description';
    case ROUTE = 'route';
    case STREET_NUMBER = 'street_number';
    case POSTAL_CODE = 'postal_code';
    case LOCALITY = 'locality';
    case ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3'; // comune
    case ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2'; // provincia
    case ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1'; // regione
    case COUNTRY = 'country'; // Stato/Paese
    case FORMATTED_ADDRESS = 'formatted_address';
    case PLACE_ID = 'place_id';
    case LATITUDE = 'latitude';
    case LONGITUDE = 'longitude';
    case FAX = 'fax';
    case MOBILE = 'mobile';
    case PEC = 'pec';
    case WHATSAPP = 'whatsapp';
    case EMAIL = 'email';
    case NOTES = 'notes';

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

    public static function getSearchable(): array
    {
        return array_map(fn ($item) => $item->value, self::cases());
    }

    /**
     * @return array<string, TextInput>
     */
    public static function getFormSchema(): array
    {
        $cases = self::cases();
        /** @var array<string, TextInput> $res */
        $res = [];

        foreach ($cases as $item) {
            $fieldName = $item->value;
            $icon = $item->getIcon();

            $res[$fieldName] = TextInput::make($fieldName)
                ->prefixIcon($icon);
        }

        return $res;
    }

    /**
     * Add all standard address columns to a migration table.
     *
     * Following the philosophy of ContactTypeEnum::columns() and the Laraxot
     * XotBaseMigration pattern.
     *
     * This method intelligently handles BOTH CREATE and UPDATE contexts:
     * - **CREATE context** ($migration = null): Adds all columns directly
     * - **UPDATE context** ($migration provided): Loops with hasColumn() checks
     *
     * The method embodies:
     * - **Logic**: Mathematical precision with conditional column addition
     * - **Philosophy**: Single Source of Truth (DRY principle)
     * - **Politics**: Centralized governance of address fields structure
     * - **Religion**: Strong typing through enum values
     * - **Zen**: Form without form - one method adapts to both contexts
     *
     * Usage in migrations:
     * ```php
     * // In CREATE block (no hasColumn checks needed):
     * $this->tableCreate(function (Blueprint $table): void {
     *     $table->id();
     *     AddressItemEnum::columns($table); // migration = null, adds all
     * });
     *
     * // In UPDATE block (with hasColumn checks):
     * $this->tableUpdate(function (Blueprint $table): void {
     *     AddressItemEnum::columns($table, $this); // loops with checks
     * });
     * ```
     *
     * @param Blueprint             $table      The table blueprint
     * @param XotBaseMigration|null $migration  XotBaseMigration instance for UPDATE context (provides hasColumn())
     * @param bool                  $withLegacy Whether to include legacy compatibility fields
     */
    public static function columns(Blueprint $table, ?XotBaseMigration $migration = null, bool $withLegacy = false): void
    {
        // Colonne indirizzo - aggiungi con check solo se in UPDATE context
        // Following the Laraxot pattern from workers_table migration
        foreach (self::getColumnDefinitions() as $name => $definition) {
            if ($migration === null || ! $migration->hasColumn($name)) {
                $definition($table);
            }
        }

        // Campi legacy per compatibilità
        if ($withLegacy) {
            self::addLegacyColumns($table, $migration);
        }
    }

    /**
     * Ensure all standard address columns exist in UPDATE context.
     *
     * Thin wrapper around columns() for semantic clarity in migrations:
     *
     * ```php
     * $this->tableUpdate(function (Blueprint $table): void {
     *     AddressItemEnum::updateColumns($table, $this);
     * });
     * ```
     */
    public static function updateColumns(Blueprint $table, XotBaseMigration $migration, bool $withLegacy = false): void
    {
        self::columns($table, $migration, $withLegacy);
    }

    /**
     * Drop all standard address columns from a table.
     *
     * Following the impermanence principle of Zen, this method gracefully
     * removes the address structure when it's no longer needed.
     *
     * Usage in rollback migrations:
     * ```php
     * AddressItemEnum::dropColumns($table);
     * ```
     *
     * @param Blueprint $table The table blueprint
     */
    public static function dropColumns(Blueprint $table): void
    {
        // Rimuoviamo le colonne - il ritorno al vuoto
        $table->dropColumn(self::getColumnNames());
    }

    /**
     * Get all column names as an array.
     *
     * @return array<int, string>
     */
    public static function getColumnNames(): array
    {
        return array_map(fn ($item) => $item->value, self::cases());
    }

    /**
     * Internal map of standard address column definitions.
     *
     * @return array<string, \Closure(Blueprint):void>
     */
    private static function getColumnDefinitions(): array
    {
        return [
            self::PHONE->value => static function (Blueprint $table): void {
                $table->string(self::PHONE->value)
                    ->nullable()
                    ->comment('Phone number');
            },
            self::NAME->value => static function (Blueprint $table): void {
                $table->string(self::NAME->value)
                    ->nullable()
                    ->comment('Location name');
            },
            self::DESCRIPTION->value => static function (Blueprint $table): void {
                $table->text(self::DESCRIPTION->value)
                    ->nullable()
                    ->comment('Address description');
            },
            self::ROUTE->value => static function (Blueprint $table): void {
                $table->string(self::ROUTE->value)
                    ->nullable()
                    ->comment('Street name (Via/Piazza)');
            },
            self::STREET_NUMBER->value => static function (Blueprint $table): void {
                $table->string(self::STREET_NUMBER->value)
                    ->nullable()
                    ->comment('Street number');
            },
            self::LOCALITY->value => static function (Blueprint $table): void {
                $table->string(self::LOCALITY->value)
                    ->nullable()
                    ->comment('City/Municipality');
            },
            self::ADMINISTRATIVE_AREA_LEVEL_3->value => static function (Blueprint $table): void {
                $table->string(self::ADMINISTRATIVE_AREA_LEVEL_3->value)
                    ->nullable()
                    ->comment('Comune');
            },
            self::ADMINISTRATIVE_AREA_LEVEL_2->value => static function (Blueprint $table): void {
                $table->string(self::ADMINISTRATIVE_AREA_LEVEL_2->value)
                    ->nullable()
                    ->comment('Provincia');
            },
            self::ADMINISTRATIVE_AREA_LEVEL_1->value => static function (Blueprint $table): void {
                $table->string(self::ADMINISTRATIVE_AREA_LEVEL_1->value)
                    ->nullable()
                    ->comment('Regione');
            },
            self::COUNTRY->value => static function (Blueprint $table): void {
                $table->string(self::COUNTRY->value)
                    ->nullable()
                    ->comment('Country/Stato');
            },
            self::POSTAL_CODE->value => static function (Blueprint $table): void {
                $table->string(self::POSTAL_CODE->value)
                    ->nullable()
                    ->comment('CAP/Postal Code');
            },
            self::FORMATTED_ADDRESS->value => static function (Blueprint $table): void {
                $table->text(self::FORMATTED_ADDRESS->value)
                    ->nullable()
                    ->comment('Complete formatted address');
            },
            self::PLACE_ID->value => static function (Blueprint $table): void {
                $table->string(self::PLACE_ID->value)
                    ->nullable()
                    ->comment('Google Place ID');
            },
            self::LATITUDE->value => static function (Blueprint $table): void {
                $table->decimal(self::LATITUDE->value, 10, 8)
                    ->nullable()
                    ->comment('Latitude coordinate');
            },
            self::LONGITUDE->value => static function (Blueprint $table): void {
                $table->decimal(self::LONGITUDE->value, 11, 8)
                    ->nullable()
                    ->comment('Longitude coordinate');
            },
            self::FAX->value => static function (Blueprint $table): void {
                $table->string(self::FAX->value)
                    ->nullable()
                    ->comment('Fax number');
            },
            self::MOBILE->value => static function (Blueprint $table): void {
                $table->string(self::MOBILE->value)
                    ->nullable()
                    ->comment('Mobile number');
            },
            self::PEC->value => static function (Blueprint $table): void {
                $table->string(self::PEC->value)
                    ->nullable()
                    ->comment('Certified Email Address (PEC)');
            },
            self::WHATSAPP->value => static function (Blueprint $table): void {
                $table->string(self::WHATSAPP->value)
                    ->nullable()
                    ->comment('WhatsApp number');
            },
            self::EMAIL->value => static function (Blueprint $table): void {
                $table->string(self::EMAIL->value)
                    ->nullable()
                    ->comment('Email address');
            },
            self::NOTES->value => static function (Blueprint $table): void {
                $table->text(self::NOTES->value)
                    ->nullable()
                    ->comment('General notes');
            },
        ];
    }

    /**
     * Add legacy compatibility columns.
     *
     * These fields maintain compatibility with older code that expects
     * generic field names like 'address', 'city', 'province', etc.
     *
     * @param Blueprint             $table     The table blueprint
     * @param XotBaseMigration|null $migration XotBaseMigration instance for UPDATE context
     */
    private static function addLegacyColumns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        $legacyColumns = [
            'address' => static function (Blueprint $table): void {
                $table->text('address')
                    ->nullable()
                    ->comment('Legacy full address field');
            },
            'city' => static function (Blueprint $table): void {
                $table->string('city')
                    ->nullable()
                    ->comment('Legacy city field');
            },
            'province' => static function (Blueprint $table): void {
                $table->string('province')
                    ->nullable()
                    ->comment('Legacy province field');
            },
            'region' => static function (Blueprint $table): void {
                $table->string('region')
                    ->nullable()
                    ->comment('Legacy region field');
            },
            'cap' => static function (Blueprint $table): void {
                $table->string('cap')
                    ->nullable()
                    ->comment('Legacy CAP field');
            },
        ];

        foreach ($legacyColumns as $name => $definition) {
            if ($migration === null || ! $migration->hasColumn($name)) {
                $definition($table);
            }
        }
    }
}
