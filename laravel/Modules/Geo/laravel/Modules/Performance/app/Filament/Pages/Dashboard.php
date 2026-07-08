<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Pages;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    /**
 * @return void
*/
    /*
    public function __construct() {
            $user=Auth::user();
            if($user==null){
                abort(403);
            }

            $name=static::getName();//"getName" => "modules.performance.filament.pages.dashboard"
            $module=collect(explode('.',(string) $name))->get(1);
            if(!$user->hasModule($module)){
                abort(403);
            }


        }
        */
}
