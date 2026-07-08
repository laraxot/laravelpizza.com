<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Actions\Header;

use Filament\Actions\Action;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;

/**
 * HeaderAction per copiare valutatore_id da performance_individuale a performance_organizzativa.
 * Esegue update solo sulle righe che hanno match su anno, ente, matr, stabi.
 * Conforme alle regole Windsurf/Laraxot, tipizzazione e PHPDoc completi.
 * Documentazione aggiornata in docs/organizzativa-migration-errors.md e docs/actions.md.
 */
class CopyValutatoreIdFromIndividualeAction extends Action
{
    /**
     * Crea una nuova HeaderAction per copiare valutatore_id da Individuale.
     *
     * Regola: il nome deve essere sempre univoco per evitare errori Filament.
     * Se non viene passato, viene impostato 'copy_valutatore_id_from_individuale'.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Il nome deve essere unico per evitare errori Filament (vedi docs/azioni_organizzativa.md)
        $this
            ->label(__('organizzativa.actions.copy_valutatore_id.label'))
            ->icon('heroicon-o-arrow-down-tray')
            ->requiresConfirmation()
            ->modalHeading(__('organizzativa.actions.copy_valutatore_id.label'))
            ->modalDescription(__('organizzativa.actions.copy_valutatore_id.confirm'))
            ->action(static::copyValutatoreId(...));
    }

    /**
     * Copia il campo valutatore_id da Individuale a Organizzativa per righe con stesso anno, ente, matr, stabi.
     *
     * @return int Numero di record aggiornati
     */
    public static function copyValutatoreId(): int
    {
        $updated = 0;
        $rows = Organizzativa::query()->get();
        foreach ($rows as $row) {

            $where = [
                'anno' => $row->anno,
                'ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->stabi,
            ];
            $ind = Individuale::query()
                ->firstWhere($where)
                ;
            if ($ind && $ind->valutatore_id && $row->valutatore_id !== $ind->valutatore_id) {
                $row->valutatore_id = $ind->valutatore_id;
                $row->save();
                $updated++;
            }
        }

        return $updated;
    }

    public static function CopyValutatoreIdFromIndividualeAction(): ?string
    {
        return 'individuale_spread_money';
    }
}
