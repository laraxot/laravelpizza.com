<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Traits\EnumTrait;

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
    use EnumTrait;

    case PHONE = 'phone';
    case MOBILE = 'mobile';
    case EMAIL = 'email';
    case PEC = 'pec';
    case WHATSAPP = 'whatsapp';
    case FAX = 'fax';

    /**
     * Internal map of standard contact column definitions.
     *
     * @return array<string, callable(Blueprint): void>
     */
    public static function getColumnDefinitions(): array
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
