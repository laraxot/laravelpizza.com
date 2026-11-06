<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;

/** Reusable table representation of schema.org/Event properties. */
final class EventColumn extends GroupColumn
{
    protected const string DEFAULT_NAME = 'event';

    /** @var list<string> */
    protected array $fields = [
        'name',
        'description',
        'start_date',
        'end_date',
        'event_status',
        'event_attendance_mode',
        'location',
        'organizer',
        'performer',
        'image',
        'url',
    ];

    public static function make(?string $name = null): static
    {
        $column = parent::make($name ?? self::DEFAULT_NAME);

        return $column->schema($column->getSchema());
    }

    /** @param list<string> $fields */
    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this->schema($this->getSchema());
    }

    /** @return array<string, Column> */
    public function getSchema(): array
    {
        $schema = [];
        foreach ($this->fields as $field) {
            $schema[$field] = TextColumn::make($field);
        }

        return $schema;
    }
}
