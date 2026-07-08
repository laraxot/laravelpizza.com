<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Actions\Header;

use Filament\Actions\Action;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;
use Spatie\QueueableAction\QueueableAction;

class CopiaValutatoreIdAction extends Action
{
    use QueueableAction;

    public static function make(?string $name = null): static
    {
        $name ??= 'copia_valutatore_id';

        return parent::make($name)
            ->label(__('performance::actions.copia_valutatore_id'))
            ->action(static::handle(...));
    }

    /**
     * Copia il campo valutatore_id da performance_individuale a performance_organizzativa
     * per le righe con stesso anno, ente, matr, stabi.
     */
    public static function handle(): void
    {
        // Query robusta e tipizzata
        $organizzative = Organizzativa::query()->get();
        foreach ($organizzative as $org) {
            $ind = Individuale::query()
                ->where('anno', $org->anno)
                ->where('ente', $org->ente)
                ->where('matr', $org->matr)
                ->where('stabi', $org->stabi)
                ->first();
            if ($ind && $ind->valutatore_id) {
                $org->valutatore_id = $ind->valutatore_id;
                $org->save();
            }
        }
    }
}
