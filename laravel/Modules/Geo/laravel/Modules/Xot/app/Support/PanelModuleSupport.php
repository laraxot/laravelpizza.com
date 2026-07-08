<?php

declare(strict_types=1);

namespace Modules\Xot\Support;

use Filament\Panel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as NwidartModule;
use Webmozart\Assert\Assert;

/**
 * Lettura config modulo nwidart da un Filament Panel (funzioni pure — non QueueableAction).
 */
final class PanelModuleSupport
{
    public static function moduleName(Panel $panel): string
    {
        $name = Str::before($panel->getId(), '::');
        Assert::stringNotEmpty($name);

        return $name;
    }

    public static function module(Panel $panel): NwidartModule
    {
        $module = Module::find(self::moduleName($panel));
        Assert::isInstanceOf($module, NwidartModule::class, sprintf('Module not found for panel [%s]', $panel->getId()));

        return $module;
    }

    /**
     * @return array<string, mixed>
     */
    public static function config(Panel $panel): array
    {
        $raw = Config::array(self::moduleName($panel));
        $config = [];

        foreach ($raw as $key => $value) {
            if (is_string($key)) {
                $config[$key] = $value;
            }
        }

        return $config;
    }

    /**
     * @return array<string, mixed>
     */
    public static function moduleConfig(Panel $panel): array
    {
        $configFilePath = self::module($panel)->getPath().'/config/config.php';

        /** @var array<string, mixed> $config */
        $config = File::getRequire($configFilePath);

        return $config;
    }

    public static function navigationLabel(Panel $panel): string
    {
        $name = Arr::get(self::moduleConfig($panel), 'name');
        if (! is_string($name) || '' === $name) {
            return self::moduleName($panel);
        }

        return $name;
    }

    public static function navigationIcon(Panel $panel): string
    {
        $icon = Arr::get(self::moduleConfig($panel), 'icon');
        if (! is_string($icon) || '' === $icon) {
            return 'heroicon-o-cube';
        }

        return $icon;
    }

    public static function navigationSort(Panel $panel): int
    {
        return 0;
    }
}
