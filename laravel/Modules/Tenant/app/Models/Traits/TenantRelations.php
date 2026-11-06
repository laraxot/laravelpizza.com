<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

trait TenantRelations
{
    /**
     * Relazione con gli utenti associati al tenant.
     *
     * @return HasMany<Model&UserContract, $this>
     */
    public function users(): HasMany
    {
        /** @var class-string<Model&UserContract> $userClass */
        $userClass = XotData::make()->getUserClass();

        /** @var HasMany<Model&UserContract, $this> $relation */
        $relation = $this->hasMany($userClass);

        return $relation;
    }
}
