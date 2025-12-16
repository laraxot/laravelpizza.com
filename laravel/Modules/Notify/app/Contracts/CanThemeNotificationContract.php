<?php

declare(strict_types=1);

namespace Modules\Notify\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Datas\NotificationData;

/**
 * phpstan-require-extends Model.
 */
interface CanThemeNotificationContract
{
    public function getNotificationData(string $name, array $view_params = []): NotificationData;

    public function getModel(): Model;

    /**
     * @return mixed|void
     */
    public function sendEmailCallback();

    /**
     * @return mixed|void
     */
    public function sendSmsCallback();

    public function increase(string $what, array $data): void;
}
