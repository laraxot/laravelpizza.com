<?php

declare(strict_types=1);
/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource/Pages/EditUser.php
 * Pagina di modifica utente per Filament.
 */

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use Modules\User\Filament\Resources\UserResource;

/**
 * Pagina per la modifica degli utenti con particolare gestione della password.
 *
 * Il filtro data (`startDate`/`endDate`) resta disponibile per eventuali widget
 * futuri che vogliano scoprire un intervallo temporale (es. grafici di attivita').
 * Il precedente `UserWidget` in footer si limitava a ri-mostrare in testo semplice
 * gli stessi due valori gia' visibili nel form dei filtri sopra: rimosso perche'
 * puramente ridondante (vedi audit in docs/wiki/user-resource-clustering-widgets-actions-audit.md).
 */
class ViewUser extends BaseViewUser
{
    use HasFiltersForm;

    protected static string $resource = UserResource::class;

    protected string $view = 'user::filament.resources.user.pages.view-user';

    protected bool $persistsFiltersInSession = true;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('startDate'),
                DatePicker::make('endDate'),
            ])->columns(2);
    }
}
