<?php

declare(strict_types=1);

namespace Modules\UI\View\Components\Render;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\UI\Actions\Block\ResolveLocalizedBlockDataAction;
use UnexpectedValueException;
use Webmozart\Assert\Assert;

/**
 * .
 */
class Block extends Component
{
    public ?string $view = null;

    /**
     * @param  array<string, mixed>  $block
     */
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
            $viewParams = [
                'title' => 'deprecated',
                'message' => $message,
            ];

            return view('ui::alert', $viewParams);
        }
        $rawData = $this->block['data'] ?? [];
        $viewParams = \is_array($rawData) ? $this->normalizeViewData($rawData) : [];
        $viewParams = app(ResolveLocalizedBlockDataAction::class)->execute($viewParams);
        $viewParams = $this->normalizeViewData($viewParams);
        Assert::string($view, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        /** @var view-string $view */
        return view($view, $viewParams);
    }

    /**
     * @param  array<array-key, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeViewData(array $data): array
    {
        $viewData = [];

        foreach ($data as $key => $value) {
            if (! is_string($key)) {
                throw new UnexpectedValueException('Block view data must have string keys.');
            }

            $viewData[$key] = $value;
        }

        return $viewData;
    }
}
