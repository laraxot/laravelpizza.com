<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Modules\Ptv\Models\CriteriEsclusione as PtvCriteriEsclusione;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property bool $is_enabled
 * @property string|null $name
 * @property string|null $field_name
 * @property string|null $op
 * @property string|null $value
 * @property string|null $type
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 * @property-read EloquentCollection<int, Scheda> $schede
 * @property-read int|null $schede_count
 * @property-read EloquentCollection<int, CriteriOption> $criteriOptions
 * @property-read int|null $criteri_options_count
 *
 * @method static CriteriEsclusioneFactory factory($count = null, $state = [])
 * @method static Builder<static>|CriteriEsclusione query()
 * @method static Builder<static>|CriteriEsclusione whereAnno($value)
 *
 * @mixin \Eloquent
 */
class CriteriEsclusione extends PtvCriteriEsclusione implements CriteriEsclusioneContract
{
    protected $connection = 'progressione';

    /** @return Collection<string, mixed> */
    public function criteriOptionsCollection(): Collection
    {
        return $this->criteriOptions->mapWithKeys(
            static function (Model $item): array {
                $type = $item->getAttribute('type');
                $value = $item->getAttribute('value');
                $name = $item->getAttribute('name');

                if ($type === 'list' && is_string($value)) {
                    $value = explode(',', $value);
                }

                if ($type === 'int') {
                    $value = is_numeric($value) ? (int) (string) $value : 0;
                }

                if ($type === 'date' && is_string($value) && $value !== '') {
                    $value = Carbon::parse($value);
                }

                return is_string($name) ? [$name => $value] : [];
            }
        );
    }
}
