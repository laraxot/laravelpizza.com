<?php

declare(strict_types=1);

namespace Modules\UI\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * Radio Card Selector Component.
 *
 * Componente riutilizzabile per selezione tramite card radio.
 * Popola automaticamente un TextInput con il nome dell'elemento selezionato.
 */
class RadioCardSelector extends XotBaseField
{
    protected string $view = 'ui::forms.components.radio-card-selector';

    /**
     * @var array<int, array<string, mixed>>|\Closure
     */
    protected array|\Closure $cards = [];

    protected ?string $sectionTitle = null;

    protected ?string $sectionSubtitle = null;

    protected ?string $targetFieldName = null;

    protected ?string $emptyStateTitle = null;

    protected ?string $emptyStateDesc = null;

    /**
     * Imposta le card disponibili per la selezione.
     *
     * @param array<int, array<string, mixed>>|\Closure $cards
     */
    public function cards(array|\Closure $cards): static
    {
        $cards = $cards;

        return $this;
    }

    /**
     * Imposta il titolo della sezione.
     */
    public function sectionTitle(?string $title): static
    {
        $sectionTitle = $title;

        return $this;
    }

    /**
     * Imposta il sottotitolo della sezione.
     */
    public function sectionSubtitle(?string $subtitle): static
    {
        $sectionSubtitle = $subtitle;

        return $this;
    }

    /**
     * Campo da popolare quando si seleziona una card.
     */
    public function populatesField(string $fieldName): static
    {
        $targetFieldName = $fieldName;

        return $this;
    }

    /**
     * Imposta il titolo dello stato vuoto.
     */
    public function emptyStateTitle(?string $title): static
    {
        $emptyStateTitle = $title;

        return $this;
    }

    /**
     * Imposta la descrizione dello stato vuoto.
     */
    public function emptyStateDescription(?string $description): static
    {
        $emptyStateDesc = $description;

        return $this;
    }

    /**
     * Ottiene le card per la visualizzazione.
     */
    public function getCards(): array
    {
        $result = $this->evaluate($this->cards);

        return \is_array($result) ? $result : [];
    }

    /**
     * Ottiene il titolo della sezione.
     */
    public function getSectionTitle(): ?string
    {
        return $sectionTitle;
    }

    /**
     * Ottiene il sottotitolo della sezione.
     */
    public function getSectionSubtitle(): ?string
    {
        return $sectionSubtitle;
    }

    /**
     * Ottiene il nome del campo target.
     */
    public function getTargetFieldName(): ?string
    {
        return $targetFieldName;
    }

    /**
     * Ottiene il titolo dello stato vuoto.
     */
    public function getEmptyStateTitle(): ?string
    {
        return $emptyStateTitle;
    }

    /**
     * Ottiene la descrizione dello stato vuoto.
     */
    public function getEmptyStateDescription(): ?string
    {
        return $emptyStateDesc;
    }
}
