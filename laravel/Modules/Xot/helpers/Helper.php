<?php

declare(strict_types=1);
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Modules\Xot\Actions\File\FixPathAction;

use function Safe\define;
use function Safe\preg_match;

use Webmozart\Assert\Assert;

if (! function_exists('merge_translation_files')) {
    /**
     * Merge split PHP translation files while preserving nested translation keys.
     *
     * @return array<string, mixed>
     */
    function merge_translation_files(string $first, string ...$rest): array
    {
        /** @var array<string, mixed> $result */
        $result = load_translation_array($first);

        /**
         * @param  array<string, mixed>  $base
         * @param  array<string, mixed>  $overlay
         * @return array<string, mixed>
         */
        $merge = static function (array $base, array $overlay) use (&$merge): array {
            foreach ($overlay as $key => $value) {
                if (is_string($key) && is_array($value) && is_array($base[$key] ?? null)) {
                    /** @var array<string, mixed> $nestedBase */
                    $nestedBase = $base[$key];
                    /** @var array<string, mixed> $nestedOverlay */
                    $nestedOverlay = $value;
                    $base[$key] = $merge($nestedBase, $nestedOverlay);
                } elseif (is_string($key)) {
                    $base[$key] = $value;
                }
            }

            return $base;
        };

        foreach ($rest as $file) {
            /** @var array<string, mixed> $merged */
            $merged = $merge($result, load_translation_array($file));
            $result = $merged;
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    function load_translation_array(string $file): array
    {
        $content = require $file;

        if (! is_array($content)) {
            return [];
        }

        $result = [];
        foreach ($content as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

if (! function_exists('isRunningTestBench')) {
    function isRunningTestBench(): bool
    {
        $path = app(FixPathAction::class)->execute('\vendor\orchestra\testbench-core\laravel');
        $base = app(FixPathAction::class)->execute(base_path());

        return Str::endsWith($base, $path);
    }
}

if (! function_exists('dddx')) {
    /** @param mixed $params Qualunque valore da dumpare (debug helper) */
    function dddx(mixed $params): void
    {
        $tmp = debug_backtrace();
        $start = defined('LARAVEL_START') ? (float) LARAVEL_START : microtime(true);
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', $start);
        }
        $data = [
            '_' => $params,
            'line' => $tmp[0]['line'] ?? 'line-unknows',
            'file' => app(FixPathAction::class)->execute($tmp[0]['file'] ?? 'file-unknown'),
            'time' => microtime(true) - $start,
            'memory_taken' => round(memory_get_peak_usage() / (1024 * 1024), 2).' MB',
        ];

        if (File::exists($data['file']) && Str::startsWith($data['file'], app(FixPathAction::class)->execute(storage_path('framework/views')))) {
            $content = File::get($data['file']);
            $data['view_file'] = app(FixPathAction::class)->execute(Str::between($content, '/**PATH ', ' ENDPATH**/'));
        }

        dd($data);
    }
}

if (! function_exists('in_admin')) {
    /** @param array<string, mixed> $params */
    function in_admin(array $params = []): bool
    {
        return inAdmin($params);
    }
}

if (! function_exists('inAdmin')) {
    /** @param array<string, mixed> $params */
    function inAdmin(array $params = []): bool
    {
        if (isset($params['in_admin'])) {
            return (bool) $params['in_admin'];
        }

        if (Request::segment(2) === 'admin') {
            return true;
        }

        $segments = Request::segments();

        return (is_countable($segments) ? count($segments) : 0) > 0 && $segments[0] === 'livewire' && session('in_admin') === true;
    }
}

if (! function_exists('params2ContainerItem')) {
    /**
     * @param  array<string, mixed>|null  $params
     * @return array{0: array<string, mixed>, 1: array<string, mixed>}
     */
    function params2ContainerItem(?array $params = null): array
    {
        if ($params === null) {
            $params = [];
            $route_current = Route::current();
            if ($route_current instanceof Illuminate\Routing\Route) {
                $params = $route_current->parameters();
            }
        }

        $container = [];
        $item = [];
        foreach ($params as $k => $v) {
            $pattern = '/(container|item)(\d+)/';
            preg_match($pattern, $k, $matches);
            if (count($matches) >= 3) {
                $sk = $matches[1];
                $sv = $matches[2];
                ${$sk}[$sv] = $v;
            }
        }

        return [$container, $item];
    }
}

if (! function_exists('xotModel')) {
    function xotModel(string $name): Model
    {
        $model_class = config('morph_map.'.$name);
        if (! is_string($model_class)) {
            throw new Exception('['.__LINE__.']');
        }

        Assert::isInstanceOf($res = app($model_class), Model::class);

        return $res;
    }
}

if (! function_exists('authId')) {
    function authId(): ?string
    {
        try {
            $id = Filament::auth()->id() ?? auth()->guard()->id();

            return $id === null ? null : (string) $id;
        } catch (Throwable $e) {
            return null;
        }
    }
}

if (! function_exists('trans_string')) {
    /** @param array<string, mixed> $replace */
    function trans_string(string $key, array $replace = [], ?string $locale = null): string
    {
        $safeReplace = [];
        foreach ($replace as $k => $v) {
            if (! is_string($k)) {
                continue;
            }

            $safeReplace[$k] = (is_scalar($v) || $v === null) ? $v : SafeStringCastAction::cast($v);
        }

        $result = __($key, $safeReplace, $locale);

        return is_string($result) ? $result : $key;
    }
}

if (! function_exists('isJson')) {
    function isJson(string $string): bool
    {
        return json_validate($string);
    }
}

/*
|--------------------------------------------------------------------------
| Pest Laravel Helper Stubs
|--------------------------------------------------------------------------
|
| Stubs for Pest global testing functions.
| These eliminate 'function not found' errors from PHPStan.
|
*/

if (! function_exists('xotPestStubFailure')) {
    /**
     * Errore comune dei finti helper Pest (actingAs, get, post, ...).
     *
     * Gli stub esistono solo per l'analisi statica: se vengono invocati a runtime il messaggio
     * riporta la chiamata tentata (nome e tipi degli argomenti) e rimanda all'helper Pest reale.
     */
    function xotPestStubFailure(string $function, mixed ...$arguments): never
    {
        $call = $function.'('.implode(', ', array_map(get_debug_type(...), $arguments)).')';

        throw new RuntimeException(sprintf('Stub %s: this function is meant for static analysis only, use the real Pest helper.', $call));
    }
}

if (! function_exists('actingAs')) {
    /**
     * @return TestResponse<Response>
     */
    function actingAs(Authenticatable|int|string|null $user = null, ?string $driver = null): TestResponse
    {
        xotPestStubFailure('actingAs', $user, $driver);
    }
}

if (! function_exists('get')) {
    /**
     * @param  array<string, mixed>  $options
     * @return TestResponse<Response>
     */
    function get(string $uri = '', array $options = []): TestResponse
    {
        xotPestStubFailure('get', $uri, $options);
    }
}

if (! function_exists('post')) {
    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $options
     * @return TestResponse<Response>
     */
    function post(string $uri, array $data = [], array $options = []): TestResponse
    {
        xotPestStubFailure('post', $uri, $data, $options);
    }
}

if (! function_exists('put')) {
    /**
     * @param  array<string, mixed>  $data
     * @return TestResponse<Response>
     */
    function put(string $uri, array $data = []): TestResponse
    {
        xotPestStubFailure('put', $uri, $data);
    }
}

if (! function_exists('patch')) {
    /**
     * @param  array<string, mixed>  $data
     * @return TestResponse<Response>
     */
    function patch(string $uri, array $data = []): TestResponse
    {
        xotPestStubFailure('patch', $uri, $data);
    }
}

if (! function_exists('delete')) {
    /**
     * @return TestResponse<Response>
     */
    function delete(string $uri): TestResponse
    {
        xotPestStubFailure('delete', $uri);
    }
}

if (! function_exists('head')) {
    /**
     * @return TestResponse<Response>
     */
    function head(string $uri): TestResponse
    {
        xotPestStubFailure('head', $uri);
    }
}

if (! function_exists('options')) {
    /**
     * @return TestResponse<Response>
     */
    function options(string $uri): TestResponse
    {
        xotPestStubFailure('options', $uri);
    }
}

if (! function_exists('followingRedirects')) {
    /**
     * @return TestResponse<Response>
     */
    function followingRedirects(int $number = 5): TestResponse
    {
        xotPestStubFailure('followingRedirects', $number);
    }
}

if (! function_exists('xotSeedModelOnce')) {
    /**
     * Idempotent entity seeder — PHPStan-safe factory chain via GetFactoryAction.
     *
     * @param  class-string<Model>  $modelClass
     */
    function xotSeedModelOnce(string $modelClass): void
    {
        (new GetFactoryAction)
            ->execute($modelClass)
            ->createOne();
    }
}
