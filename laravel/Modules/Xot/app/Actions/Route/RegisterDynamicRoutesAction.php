<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\preg_replace;

/**
 * Replaces Modules\Xot\Services\RouteDynService::dynamic_route() and its
 * private helpers.
 *
 * Kind A: the original service exposed ~18 static methods, but all of them
 * (besides getMethod(), moved to its own GetRouteMethodAction — it is a
 * standalone pure helper independently tested) are internal, mutually
 * recursive steps of a single cohesive operation: compiling a route DSL
 * array into Route::group()/resource()/match() calls. Forcing each parsing
 * step into its own QueueableAction would require an app()->execute() call
 * for every recursive step of one algorithm, which is not what the
 * Action-per-independent-operation shape is for. They are kept as private
 * methods of this single execute() entrypoint instead.
 */
class RegisterDynamicRoutesAction
{
    use QueueableAction;

    private string $namespaceStart = '';

    /**
     * @param  array<int, array<string, mixed>>  $array
     * @param  string|null  $namespace  Namespace del gruppo padre: non serve ai passi interni (Route::group()
     *                                  accumula da solo i namespace annidati), resta per compatibilita' con
     *                                  RouteDynService::dynamic_route().
     */
    public function execute(
        array $array,
        ?string $namespace = null,
        ?string $namespaceStart = null,
        ?string $curr = null,
    ): void {
        Assert::notEmpty($array, 'The $array parameter cannot be empty.');

        if ($namespaceStart !== null) {
            $this->namespaceStart = $namespaceStart;
        }

        foreach ($array as $v) {
            Assert::isArray($v, 'Each item in the array must be an array.');
            $groupOpts = $this->getGroupOpts($v);
            $v['group_opts'] = $groupOpts;

            $this->createRouteResource($v);

            Route::group($groupOpts, function () use ($v, $curr): void {
                $this->createRouteActs($v, $curr);
                $this->createRouteSubs($v, $curr);
            });
        }
    }

