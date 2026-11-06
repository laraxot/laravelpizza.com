<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Config;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Spatie\QueueableAction\QueueableAction;

/**
 * Da una classe qualsiasi di un modulo (modello, Resource, pagina) alla sua `{Modulo}ConfigData`,
 * gia' letta dal file del tenant. `null` se il modulo non ne ha una.
 *
 * Serve ai componenti condivisi (filtri anno di Ptv, ...) che non sanno in quale modulo girano:
 * chiedono al modello della tabella e leggono la configurazione di quel modulo.
 */
class ResolveModuleConfigDataAction
{
    use QueueableAction;

    public function execute(string $class): ?Data
    {
        $dataClass = static::dataClassFor($class);
        if ($dataClass === null || ! method_exists($dataClass, 'make')) {
            return null;
        }

        $data = $dataClass::make();

        return $data instanceof Data ? $data : null;
    }

    /**
     * `Modules\Progressioni\Models\Scheda` => `Modules\Progressioni\Datas\ProgressioniConfigData`.
     *
     * @return class-string<Data>|null
     */
    public static function dataClassFor(string $class): ?string
    {
        // Primo segmento dopo `Modules\`: Str::between taglierebbe all'ultimo separatore.
        $class = ltrim($class, '\\');
        if (! str_starts_with($class, 'Modules\\')) {
            return null;
        }

        $module = Str::before(Str::after($class, 'Modules\\'), '\\');
        if ($module === '' || $module === $class) {
            return null;
        }

        $dataClass = 'Modules\\'.$module.'\\Datas\\'.$module.'ConfigData';
        if (! class_exists($dataClass) || ! is_subclass_of($dataClass, Data::class)) {
            return null;
        }

        return $dataClass;
    }
}
