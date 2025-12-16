<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class RecordNotificationData extends Data
{
    public UserContract $record;
    public string $channel;

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getRoute(): string
    {
        switch ($this->channel) {
            case 'mail':
                Assert::string($email = $this->record->email, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
                return $email;
            case 'sms':
                Assert::string($phone = $this->record->phone, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
                $phone = app(NormalizePhoneNumberAction::class)->execute($phone);
                return $phone;
        }
        throw new Exception('Channel [' . $this->channel . '] not supported');
    }
}
