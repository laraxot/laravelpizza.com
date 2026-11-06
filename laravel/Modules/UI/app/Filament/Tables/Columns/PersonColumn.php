<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Forms\Components\PersonSection;

/**
 * Controparte in lista di {@see PersonSection}.
 *
 * Campi diretti sul record (nessuna dot-notation di relazione, a differenza di
 * {@see AddressColumn}): la persona e' il record stesso, non un suo correlato.
 *
 * Mappatura verso https://schema.org/Person, solo a scopo documentale — i nomi dei
 * campi restano quelli del progetto (mai `name`/`surname`, vedi
 * Modules/Xot/docs/consolidated/archive/personal-name-fields.md):
 *
 * | Campo progetto | schema.org/Person |
 * |-----------------|--------------------|
 * | `first_name`    | `givenName`        |
 * | `last_name`     | `familyName`       |
 * | `email`         | `email`            |
 * | `mobile_phone`  | `telephone`        |
 * | `language`      | `knowsLanguage`    |
 *
 * Usage:
 * ```php
 * 'person' => PersonColumn::make(),
 * 'person' => PersonColumn::make()->fields(['first_name', 'last_name']),
 * ```
 *
 * @see Modules/UI/docs/form-column-parity.md
 */
class PersonColumn extends GroupColumn
{
    protected const string DEFAULT_NAME = 'person';

    /**
     * @var list<string>
     */
    protected array $fields = [
        'first_name',
        'last_name',
        'email',
        'mobile_phone',
        'language',
    ];

    public static function make(?string $name = null): static
    {
        $column = parent::make($name ?? static::DEFAULT_NAME);

        return $column->schema($column->getSchema())->searchable($column->fields);
    }

    /**
     * Sostituisce l'elenco dei campi mostrati.
     *
     * @param  list<string>  $fields
     */
    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this->schema($this->getSchema())->searchable($fields);
    }

    /**
     * @return array<string, Column>
     */
    public function getSchema(): array
    {
        $schema = [];
        foreach ($this->fields as $field) {
            $schema[$field] = TextColumn::make($field);
        }

        return $schema;
    }
}
