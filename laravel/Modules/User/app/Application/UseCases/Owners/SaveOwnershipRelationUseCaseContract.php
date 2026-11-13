<?php

declare(strict_types=1);

namespace Modules\User\Application\UseCases\Owners;

use Laravel\Passport\Client;

interface SaveOwnershipRelationUseCaseContract
{
    /**
     * Execute the use case to save ownership relation.
     *
     * @param  mixed  $actor  Actor performing the operation (authenticated user
     *                        model or system identity; no narrower contract exists).
     */
    public function execute(Client $client, int $ownerId, mixed $actor): void;
}
