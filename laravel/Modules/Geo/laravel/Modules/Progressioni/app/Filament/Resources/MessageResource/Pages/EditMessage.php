<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MessageResource\Pages;

use Modules\Progressioni\Filament\Resources\MessageResource;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\BaseEditMessage;

class EditMessage extends BaseEditMessage
{
    protected static string $resource = MessageResource::class;
}
