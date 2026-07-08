<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\EmployeeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\EmployeeResource;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getRedirectUrl(): string
    {
        $url = $this->getResource()::getUrl('index');

        return is_string($url) ? $url : '';
    }
}
