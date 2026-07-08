<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

// use Laravel\Scout\Searchable;
// ---------- traits
// use Modules\Xot\Traits\Updater;

abstract class BasePivot extends Pivot
{
    protected $connection = 'indennita_condizioni_lavoro'; // this will use the specified database connection
}
