<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Illuminate\Support\Collection;

/**
 * phpstan-require-extends Model.
 */
interface CanReceivePushNotifications
{
    /**
     * @return Collection<int, string>
     */
    public function getMobileDeviceTokens(): Collection;

    /**
     * Chiave primaria del modello notificabile (come Model::getKey()).
     * Senza tipo di ritorno: Model::getKey() non lo dichiara e un tipo qui renderebbe
     * incompatibile (fatal) ogni modello che implementa il contratto.
     *
     * @return int|string|null
     */
    public function getKey();
}
