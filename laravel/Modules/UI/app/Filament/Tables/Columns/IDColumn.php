<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Illuminate\Support\HtmlString;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;

/**
 * Colonna id obbligatoria: PK + ancora #record-{id} (self-link) + copyable.
 *
 * Callers: ogni getTableColumns() / Table Filament; Sigma history via
 * BaseSigmaHistoryScheda::withIdColumn(). Non usare TextColumn::make('id').
 *
 * Self-link `#record-{id}` + copyable sullo stato grezzo.
 * Return edit: {@see RecordAnchor::appendTo()}.
 *
 * @see Modules/UI/docs/adr/0002-idcolumn-mandatory-on-tables.md
 */
class IDColumn extends XotBaseTextColumn
{
    public static function make(?string $name = null): static
    {
        // Nessun label() fisso: LangServiceProvider via Column::configureUsing.
        // searchable() opt-in del chiamante.
        return parent::make($name ?? 'id')
            ->sortable()
            ->html()
            ->copyable()
            ->formatStateUsing(static fn (mixed $state): HtmlString => static::renderAnchor($state))
            ->copyableState(static fn (mixed $state): string => is_scalar($state) ? (string) $state : '');
    }

    /**
     * Self-link ancora: testo = id, href = `#record-{id}`.
     */
    public static function renderAnchor(mixed $state): HtmlString
    {
        $value = is_scalar($state) ? (string) $state : '';

        if ($value === '') {
            return new HtmlString('');
        }

        $escaped = e($value);
        $anchor = e(RecordAnchor::id($value));
        $fragment = e(RecordAnchor::fragment($value));

        return new HtmlString(
            '<a id="'.$anchor.'" href="'.$fragment.'" class="scroll-mt-24 fi-link text-primary-600 hover:underline" title="'.$fragment.'">'.$escaped.'</a>'
        );
    }
}
