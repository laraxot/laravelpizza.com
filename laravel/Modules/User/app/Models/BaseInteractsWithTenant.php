<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\User\Models\Traits\InteractsWithTenant;

/**
 * Class BaseInteractsWithTenant.
<<<<<<< HEAD
=======
 *
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, $this> tenant()
 * @see Modules/User/docs/architecture/architecture.md
>>>>>>> laraxot/dev
 */
abstract class BaseInteractsWithTenant extends BaseModel
{
    use InteractsWithTenant;
}
