<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Pulse;

use Illuminate\Contracts\View\View;
use Laravel\Pulse\Livewire\Card;
use Modules\User\Actions\Login\GetLoginStatsAction;

class LoginCard extends Card
{
    public function render(): View
    {
        $stats = app(GetLoginStatsAction::class)->execute();

        $this->dispatch(
            'login-chart-update',
            labels: $stats['labels'],
            values: $stats['trend'],
        );

        return view('user::filament.widgets.pulse.login-card', [
            'stats' => $stats,
        ]);
    }
}
