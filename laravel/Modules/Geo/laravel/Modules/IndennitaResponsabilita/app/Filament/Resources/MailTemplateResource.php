<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyBaseMailTemplateResource;
use Modules\Notify\Models\MailTemplate;
use Override;

/**
 * Resource per la gestione template email specifici del modulo Progressioni.
 *
 * Estende la resource base di Notify mantenendo stessa struttura ma
 * con filtro scope per mostrare solo template rilevanti per Progressioni.
 *
 * ⚠️ IMPORTANTE: Richiede SpatieTranslatablePlugin registrato nel panel!
 *
 * @see \Modules\Progressioni\Providers\Filament\AdminPanelProvider
 */
class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            // 'index' => \Modules\Progressioni\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates::route('/'),
        ];
    }

    /**
     * Filtra solo template email per modulo Progressioni.
     *
     * Mostra template il cui mailable contiene "Progressioni" o
     * il cui slug inizia con "progressioni-".
     *
     * @return Builder<MailTemplate>
     */
    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return MailTemplate::query()
            ->where(function (Builder $query): void {
                $query->where('slug', 'like', 'indennitaresponsabilita-%');
            });
    }
}
