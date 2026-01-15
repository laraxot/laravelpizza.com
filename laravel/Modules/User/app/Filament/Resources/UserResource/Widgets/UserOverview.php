<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class UserOverview extends XotBaseWidget
{
    public ?Model $record = null;

    protected string $view = 'user::filament.resources.user-resource.widgets.user-overview';

    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
