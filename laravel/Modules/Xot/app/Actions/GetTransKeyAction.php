<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetTransKeyAction
{
    use QueueableAction;

    /**
     * Generate a translation key based on the class name.
     */
    public function execute(string $class = ''): string
    {
        $class0 = $class;
        // If no class is provided, try to get it from the backtrace
        if ($class === '') {
            /** @var list<array{function: string, line?: int, file?: string, class?: class-string, type?: '->'|'::', args?: list<mixed>, object?: object}> $backtrace PHPStan knows this is always array */
            $backtrace = debug_backtrace();
            $class = Arr::get($backtrace, '1.class');
            Assert::string($class, '['.__LINE__.']['.class_basename($this).']');
        }

        $arr = explode('\\', $class);

        // Handle cases where the provided class is not in the "Modules" namespace
        if ($arr[0] !== 'Modules') {
            $backtrace = array_slice(debug_backtrace(), 2);
            $res = Arr::first(
                $backtrace,
                fn (array $item): bool => (isset($item['object']) && explode('\\', get_class($item['object']))[0] === 'Modules'),
            );

            if ($res === null || ! isset($res['object'])) {
                $page = Arr::get(debug_backtrace(), '0.args.0');
                Assert::string($page, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
                $main_module = XotData::make()->main_module;
                $main_module_low = mb_strtolower($main_module);
                $page_arr = explode('\\', $page);
                $page_arr_count = count($page_arr);
                $page_arr_last = $page_arr[$page_arr_count - 1];
                $page_arr_last_snake = Str::of($page_arr_last)->snake()->toString();

                return $main_module_low.'::'.$page_arr_last_snake;
            }

            $class = get_class($res['object']);
            $arr = explode('\\', $class);
        }

        $module = $arr[1];
        $module_low = mb_strtolower($module);
        $c = count($arr);

        $type = Str::singular($arr[$c - 2]);
        $class = $arr[$c - 1];

        // If the class name ends with the type, remove the suffix
        if (Str::endsWith($class, $type)) {
            $class = Str::beforeLast($class, $type);
            if (in_array($type, ['RelationManager'], strict: true)) {
                $class = Str::of($class)->singular()->toString();
            }
        }

        $class_snake = Str::of($class)->snake()->toString();
        $arr = explode('_', $class_snake);
        $first = $arr[0];
        $last = $arr[count($arr) - 1];
        if (in_array($first, ['dashboard', 'list', 'get', 'manage', 'edit', 'view'], strict: true)) {
            $class_snake = implode('_', array_slice($arr, 1));
        }
        if (in_array($last, ['action'], strict: true)) {
            $class_snake = Str::beforeLast($class_snake, '_'.$last);
        }

        if (Str::endsWith($class_snake, 'form_schema')) {
            $class_snake = Str::beforeLast($class_snake, '_form_schema');
        }

        // Handle cases where the class starts with "list_"
        if (in_array($first, ['list'], strict: true)) {
            $class_snake = Str::of($class_snake)
                // ->after('list_')
                ->singular()
                ->toString();
        }

        return $module_low.'::'.$class_snake;
    }
}
