<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Simple widget used to verify page filters behaviour (shows start/end dates).
 */
class UserWidget extends XotBaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isLazy = false;

    protected string $view = 'user::filament.resources.user.widgets.user-widget';

    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        /** @var array<string, mixed>|null $data */
        $data = $this->pageFilters;

        // PHPStan Level 10: Ensure we always return array
        return $data ?? [];
    }
}
