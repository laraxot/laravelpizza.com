<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class XotBaseResourceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $components = static::getInfolistSchema();

        if ([] === $components) {
            throw new \RuntimeException(sprintf('Infolist [%s] returned empty array from getInfolistSchema(). Every infolist MUST expose at least one entry. Use real fields from the related Model/migration/fillable — do not invent.', static::class));
        }

        foreach (array_keys($components) as $key) {
            if (! \is_string($key)) {
                throw new \RuntimeException(sprintf('Infolist [%s] returned a numeric-keyed array from getInfolistSchema(). Keys MUST be strings (use the field name, e.g. "name" => TextEntry::make("name")).', static::class));
            }
        }

        return $schema->components($components);
    }

    /**
     * @return array<string, Entry>
     *
     * ⚠️ REGOLA: l'array NON può essere vuoto!
     * Per determinare i campi corretti:
     * 1. Studiare il Model collegato (app/Models/<Name>.php)
     * 2. Studiare la Migration (database/migrations/*_create_<names>_table.php)
     * 3. Consultare $fillable nel model
     * 4. Usare i campi reali del database, NON inventare campi
     */
    public static function getInfolistSchema(): array
    {
        return [];
    }

    /**
     * @param array<int|string, Component|Htmlable|string> $schema
     */
    protected static function getTabByName(
        string $name,
        array $schema,
        string|\BackedEnum|Htmlable|\Closure|null $icon = null,
        int $columns = 1,
    ): Tab {
        $moduleLow = Str::of(static::class)->between('Modules\\', '\\Filament')->lower()->toString();
        $group = Str::of(class_basename(static::class))->kebab()->toString();
        $labelKey = $moduleLow.'::'.$group.'.tabs.'.$name.'.label';
        $label = __($labelKey);

        // __() always returns string, so we just use it directly
        $tab = Tab::make(\is_string($label) ? $label : $labelKey)
            ->columns($columns)
            ->schema(array_values($schema));

        if (null !== $icon) {
            $tab->icon($icon);
        }

        return $tab;
    }
}
