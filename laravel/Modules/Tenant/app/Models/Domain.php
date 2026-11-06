<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Sushi\Sushi;

/**
 * @property string|null $id
 * @property string|null $name
 *
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 * @method static Builder<static>|Domain newModelQuery()
 * @method static Builder<static>|Domain newQuery()
 * @method static Builder<static>|Domain query()
 * @method static Builder<static>|Domain whereId($value)
 * @method static Builder<static>|Domain whereName($value)
 *
 */
class Domain extends BaseModel
{
    use Sushi;

    /**
     * Model Rows.
     *
     * @return array<int, array<string, string>>
     */
    public function getRows(): array
    {
        return app(GetDomainsArrayAction::class)->execute();
    }
}
