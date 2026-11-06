<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Block;

use Spatie\QueueableAction\QueueableAction;
use UnexpectedValueException;

/**
 * Risolve dati block localizzati; delega al modulo Cms se presente.
 */
final class ResolveLocalizedBlockDataAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $viewParams
     * @return array<string, mixed>
     */
    public function execute(array $viewParams): array
    {
        $cmsAction = 'Modules\Cms\Actions\ResolveLocalizedBlockDataAction';

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
