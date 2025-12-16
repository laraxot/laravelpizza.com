<?php

declare(strict_types=1);

namespace Modules\Xot\Datas\Transformers;

use Modules\Xot\Actions\File\AssetAction;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

/**
 * AssetTransformer - Trasforma riferimenti di file in percorsi completi per le risorse
 *
 * Formato input: "module::path/file.ext" o "file.ext"
 * Output: "/modules/module/resources/path/file.ext" o "/resources/path/file.ext"
 */
class AssetTransformer implements Transformer
{
    /**
     * Trasforma un riferimento di file in un percorso completo
     *
     * @param  DataProperty  $_property  La proprietà di dati (non utilizzata)
     * @param  mixed  $value  Il valore da trasformare (es. "user::image.png")
     * @param  TransformationContext  $_context  Il contesto di trasformazione (non utilizzato)
     * @return string Il percorso completo (es. "/modules/user/resources/image.png")
     */
    public function transform(DataProperty $_property, mixed $value, TransformationContext $_context): string
    {
        if (! is_string($value) || empty($value)) {
            return '';
        }

        return app(AssetAction::class)->execute($value);
    }
}
