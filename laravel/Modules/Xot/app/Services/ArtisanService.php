<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use function Safe\define;
use function Safe\fopen;
use function Safe\preg_match_all;

use Webmozart\Assert\Assert;

if (! defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

// ----- TODO
// --  1) capire come far fare da chiamato non da consolle "scout:import"

/**
 * Class ArtisanService.
 */
class ArtisanService
{
    /**
     * @throws FileNotFoundException
     */
    public static function act(string $act): string
    {
        // da fare anche in noconsole, e magari mettere un policy
        $module_name = Request::input('module', '');
        if (! is_string($module_name)) {
            $module_name = '';
        }
        switch ($act) {
            case 'migrate':
                DB::purge('mysql');
                DB::reconnect('mysql');
                if ('' !== $module_name) {
                    echo '<h3>Module '.$module_name.'</h3>';

                    return self::exe('module:migrate '.$module_name.' --force');
                }

                return self::exe('migrate --force');

            case 'routelist':
                return self::exe('route:list');
            case 'queue:flush':
                return self::exe('queue:flush');
            case 'routelist1':
                return self::showRouteList();
            case 'optimize':
                return self::exe('optimize');
            case 'clear':
                echo self::exe('cache:clear').PHP_EOL;
                echo self::exe('config:clear').PHP_EOL;
                echo self::exe('event:clear').PHP_EOL;
                echo self::exe('route:clear').PHP_EOL;
                echo self::exe('view:clear').PHP_EOL;
                echo self::exe('debugbar:clear').PHP_EOL;
                echo self::exe('opcache:clear').PHP_EOL;
                echo self::exe('optimize:clear').PHP_EOL;
                echo self::exe('key:generate').PHP_EOL;

                // -- non artisan
                echo self::sessionClear().PHP_EOL;
                echo self::errorClear().PHP_EOL;
                echo self::debugbarClear().PHP_EOL;
                echo PHP_EOL.'DONE'.PHP_EOL;
                break;
            case 'clearcache':
                return self::exe('cache:clear');
            case 'routecache':
                return self::exe('route:cache');
            case 'routeclear':
                return self::exe('route:clear');
            case 'viewclear':
                return self::exe('view:clear');
            case 'configcache':
                return self::exe('config:cache');
                // -------------------------------------------------------------------
            case 'debugbar:clear':
                self::debugbarClear();
                break;

                // ------------------------------------------------------------------

            case 'module-list':
                return self::exe('module:list');
            case 'module-disable':
                return self::exe('module:disable '.$module_name);
            case 'module-enable':
                return self::exe('module:enable '.$module_name);
                // ----------------------------------------------------------------------
            case 'error':
            case 'error-show':
                return self::errorShow()->render();
            case 'error-clear':
                return self::errorClear();

                // -------------------------------------------------------------------------
            case 'spatiecache-clear':
                /* da vedere se e' necessaria
                 * try {
                 * return \Spatie\ResponseCache\Facades\ResponseCache::clear();
                 * } catch (\Exception $e) {
                 * dddx($e);
                 * }
                 */
                // case 'spatiecache-clear1': return ArtisanService::exe('responsecache:clear'); //The command "responsecache:clear" does not exist.

            default:
                return '';
        }

        return '';
    }

    public static function errorShow(): Renderable
    {
        /**
         * @var view-string
         */
        $view = 'xot::acts.artisan.error-show';
        $files = File::files(storage_path('logs'));
        $log = request('log', '');
        if (! is_string($log)) {
            $log = '';
        }
        $content = '';
        if ('' !== $log && File::exists(storage_path('logs/'.$log))) {
            $content = File::get(storage_path('logs/'.$log));
        }

        $pattern = '/url":"([^"]*)"/';

        /** @var array<int, array<int, string>> $matches */
        $matches = [];
        preg_match_all($pattern, $content, $matches);

        /** @var array<int, string> $urls */
        $urls = [];
        $urlsRaw = $matches[1];
        if ([] !== $urlsRaw) {
            $urls = array_values(array_unique($urlsRaw));
        }

        $view_params = [
            'view' => $view,
            'lang' => app()->getLocale(),
            'files' => $files,
            'content' => $content,
            'urls' => $urls,
        ];

        return view((string) $view, $view_params);
    }

    public static function showRouteList(): string
    {
        $routeCollection = Route::getRoutes();
        /*
         * $view = ThemeService::g1etViewModule();
         *
         * dddx([
         * 'view' => $view,
         * 'this' => get_class(),
         * 'parent' => get_parent_class(),
         * 'debug' => \debug_backtrace(),
         * ]);
         */
        /*
         * $debug = \debug_backtrace();
         * $file = $debug[1]['file'];
         *
         * dddx([
         * 'file' => $file,
         * 'views' => ThemeService::getDefaultViewArray(),
         * ]);
         */
        /**
         * @var view-string
         */
        $view = 'xot::acts.artisan.show_route_list';
        $view_params = [
            'view' => $view,
            'routeCollection' => $routeCollection,
            'lang' => app()->getLocale(),
        ];

        $out = view((string) $view, $view_params);

        Assert::isInstanceOf($out, View::class);

        return $out->render();
    }

    public static function errorClear(): string
    {
        $files = File::files(storage_path('logs'));

        foreach ($files as $file) {
            if ('log' === $file->getExtension() && false !== $file->getRealPath()) {
                // Parameter #1 $paths of static method Illuminate\Filesystem\Filesystem::delete() expects array|string, Symfony\Component\Finder\SplFileInfo given.
                echo '<br/>'.$file->getRealPath();

                File::delete($file->getRealPath());
            }
        }

        return '<pre>laravel.log cleared !</pre> ('.\count($files).' Files )';
    }

    public static function sessionClear(): string
    {
        $files = File::files(storage_path('framework/sessions'));

        foreach ($files as $file) {
            if ('' === $file->getExtension() && false !== $file->getRealPath()) {
                // echo '<br/>'.$file->getRealPath();

                File::delete($file->getRealPath());

                // $file->delete();
            }
        }

        return 'Session cleared! ('.\count($files).' Files )';
    }

    public static function debugbarClear(): string
    {
        $files = File::files(storage_path('debugbar'));
        foreach ($files as $file) {
            if ('json' === $file->getExtension() && false !== $file->getRealPath()) {
                // echo '<br/>'.$file->getRealPath();

                File::delete($file->getRealPath());

                // $file->delete();
            }
        }

        return 'Debugbar Storage cleared! ('.\count($files).' Files )';
    }

    /**
     * @param array<string, mixed> $arguments
     */
    public static function exe(string $command, array $arguments = []): string
    {
        try {
            $output = '';

            Artisan::call($command, $arguments);

            return $output.'[<pre>'.Artisan::output().'</pre>]'; // dato che mi carico solo le route minime menufull.delete non esiste.. impostare delle route comuni.
        } catch (\Exception $exception) {
            // throw new Exception('['.__LINE__.']['.class_basename(__CLASS__).']');
            return '[<pre>'.$exception->getMessage().'</pre>]';

            // dddx(get_class_methods($e));
            /*
             * $vendor_dir = (realpath(LARAVEL_DIR.'/vendor'));
             * if (false === $vendor_dir) {
             * throw new \Exception('not recognize realpath laravel_dir/vendor');
             * }
             * $my = collect($e->getTrace())->filter(
             * function ($item) use ($vendor_dir) {
             * return isset($item['file']) && ! Str::startsWith($item['file'], $vendor_dir);
             * }
             * );
             *
             * //dddx([LARAVEL_DIR, $e->getTrace(), $e->getPrevious()]);
             * //dddx($my);
             * $msg = '<br/>'.$command.' non effettuato '.$e->getMessage().
             * '<br/>Code: '.$e->getCode().
             * '<br/>File: '.$e->getFile().
             * '<br/>Line: '.$e->getLine();
             * foreach ($my as $v) {
             * $msg .= '<br/>My File :'.$v['file'].
             * '<br/>My Line :'.$v['line'];
             * }
             *
             * return $msg;
             */
        } /*
         * //Dead catch - Symfony\Component\Console\Exception\CommandNotFoundException is already caught by Exception above.
         * catch (\Symfony\Component\Console\Exception\CommandNotFoundException $e) {
         * return '<br/>'.$command.' non effettuato';
         * }*/
    }
}
