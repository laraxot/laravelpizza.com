<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Tenancy;

use Filament\Pages\Tenancy\RegisterTenant as BaseRegisterTenant;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Contracts\TenantContract;
use Modules\User\Models\BaseTenant;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;

class RegisterTenant extends BaseRegisterTenant
{
    use TransTrait;

    /**
     * @var class-string|null
     */
    private ?string $resourceClass = null;

    public static function getLabel(): string
    {
        $tenantClass = XotData::make()->getTenantClass();
        $func = Str::of(__FUNCTION__)->snake()->toString();
        if (Str::startsWith($func, 'get_')) {
            $func = Str::of($func)->after('get_')->toString();
        }
        $key = Str::of(class_basename(self::class))
            ->snake()
            ->prepend('actions.')
            ->append('.'.$func)
            ->toString();

        return static::transClass($tenantClass, $key);
    }

    public function schema(Schema $schema): Schema
    {
        /** @var array<Component> $components */
        $components = $this->getFormSchema();

        return $schema->components($components);
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        $resourceClass = $this->resolveResourceClass();

        $schemaRaw = $resourceClass::getFormSchema();

        /** @var array<Component> $schema */
        $schema = $schemaRaw;

        return $schema;
    }

    /**
     * @param  array<string, string|int|bool|null>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        $tenantClass = XotData::make()->getTenantClass();

        $tenant = $tenantClass::create($data);
        Assert::implementsInterface($tenant, TenantContract::class);
        Assert::isInstanceOf($tenant, BaseTenant::class);

        return $tenant;
    }

    /**
     * @return class-string
     */
    private function resolveResourceClass(): string
    {
        if ($this->resourceClass !== null) {
            return $this->resourceClass;
        }

        $tenantClass = XotData::make()->getTenantClass();
        $resourceClass = Str::of($tenantClass)
            ->replace('\\Models\\', '\\Filament\\Resources\\')
            ->append('Resource')
            ->toString();

        Assert::classExists($resourceClass);

        /** @var class-string $resolved */
        $resolved = $resourceClass;
        $this->resourceClass = $resolved;

        return $resolved;
    }
}
