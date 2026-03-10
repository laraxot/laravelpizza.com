<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Panel;

use Filament\Panel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Modules\User\Filament\Pages\Tenancy\EditTenantProfile;
use Modules\User\Filament\Pages\Tenancy\RegisterTenant;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Spatie\QueueableAction\QueueableAction;

class ApplyCalendarToPanelAction
{
    use QueueableAction;

    public function execute(Panel &$panel): Panel
    {
        $timezone = Config::string('fullcalendar.localization.timezone', 'Europe/Rome');
        $locale = Config::string('fullcalendar.localization.locale', 'it');
        $calendarPlugin = FilamentFullCalendarPlugin::make()
            ->selectable(true)
            ->editable(true)
            ->timezone($timezone)
            ->locale($locale)
            ->plugins([
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                //'scrollGrid',//premium
            ]);

        // Aggiungi licenza scheduler solo se presente e valida
        $licenseKey = config('fullcalendar.scheduler_license_key');
        if ($licenseKey && is_string($licenseKey) && !empty(trim($licenseKey))) {
            $calendarPlugin->schedulerLicenseKey($licenseKey);
        }

        $panel->plugin($calendarPlugin);

        return $panel;
    }
}