    /**
     * @param  array<string, mixed>  $v
     * @return array<string, mixed>
     */
    private function getGroupOpts(array $v): array
    {
        return [
            'prefix' => $this->getPrefix($v),
            'namespace' => $this->getNamespace($v),
            'as' => $this->getAs($v),
        ];
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getPrefix(array $v): string
    {
        if (isset($v['prefix'])) {
            Assert::string($prefix = $v['prefix']);

            return $prefix;
        }

        Assert::string($name = $v['name']);
        $prefix = mb_strtolower($name);
        $paramName = $this->getParamName($v);
        if ($paramName !== '') {
            return $prefix.'/{'.$paramName.'}';
        }

        return $prefix;
    }

    private function stripPattern(string $input, string $pattern): string
    {
        $replaced = preg_replace($pattern, '', $input);

        return is_string($replaced) ? $replaced : $input;
    }

    private function stripCurlyBraces(string $value): string
    {
        return str_replace(['{', '}'], '', $value);
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getAs(array $v): string
    {
        if (isset($v['as'])) {
            Assert::string($as = $v['as']);

            return $as;
        }

        Assert::string($name = $v['name']);
        $as = mb_strtolower($name);
        $as = str_replace('/', '.', $as);
        $as = $this->stripPattern($as, '/{.*}./');
        $as = $this->stripCurlyBraces($as);

        return $as.'.';
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getNamespace(array $v): ?string
    {
        if (isset($v['namespace'])) {
            Assert::string($namespace = $v['namespace']);

            return $namespace;
        }

        Assert::string($namespace = $v['name']);
        $namespace = $this->stripCurlyBraces($namespace);
        if ($namespace === '') {
            return null;
        }

        return Str::studly($namespace);
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getAct(array $v): string
    {
        if (isset($v['act'])) {
            Assert::string($act = $v['act']);

            return $act;
        }

        Assert::nullOrString($v['act'] = $v['name']);
        Assert::nullOrString($v['act']);

        $act = (string) ($v['act'] ?? '');
        $act = $this->stripPattern($act, '/{.*}\//');
        $act = str_replace('/', '_', $act);

        $camelCase = Str::camel($act);
        $act = $this->stripCurlyBraces($camelCase);

        return Str::camel($act);
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getParamName(array $v): string
    {
        if (isset($v['param_name'])) {
            Assert::string($paramName = $v['param_name']);

            return $paramName;
        }

        Assert::string($name = $v['name']);
        $paramName = 'id_'.$name;
        $paramName = $this->stripCurlyBraces($paramName);

        return mb_strtolower($paramName);
    }

    /**
     * @param  array<string, mixed>  $v
     * @return array<int, string>
     */
    private function getParamsName(array $v): array
    {
        $paramName = $this->getParamName($v);

        return [$paramName];
    }

    /**
     * @param  array<string, mixed>  $v
     * @return array<string, mixed>
     */
    private function getResourceOpts(array $v): array
    {
        $paramName = $this->getParamName($v);
        $paramsName = $this->getParamsName($v);

        Assert::string($v['name']);

        $opts = [
            'parameters' => [mb_strtolower($v['name']) => implode('}/{', $paramsName)],
            'names' => $this->prefixedResourceNames($this->getAs($v)),
        ];

        if (isset($v['only'])) {
            $opts['only'] = $v['only'];
        }

        if ($paramName === '' && ! isset($opts['only'])) {
            $opts['only'] = ['index'];
        }

        $opts['where'] = array_fill_keys($paramsName, '[0-9]+');

        return $opts;
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getController(array $v): string
    {
        if (isset($v['controller'])) {
            Assert::string($controller = $v['controller']);

            return $controller;
        }

        Assert::string($v['controller'] = $v['name']);
        $v['controller'] = str_replace('/', '_', $v['controller']);
        $v['controller'] = $this->stripCurlyBraces($v['controller']);
        $v['controller'] = Str::studly($v['controller']);
        $v['controller'] .= 'Controller';

        return $v['controller'];
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getUri(array $v): string
    {
        Assert::string($name = $v['name']);

        return $name;
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function getUses(array $v): string
    {
        $controller = $this->getController($v);
        $act = $this->getAct($v);

        return $controller.'@'.$act;
    }

    /**
     * @param  array<string, mixed>  $v
     * @return array<string, mixed>
     */
    private function getCallback(array $v, ?string $curr): array
    {
        Assert::string($name = $v['name']);
        $as = Str::slug($name);
        $uses = $this->getUses($v);
        $uses = $curr !== null
            ? '\\'.$this->namespaceStart.'\\'.$curr.'\\'.$uses
            : '\\'.$this->namespaceStart.'\\'.$uses;

        return ['as' => $as, 'uses' => $uses];
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function createRouteResource(array $v): void
    {
        if ($v['name'] === null) {
            return;
        }
        Assert::string($name = $v['name']);
        $opts = $this->getResourceOpts($v);
        $controller = $this->getController($v);

        Route::resource($name, $controller, $opts);
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function createRouteSubs(array $v, ?string $curr): void
    {
        if (! isset($v['subs'])) {
            return;
        }

        $subNamespace = $this->getNamespace($v);
        $curr = $curr ?? $subNamespace;
        Assert::isArray($subs = $v['subs']);
        /** @var array<int, array<string, mixed>> $subs */
        $this->execute($subs, $subNamespace, null, $curr);
    }

    /**
     * @param  array<string, mixed>  $v
     */
    private function createRouteActs(array $v, ?string $curr): void
    {
        if (! isset($v['acts']) || ! is_array($v['acts'])) {
            return;
        }

        $controller = $this->getController($v);
        foreach ($v['acts'] as $v1) {
            Assert::isArray($v1);
            /** @var array<string, mixed> $v1 */
            $v1['controller'] = $controller;

            $method = app(GetRouteMethodAction::class)->execute($v1);
            $uri = $this->getUri($v1);
            $callback = $this->getCallback($v1, $curr);
            Route::match($method, $uri, $callback);
        }
    }

    /**
     * @return array<string, string>
     */
    private function prefixedResourceNames(string $prefix): array
    {
        if (mb_substr($prefix, -1) === '.') {
            $prefix = mb_substr($prefix, 0, -1);
        }

        return [
            'index' => $prefix.'.index',
            'create' => $prefix.'.create',
            'store' => $prefix.'.store',
            'show' => $prefix.'.show',
            'edit' => $prefix.'.edit',
            'update' => $prefix.'.update',
            'destroy' => $prefix.'.destroy',
        ];
    }
}
