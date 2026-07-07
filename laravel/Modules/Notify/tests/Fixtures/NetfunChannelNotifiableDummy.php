<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Contracts\CanThemeNotificationContract;
use Modules\Notify\Datas\NotificationData;

final class NetfunChannelNotifiableDummy extends Model implements CanThemeNotificationContract
{
    protected $guarded = [];

    /** @var array<string, array<string, mixed>> */
    public array $increased = [];

    public function getNotificationData(string $name, array $view_params = []): NotificationData
    {
        return NotificationData::from([
            'from' => 'Xot',
            'recipient' => 'dummy@example.test',
            'body' => 'body',
            'channels' => ['sms'],
        ]);
    }

    public function getModel(): Model
    {
        return $this;
    }

    public function sendEmailCallback(): void {}

    public function sendSmsCallback(): void {}

    public function increase(string $what, array $data): void
    {
        $this->increased[$what] = $data;
    }
}
