<?php

declare(strict_types=1);

namespace Modules\UI\View\Components\Render;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

/**
 * .
 */
class Block extends Component
{
    public ?string $view = null;

    public function __construct(
        public array $block,
        public ?Model $model = null,
        public string $tpl = '',
    ) {
        $view = Arr::get($this->block, 'data.view', null);
        if ($view === null) {
            $view = 'ui::empty';
        }
        Assert::string($view, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
        $this->view = $view;
    }

    public function render(): ViewFactory|View
    {
        if (! isset($this->block['type'])) {
            return view('ui::empty');
        }

        $view = $this->view;
        if (! view()->exists(is_string($view) ? $view : ((string) $view))) {
            $message = 'view not exists ['.$view.'] ! <pre>'.print_r($this->block, true).'</pre>';
            $view_params = [
                'title' => 'deprecated',
                'message' => $message,
            ];

            return view('ui::alert', $view_params);
        }
        $view_params_raw = $this->block['data'] ?? [];
        $view_params = is_array($view_params_raw) ? $view_params_raw : [];
        /** @var array<string, mixed> $view_params */
        $view_params = (array) $view_params;
        Assert::string($view, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
        if (! view()->exists($view)) {
            throw new \Exception('view not found ['.$view.']');
        }

        return view($view, $view_params);
    }
}
