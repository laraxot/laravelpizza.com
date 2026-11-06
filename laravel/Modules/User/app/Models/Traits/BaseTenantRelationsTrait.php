<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for BaseTenant.
 */
trait BaseTenantRelationsTrait
{
    /**
     * Ottiene tutti i membri associati al tenant.
     *
     * @return BelongsToMany<Model, $this, Pivot, 'pivot'>
     */
    public function members(): BelongsToMany
    {
        /** @var class-string<Model> $user_class */
        $user_class = XotData::make()->getUserClass();

        return $this->belongsToManyX($user_class);
    }

    /**
     * Ottiene tutti gli utenti associati al tenant.
     *
     * @return BelongsToMany<Model, $this, Pivot, 'pivot'>
     */
    public function users(): BelongsToMany
    {
        $xot = XotData::make();
        /** @var class-string<Model> $userClass */
        $userClass = $xot->getUserClass();

        // $this->setConnection('mysql');
        // return $this->belongsToManyX($userClass, null, 'tenant_id', 'user_id');
        return $this->belongsToManyX($userClass);

        // ->as('membership')
    }
}
