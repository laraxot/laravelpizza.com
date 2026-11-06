<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TeamResource extends XotBaseResource
{
    /**
     * Get the model class name for this resource.
     *
     * @return class-string<Model>
     */
    #[\Override]
    public static function getModel(): string
    {
        $xot = XotData::make();

        /** @var class-string<Model> */
        return $xot->getTeamClass();
    }
}
