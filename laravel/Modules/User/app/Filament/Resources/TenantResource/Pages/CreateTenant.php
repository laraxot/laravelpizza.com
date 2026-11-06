<?php

declare(strict_types=1);
/**
 * --.
 */

namespace Modules\User\Filament\Resources\TenantResource\Pages;

use Modules\User\Filament\Resources\TenantResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateTenant extends XotBaseCreateRecord
{
    protected static string $resource = TenantResource::class;

    /*
     * }
     *
     * // :30    Method Modules\User\Filament\Resources\TenantResource\Pages\CreateTenant::createTenantRecord() is unused.
     * //      ✏️  User\Filament\Resources\TenantResource\Pages\CreateTenant.php
     * // /**
     * //  * @throws \Throwable
     * //  */
    // private function createTenantRecord(array $data)
    // {
    //     $record = $record::find($record->);
    //     $record->domains()->create(['domain' => collect($data)->get('domain')]);
    //     return $record;
    // }
}
