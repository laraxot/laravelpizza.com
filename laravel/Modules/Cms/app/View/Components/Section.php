<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Actions\View\GetCmsViewAction;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Section as SectionModel;
use Spatie\LaravelData\DataCollection;

/**
 * Section Component.
 *
 * Renders a reusable section of the site using the Section model.
 *
 * @property string      $slug The unique identifier for the section
 * @property string|null $view Custom view path for rendering
 * @property array       $data Additional data to pass to the view
 */
class Section extends Component
{
    public string $slug;

    /** @var DataCollection<BlockData> */
    public DataCollection $blocks;

    public ?string $name = null;

    public ?string $class = null;

    public ?string $id = null;

    public ?string $tpl = null;

    /**
     * Create a new component instance.
     *
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
        $this->tpl = $tpl;
        $this->blocks = SectionModel::getBlocksBySlug($this->slug);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewContract
    {
        $baseViewName = 'pub_theme::components.sections.'.$this->slug;
        if ($this->tpl) {
            $baseViewName .= '.'.$this->tpl;
        }

        $viewAction = app(GetCmsViewAction::class);

        try {
            // The action's execute method returns view-string, so PHPStan should be happy
            $view = $viewAction->execute($baseViewName);

            return view($view);
        } catch (\Exception $e) {
            // Fallback: this view exists in the Cms module
            // The action's execute method returns view-string
            $fallbackView = $viewAction->execute('cms::components.section');

            return view($fallbackView);
        }
    }
}
