<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * Undocumented class.
 */
class PermissionData extends Data
{
    public PermissionModelsData $models;

    public PermissionTableNamesData $table_names;

    public PermissionColumnNamesData $column_names;

    public bool $register_permission_check_method;

    public bool $teams;

    public bool $display_permission_in_exception;

    public bool $display_role_in_exception;

    public bool $enable_wildcard_permission;

    public PermissionCacheData $cache;

    public static function make(): self
    {
        Assert::isArray($xot = config('permission'), 'check config [permission] ');

        return self::from($xot);
    }
}
