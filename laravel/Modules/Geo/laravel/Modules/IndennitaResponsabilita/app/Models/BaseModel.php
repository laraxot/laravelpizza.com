<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

// use Laravel\Scout\Searchable;
// ---------- traits
use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'indennita_responsabilita';

    protected $dateFormat = 'Y-m-d';

    /*
    public function images(): void {
        return $this->morphMany(Image::class, 'post');
    }
    */
}
