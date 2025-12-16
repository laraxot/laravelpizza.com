<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Meetup ServiceProvider - Laraxot Compliant.
 *
 * Follows Laraxot Philosophy:
 * - Logic: Mathematical precision in type safety
 * - Politics: Respects XotBaseServiceProvider hierarchy
 * - Religion: Extends XotBaseServiceProvider, not ServiceProvider
 * - Philosophy: DRY + KISS principles
 * - Zen: Simple, effective implementation
 */
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
