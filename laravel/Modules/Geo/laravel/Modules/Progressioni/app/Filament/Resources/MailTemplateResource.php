<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyBaseMailTemplateResource;
use Modules\Progressioni\Providers\Filament\AdminPanelProvider;
use Modules\Sigma\Models\Integparam;
use Override;

/**
 * Resource per la gestione template email specifici del modulo Progressioni.
 *
 * Estende la resource base di Notify mantenendo stessa struttura ma
 * con filtro scope per mostrare solo template rilevanti per Progressioni.
 *
 * ⚠️ IMPORTANTE: Richiede SpatieTranslatablePlugin registrato nel panel!
 *
 * @see AdminPanelProvider
 */
class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    // protected static ?string $model = Integparam::class;

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
}
