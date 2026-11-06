<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\View;

use Illuminate\Support\Str;
use Modules\Xot\Actions\Module\GetModuleNameByModelClassAction;
use Spatie\QueueableAction\QueueableAction;

class GetViewByModelClassAction
{
    use QueueableAction;

    /**
     * ---.
     */
    /**
     * `{modulo}::{modello_snake}{suffisso}`, es. `progressioni::scheda.index.pdf`.
     *
     * Se il modulo del modello non ha la vista, la cerca nei moduli delle classi antenate con lo
     * stesso nome di modello: una foglia (Progressioni\Models\Scheda) eredita le viste della
     * piattaforma (Ptv\Models\BaseScheda => `ptv::scheda.index.pdf`) finche' non le
     * personalizza. Prima: eccezione, e ogni modulo doveva copiare il template.
     *
     * @see Modules/Xot/docs/stories/view-by-model-platform-fallback.story.md
     */
    public function execute(string $model_class, string $suffix): string
    {
        $model_name = Str::of(class_basename($model_class))->snake()->toString();

        $tried = [];
        foreach ($this->getModuleNames($model_class) as $module) {
            $view = Str::lower($module).'::'.$model_name.$suffix;
            if (in_array($view, $tried, true)) {
                continue;
            }

            $tried[] = $view;
            if (view()->exists($view)) {
                return $view;
            }
        }

        throw new \Exception('view ['.implode('] / [', $tried).'] not Exists');
    }

    /**
     * Modulo del modello, poi quelli delle classi antenate (solo classi `Modules\...`).
     *
     * @return list<string>
     */
    private function getModuleNames(string $model_class): array
    {
        $modules = [];
        for ($class = $model_class; is_string($class) && $class !== ''; $class = get_parent_class($class)) {
            if (str_starts_with(ltrim($class, '\\'), 'Modules\\')) {
                $modules[] = app(GetModuleNameByModelClassAction::class)->execute($class);
            }
            if (! class_exists($class)) {
                break;
            }
        }

        return array_values(array_unique(array_filter($modules)));
    }
}
