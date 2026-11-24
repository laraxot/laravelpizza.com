<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Relazione `HasOne` che restituisce il figlio gia' in memoria, senza query.
 *
 * `first()` mantiene la firma del padre — `$columns` incluso — perche' una firma piu'
 * stretta produrrebbe un fatal error di incompatibilita' invece di un test rosso.
 *
 * @template TParent of UiCoverageAddressParentRecord
 *
 * @extends HasOne<UiCoverageAddressChildRecord, TParent>
 */
final class UiCoverageAddressHasOneRelation extends HasOne
{
    /** @param TParent $parent */
    public function __construct(UiCoverageAddressParentRecord $parent)
    {
        parent::__construct(UiCoverageAddressChildRecord::query(), $parent, 'id', 'id');
    }

    /**
     * @param  array<int, string>|string  $columns
     */
    public function first($columns = ['*']): ?Model
    {
        $parent = $this->getParent();
        if ($parent instanceof UiCoverageAddressParentRecord) {
            return $parent->addressModel;
        }

        return null;
    }
}
