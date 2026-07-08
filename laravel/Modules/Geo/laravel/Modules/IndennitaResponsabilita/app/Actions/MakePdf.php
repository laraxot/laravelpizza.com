<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Illuminate\Support\Collection;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Xot\Actions\Export\PdfByHtmlAction;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MakePdf
{
    use QueueableAction;

    /**
     * Execute PDF generation for Indennita Responsabilita.
     *
     * @param  array{'anno/valutatore'?: array{anno?: int|string|null, valutatore_id?: int|string|null}}  $data
     */
    public function execute(array $data): string|BinaryFileResponse
    {
        [$anno, $valutatoreId] = $this->resolveFilters($data);
        $rows = $this->buildRows($anno, $valutatoreId);
        $valutatore = $this->resolveValutatore($anno, $valutatoreId);
        $title = $this->buildTitle($rows, $anno);

        $view = 'indennitaresponsabilita::actions.make-pdf';
        $viewParams = [
            'view' => $view,
            'rows' => $rows,
            'title' => $title,
            'firma' => $valutatore->nome_diri ?? '',
        ];

        $html = view($view, $viewParams)->render();

        return app(PdfByHtmlAction::class)->execute($html);
    }

    /**
     * @param  array{'anno/valutatore'?: array{anno?: int|string|null, valutatore_id?: int|string|null}}  $data
     *
     * @return array{0: int|null, 1: int|null}
     */
    private function resolveFilters(array $data): array
    {
        $filters = $data['anno/valutatore'] ?? [];

        $anno = isset($filters['anno']) && is_numeric($filters['anno']) ? (int) $filters['anno'] : null;
        $valutatoreId = isset($filters['valutatore_id']) && is_numeric($filters['valutatore_id']) ? (int) $filters['valutatore_id'] : null;

        return [$anno, $valutatoreId];
    }

    /**
     * @return Collection<int, IndennitaResponsabilita>
     */
    private function buildRows(?int $anno, ?int $valutatoreId): Collection
    {
        $query = IndennitaResponsabilita::query()->with('ratings');

        if ($anno !== null) {
            $query->where('anno', $anno);
        }

        if ($valutatoreId !== null) {
            $query->where('valutatore_id', $valutatoreId);
        }

        $query->whereHas('ratings', static fn ($relation) => $relation->where('value', '>', 0));

        return $query->get();
    }

    private function resolveValutatore(?int $anno, ?int $valutatoreId): ?StabiDirigente
    {
        if ($anno === null || $valutatoreId === null) {
            return null;
        }

        return StabiDirigente::query()
            ->where('anno', $anno)
            ->where('valutatore_id', $valutatoreId)
            ->first();
    }

    /**
     * @param  Collection<int, IndennitaResponsabilita>  $rows
     */
    private function buildTitle(Collection $rows, ?int $anno): string
    {
        $firstRow = $rows->first();
        if ($firstRow !== null && $firstRow->anno !== null) {
            return sprintf('Indennita Responsabilita anno %s', (string) $firstRow->anno);
        }

        if ($anno !== null) {
            return sprintf('Indennita Responsabilita anno %s', (string) $anno);
        }

        return 'Indennita Responsabilita anno N/A';
    }
}
