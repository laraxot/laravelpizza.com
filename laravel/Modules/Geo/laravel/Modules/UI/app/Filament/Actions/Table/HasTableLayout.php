<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Modules\UI\Enums\TableLayoutEnum;

/**
 * Interface HasTableLayout.
 *
 * Definisce i metodi che devono essere implementati dalle classi
 * che gestiscono il layout delle tabelle.
 */
interface HasTableLayout
{
    /**
     * Ottiene il layout corrente della tabella.
     */
    public function getCurrentLayout(string $identifier = 'default'): TableLayoutEnum;

    /**
     * Salva il layout corrente nella sessione.
     */
    public function saveLayout(TableLayoutEnum $layout, string $identifier = 'default'): void;

    /**
     * Resetta il layout alla visualizzazione default.
     */
    public function resetLayout(string $identifier = 'default'): void;

    /**
     * Ottiene il layout della tabella dalla sessione o restituisce il default.
     */
    public function getTableLayout(): TableLayoutEnum;

    /**
     * Imposta il layout della tabella.
     */
    public function setTableLayout(TableLayoutEnum $layout): void;
}
