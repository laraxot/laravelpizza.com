<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as RoutingController;

class BaseController extends RoutingController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
