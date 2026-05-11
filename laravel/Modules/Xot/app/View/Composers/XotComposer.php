<?php

declare(strict_types=1);

namespace Modules\Xot\View\Composers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use Webmozart\Assert\Assert;

/**
 * Class XotComposer.
 */
class XotComposer
{
    /**
     * Undocumented function.
     *
     * @param array<mixed|void> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $modules = Module::getOrdered();

        $module = Arr::first($modules, static function ($module) use ($name): bool {
            // Ensure the module is an instance of LaravelModule
            if (! $module instanceof LaravelModule) {
                return false;
            }

            Assert::string($moduleName = $module->getName());
            $class = '\Modules\\'.$moduleName.'\View\Composers\ThemeComposer';

            return method_exists($class, $name);
        });

        if (! \is_object($module)) {
            throw new \Exception('Create a View\Composers\ThemeComposer.php inside a module with ['.$name.'] method');
        }

        Assert::isInstanceOf($module, LaravelModule::class, '['.__LINE__.']['.class_basename($this).']');
        $class = '\Modules\\'.$module->getName().'\View\Composers\ThemeComposer';

        $app = app($class);
        $callback = [$app, $name];
        Assert::isCallable($callback);

        return call_user_func_array($callback, $arguments);
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $lang = app()->getLocale();
        $view->with('lang', $lang);
        $view->with('_theme', $this);

        if (class_exists('\Jenssegers\Agent\Agent')) {
            $agent = new Agent();
            $view->with('isMobile', $agent->isMobile());
            $view->with('isTablet', $agent->isTablet());
            $view->with('isDesktop', $agent->isDesktop());
        }

        if (Auth::check()) {
            $profile = XotData::make()->getProfileModel();
            $view->with('profile', $profile);
            /** @var Authenticatable|null $user */
            $user = Auth::user();
            $view->with('user', $user);
        }
    }

    public function asset(string $str): string
    {
        return asset(app(AssetAction::class)->execute($str));
    }

    public function path(string $str): string
    {
        return app(AssetPathAction::class)->execute($str);
    }

    public function metatag(string $str): string|bool|null
    {
        $metatag = MetatagData::make();
        $fun = 'get'.Str::studly($str);
        if (method_exists($metatag, $fun)) {
            $resolved = $metatag->{$fun}();
            if (is_string($resolved) || is_bool($resolved) || null === $resolved) {
                return $resolved;
            }

            return null;
        }

        $raw = $metatag->{$str};
        if (is_string($raw) || is_bool($raw) || null === $raw) {
            return $raw;
        }

        return null;
    }
}
