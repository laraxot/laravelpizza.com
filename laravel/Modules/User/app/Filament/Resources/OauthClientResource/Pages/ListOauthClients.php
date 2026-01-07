<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
<<<<<<< HEAD
use Modules\User\Filament\Resources\OauthClientResource;
=======
<<<<<<< HEAD
use Modules\User\Filament\Resources\OauthClientResource;
=======
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListOauthClients.
 */
class ListOauthClients extends XotBaseListRecords
{
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 9d7e4c81 (.)
    protected static string $resource = OauthClientResource::class;

    /**
     * Get the header actions.
     *
     * @return array<string, Action>
     */
=======
    protected static string $resource = \Modules\User\Filament\Resources\OauthClientResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
>>>>>>> 939bd20e2 (.)
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
