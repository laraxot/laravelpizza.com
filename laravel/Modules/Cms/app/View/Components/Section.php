<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Section as SectionModel;
use Spatie\LaravelData\DataCollection;

/**
 * Section Component.
 *
 * Renders a reusable section of the site using the Section model.
 *
 * @property string $slug The unique identifier for the section
 */
class Section extends Component
{
    public string $slug;

    /** @var DataCollection<int, BlockData>|array<int|string, mixed> */
    public DataCollection|array $blocks;

    public ?string $name = null;

    public ?string $class = null;

    public ?string $id = null;

    public string $tpl = 'v1';

    /**
     * @param string      $slug  Unique identifier for the section
     * @param string|null $class Additional CSS classes
     * @param string|null $id    Custom ID for the section
     */
    public function __construct(
        string $slug,
        ?string $class = null,
        ?string $id = null,
        ?string $tpl = null,
    ) {
        $this->slug = $slug;
        $this->class = $class;
        $this->id = $id;
        if (is_string($tpl) && '' !== $tpl) {
            $this->tpl = $tpl;
        }

        $this->blocks = SectionModel::getBlocksBySlug($this->slug);
    }

    public function render(): ViewContract
    {
        $view = 'pub_theme::components.sections.'.$this->slug.'.'.$this->tpl;
        $viewParams = [
            'blocks' => $this->blocks,
            'section' => $this,
        ];

        /** @var ViewFactory $viewFactory */
        $viewFactory = app('view');

        return $viewFactory->make($view, $viewParams);
    }
}
