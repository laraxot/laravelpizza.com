<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Database\Factories\DomainFactory;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null    $id
 * @property string|null $name
 *
 * @method static Builder|Domain newModelQuery()
 * @method static Builder|Domain newQuery()
 * @method static Builder|Domain query()
 * @method static Builder|Domain whereId($value)
 * @method static Builder|Domain whereName($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static DomainFactory factory($count = null, $state = [])
 *
 * @mixin IdeHelperDomain
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Domain extends BaseModel
{
    use Sushi;

    /**
     * Model Rows.
     */
    public function getRows(): array
    {
        return app(GetDomainsArrayAction::class)->execute();
    }
}
