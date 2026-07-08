<?php

declare(strict_types=1);

/**
 * PHPStan stubs for dynamic Panel mixin methods.
 * These methods are added at runtime by PanelMixin but need to be declared for static analysis.
 */

namespace Filament;

use Nwidart\Modules\Module;

/**
 * @method string getName() Get the module name from the panel ID
 * @method Module getModule() Get the underlying Nwidart module instance
 * @method array<string, mixed> getConfig() Get Laravel config array for the module
 * @method array<string, mixed> getModuleConfig() Get module config/config.php
 * @method string getNavigationLabel() Get navigation label from module config
 * @method string getNavigationIcon() Get navigation icon from module config
 * @method int getNavigationSort() Get navigation sort order from module config
 */
class Panel
{
}
