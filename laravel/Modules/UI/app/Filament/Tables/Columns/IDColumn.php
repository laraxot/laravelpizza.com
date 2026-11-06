<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Illuminate\Support\HtmlString;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;

/**
 * Colonna id che funge anche da ancora della riga.
 *
 * La cella emette `id="record-{id}"`, quindi l'URL della lista con frammento
 * `#record-1875` porta il browser esattamente su quella riga. I link di ritorno
 * dall'edit lo appendono con {@see RecordAnchor::appendTo()}.
 */
class IDColumn extends XotBaseTextColumn
{
    public static function make(?string $name = null): static
    {
        // Nessun label() fisso: lo risolve Column::configureUsing (LangServiceProvider), come per ogni TextColumn('id').
        // Nessun searchable() forzato: la ricerca sull'id la sceglie il chiamante (LIKE su tutta la tabella, non e' gratis).
        return parent::make($name ?? 'id')
            ->sortable()
            ->html()
            ->formatStateUsing(static fn (mixed $state): HtmlString => static::renderAnchor($state))
            // Con copyable() Filament copia lo stato FORMATTATO: senza questo negli appunti finirebbe lo <span>.
            ->copyableState(static fn (mixed $state): string => is_scalar($state) ? (string) $state : '');
    }

    /**
     * Ancora della riga con il valore dell'id come testo.
     *
     * `scroll-mt-24` tiene la riga sotto l'header sticky invece che nascosta dietro.
     */
    public static function renderAnchor(mixed $state): HtmlString
    {
        $value = is_scalar($state) ? (string) $state : '';

        if ($value === '') {
            return new HtmlString('');
        }

        $escaped = e($value);
        $anchor = e(RecordAnchor::id($value));

        // Filament può già avvolgere la cella in un link di riga. Un secondo
        // <a> qui produrrebbe anchor annidati non validi; il link nativo della
        // riga resta l'affordance di navigazione, questo span è il target.
        return new HtmlString('<span id="'.$anchor.'" class="scroll-mt-24">'.$escaped.'</span>');
    }
}
