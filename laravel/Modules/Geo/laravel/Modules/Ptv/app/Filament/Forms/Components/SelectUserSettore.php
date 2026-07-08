<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Forms\Components;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class SelectUserSettore extends XotBaseSelect
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(function () {
            $user = Auth::user();
            if ($user === null) {
                return [];
            }
            $teams = $user->teams;
            $data = [];
            foreach ($teams as $team) {
                $data[$team->id] = $team->name;
            }

            return $data;
        });

        // $this->native(false);
    }
}
