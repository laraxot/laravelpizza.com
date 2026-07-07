<?php

declare(strict_types=1);

namespace Modules\Lang\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Modules\Lang\Models\BaseModelLang;
use Webmozart\Assert\Assert;

/**
 * @implements CastsAttributes<mixed, array<string, mixed>>
 */
class LangField implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        unset($value, $attributes);
        Assert::isInstanceOf($model, BaseModelLang::class);

        return $model->post->{$key};
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     *
     * @return array<string, mixed>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        unset($attributes);
        Assert::isInstanceOf($model, BaseModelLang::class);

        $post = $model->post;
        $post->{$key} = $value;
        $post->save();

        // parent::__construct([]);
        // return [$key => encrypt($value)];
        // return ['created_by' => 'xot'];
        return []; // tolgo l'aggiornamento di questo campo
    }
}
