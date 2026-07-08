<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits\Extras;

/*
 * Undocumented trait.
 */
// @phpstan-ignore trait.unused
trait SchedaExtra
{
    // /------ mass update -----------
    public function _percparttimepond(): int|float
    {
        $params['tablename'] = $this->getTable();

        $params['fieldname'] = 'percparttimepond';
        $params['fieldname_percparttime'] = 'percparttime';
        $params['fieldname_gg_parttimevert'] = 'giorni_parttimevert';
        $params['fieldname_gg_presenza'] = 'giorni_presenza';

        return $this->percparttime * (1 - ($this->giorni_parttimevert / $this->giorni_presenza));
    }
}
