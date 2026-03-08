<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Tenancy;

use Filament\Pages\Tenancy\RegisterTenant as BaseRegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Models\BaseTenant;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;

class RegisterTenant extends BaseRegisterTenant
{
    use TransTrait;

    public static function getLabel(): string
    {
        return 'Registra Tenant';
    }

    public function schema(Schema $schema): Schema
    {
        $resourceClass = $this->resolveResourceClass();
        $components = $resourceClass::getFormSchema();

        return $schema->components($components);
    }

    protected function handleRegistration(array $data): Model
    {
        $tenantClass = XotData::make()->getTenantClass();
        $tenant = $tenantClass::create($data);
        Assert::isInstanceOf($tenant, BaseTenant::class);

        return $tenant;
    }

    private function resolveResourceClass(): string
    {
        $tenantClass = XotData::make()->getTenantClass();
        $resourceClass = Str::of($tenantClass)
            ->replace('\\Models\\', '\\Filament\\Resources\\')
            ->append('Resource')
            ->toString();

        Assert::classExists($resourceClass);

        return $resourceClass;
    }
}
