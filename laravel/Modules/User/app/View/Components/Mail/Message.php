<?php

declare(strict_types=1);

namespace Modules\User\View\Components\Mail;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Xot\Datas\MetatagData;

class Message extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        // public string $message
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        $metatag = MetatagData::make();
        $view = 'user::components.mail.html.message';
        $view_params = [
            'logo' => asset($metatag->getLogoHeader()),
        ];

        return view($view, $view_params);
    }
}
