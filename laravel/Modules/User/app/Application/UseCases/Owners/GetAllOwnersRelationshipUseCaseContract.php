<?php

declare(strict_types=1);

namespace Modules\User\Application\UseCases\Owners;

use Illuminate\Support\Collection;

interface GetAllOwnersRelationshipUseCaseContract
{
    /**
     * Execute the use case to get all owners for relationship.
     *
     * @return Collection<int, mixed>
     */
    public function execute(): Collection;
}
