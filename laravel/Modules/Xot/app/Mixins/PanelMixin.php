<?php

declare(strict_types=1);

namespace Modules\Xot\Mixins;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as NwidartModule;
use Webmozart\Assert\Assert;

/**
 * @method string getId()
 * @method string getName()
 * @method NwidartModule getModule()
 * @method array<string, mixed> getConfig()
 * @method array<string, mixed> getModuleConfig()
 * @method string getNavigationLabel()
 * @method string getNavigationIcon()
 * @method int getNavigationSort()
 */
class PanelMixin
{
    /**
     * @return \Closure
     */
    public function getName()
    {
        return function (): string {
            $id = $this->getId();
            $name = Str::before($id, '::');

            return $name;
        };
    }

    /**
     * @return \Closure
     */
    public function getModule()
    {
        return function (): NwidartModule {
            $name = $this->getName();
            $module = Module::find($name);

            return $module;
        };
    }

    /**
     * @return \Closure
     */
    public function getConfig()
    {
        return function (): array {
            $name = $this->getName();
            $config = Config::array($name);

            return $config;
        };
    }

    /**
     * @return \Closure
     */
    public function getModuleConfig()
    {
        return function (): array {
            $module = $this->getModule();
            $configFilePath = $module->getPath().'/config/config.php';
            $config = File::getRequire($configFilePath);
            Assert::isArray($config, '['.__LINE__.']['.class_basename($this).']');

            return $config;
        };
    }

    /**
     * @return \Closure
     */
    public function getNavigationLabel()
    {
        return function (): string {
            $config = $this->getModuleConfig();
            $name = Arr::get($config, 'name');
            Assert::string($name, '['.__LINE__.']['.class_basename($this).']');

            return $name;
        };
    }

    /**
     * @return \Closure
     */
    public function getNavigationIcon()
    {
        return function (): string {
            $config = $this->getModuleConfig();
            $icon = Arr::get($config, 'icon');
            Assert::string($icon, '['.__LINE__.']['.class_basename($this).']');

            return $icon;
        };
    }

    /**
     * @return \Closure
     */
    public function getNavigationSort()
    {
        return function (): int {
            return 0;
        };
    }
}
