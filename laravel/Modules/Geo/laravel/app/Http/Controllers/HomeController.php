<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'home';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
