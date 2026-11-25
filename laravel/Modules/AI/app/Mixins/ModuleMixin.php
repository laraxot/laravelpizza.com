<?php

declare(strict_types=1);

namespace Modules\Xot\Mixins;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use Nwidart\Modules\Facades\Module;
use Webmozart\Assert\Assert;

/**
 * Mixin per il modello Module.
 *
 * @method string getPath()
 * @method string getName()
 * @method string getLocale()
 * @method string getGroup()
 * @method string getItem()
 * @method string getLangPath()
 * @method string getLangData()
 * @method string getLangItem()
 * @method string getLangPath()
 */
class ModuleMixin
{
    /**
     * @return \Closure
     */
    public function trans()
    {
        /*
         * @param string $key
         * @return string|array<string, mixed>|int|null
         */
        return function (string $key): string|array|int|null {
            $path = app(GetModulePathByGeneratorAction::class)->execute($this->getName(), 'lang');
            if (! Str::contains($key, '::')) {
                $key = $this->getName().'::'.$key;
            }
            $ns = Str::before($key, '::');
            $group = Str::betweenFirst($key, '::', '.');
            $item = Str::after($key, $ns.'::'.$group.'.');
            $langPath = $path.'/'.app()->getLocale().'/'.$group.'.php';
            $data = File::getRequire($langPath);
            Assert::isArray($data);
            $value = Arr::get($data, $item, null);

            if (
                $value !== null
                && ! is_array($value)
                && ! is_int($value)
                && ! is_string($value)
            ) {
                throw new \Exception('Expected array|int|string|null.');
            }

            return $value;
        };
    }
}
