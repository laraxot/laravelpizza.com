<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Block;

use Spatie\QueueableAction\QueueableAction;
use UnexpectedValueException;

/**
 * Risolve dati block localizzati; delega al modulo Cms se presente.
 *
 * Il resolver di Cms e' nominato per stringa (UI non puo' importare Cms, ADR 0004): la
 * classe che esiste e' `Modules\Cms\Actions\ResolveLocalizedBlockDataAction`. Fino al
 * 2026-11-25 la stringa diceva `GetLocalizedBlockDataAction`, nome che Cms non ha piu':
 * `class_exists` era sempre false e i blocchi non venivano mai localizzati, senza errori.
 * Chi rinomina la classe di Cms deve aggiornare la costante e il test.
 *
 * @see Modules/UI/docs/adr/0004-optional-cms-delegation-for-block-data.md
 *
 * @contract docs/contracts/resolve-localized-block-data-action.md
 */
final class GetLocalizedBlockDataAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $viewParams
     * @return array<string, mixed>
     */
    public function execute(array $viewParams): array
    {
        $cmsAction = 'Modules\\Cms\\Actions\\ResolveLocalizedBlockDataAction';

        if (! class_exists($cmsAction)) {
            return $viewParams;
        }

        $resolver = app($cmsAction);
        if (! is_object($resolver) || ! method_exists($resolver, 'execute')) {
            return $viewParams;
        }

        $resolved = $resolver->execute($viewParams);

        return is_array($resolved) ? $this->normalizeViewData($resolved) : $viewParams;
    }

    /**
     * @param  array<array-key, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeViewData(array $data): array
    {
        $viewData = [];

        foreach ($data as $key => $value) {
            if (! is_string($key)) {
                throw new UnexpectedValueException('Block view data must have string keys.');
            }

            $viewData[$key] = $value;
        }

        return $viewData;
    }
}
