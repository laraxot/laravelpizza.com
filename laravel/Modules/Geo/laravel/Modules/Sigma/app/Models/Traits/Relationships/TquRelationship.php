<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sigma\Models\Tqu00f;

/**
 * Undocumented trait.
 */
trait TquRelationship
{
    /**
     * Undocumented function.
     *
     * @return HasOne<Tqu00f, $this>
     */
    public function tqu00f(): HasOne
    {
        $row = $this->hasOne(Tqu00f::class, 'propro', 'propro')->where('posfun', $this->posfun)->whereRaw('tqann=""');
        $fields = ['codqua', 'cont', 'tipco'];
        foreach ($fields as $field) {
            if ($this->$field === '') {
                continue;
            }

            $row = $row->where($field, $this->$field);
        }

        return $row;
    }
}
