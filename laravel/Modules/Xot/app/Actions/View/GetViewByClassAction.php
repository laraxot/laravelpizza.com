<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per la conversione di nomi di classi in nomi di viste.
 */
class GetViewByClassAction
{
    use QueueableAction;

    /**
     * Converte un nome di classe in un nome di vista.
     * Esempio: "Modules\UI\Filament\Widgets\GroupWidget" => "ui::filament.widgets.group".
     *
     * @param  string  $class  Il nome della classe da convertire
     * @param  string  $suffix  Suffisso opzionale da aggiungere al nome della vista
     * @return string Il nome della vista
     *
     * @throws \Exception Se la vista non esiste
     */
    public function execute(string $class, string $suffix = ''): string
    {
        $module = Str::of($class)->betweenFirst('Modules\\', '\\')->toString();
        $module_low = Str::of($module)->lower()->toString();
        $after = Str::of($class)
            ->after('Modules\\'.$module.'\\')
            ->explode('\\')
            ->toArray();

        $mapped = Arr::map($after, function (string $value, int $key) use ($after) {
            if ($key > 0 && isset($after[$key - 1])) {
                $prevValue = $after[$key - 1];
                $prevValueStr = is_string($prevValue) ? $prevValue : (string) $prevValue;

                $value = $this->checkPrev($value, $prevValueStr);
            }
            if ($key > 0 && isset($after[$key - 2])) {
                $prevValue = $after[$key - 2];
                $prevValueStr = is_string($prevValue) ? $prevValue : (string) $prevValue;

                $value = $this->checkPrev($value, $prevValueStr);
            }

            return Str::of($value)->slug()->toString();
        });

        $implode = implode('.', $mapped);
        $views = [
            'pub_theme::'.$implode.$suffix,
            $module_low.'::'.$implode.$suffix,
        ];
        $view = Arr::first($views, view()->exists(...));
        if ($view === null) {
            throw new \Exception('View not found: '.implode(', ', $views));
        }

        if (view()->exists($view)) {
            return $view;
        }
        throw new \Exception('View not found: '.$view);
    }

    public function checkPrev(string $value, string $prevValue): string
    {
        $singular = Str::of($prevValue)->singular()->toString();

        if (Str::endsWith($value, $singular)) {
            $value = Str::of($value)->beforeLast($singular)->toString();
        }

        return $value;
    }
}
