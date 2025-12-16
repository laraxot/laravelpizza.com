<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Cms\Http\Controllers\BaseController;

/**
 * Class XotPanelController.
 */
class XotPanelController extends BaseController
{
    public function __call($method, $arg)
    {
        // Convert to proper types for internal use
        $method = (string) $method;
        $arg = (array) $arg;

        // dddx(['name' => $method, 'arg' => $arg]);
        /*
         * 0 => xotrequest
         * 1 => userPanel.
         */
        /*
         * $func = '\Modules\Xot\Jobs\PanelCrud\\'.Str::studly($method).'Job';
         *
         * $data = $arg[0];
         * if ($arg[0] instanceof Request) {
         * $data = $data->all();
         * }
         * $panel = $func::dispatchNow($data, $arg[1]);
         *
         * return $panel->out();
         */
        $act = '\Modules\Cms\Actions\Panel\\'.Str::studly($method).'Action';
        $data = $arg[0];
        if ($arg[0] instanceof Request) {
            $data = $arg[0]->all();
        }

        $action = app($act);
        if (! \is_object($action) || ! method_exists($action, 'execute')) {
            throw new \Exception("Action {$act} is not a valid object with execute method");
        }

        $panel = $action->execute($arg[1], $data);

        if (! \is_object($panel) || ! method_exists($panel, 'out')) {
            throw new \Exception('Panel is not a valid object with out method');
        }

        return $panel->out();
    }
}
