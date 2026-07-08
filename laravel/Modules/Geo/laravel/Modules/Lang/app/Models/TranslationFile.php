<?php

declare(strict_types=1);

/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Models/Translation.php
 */

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Database\Factories\TranslationFileFactory;
use Modules\Xot\Contracts\ProfileContract;

use function Safe\json_encode;

use Sushi\Sushi;

/**
 * @property string|null                  $key
 * @property string|null                  $path
 * @property string|null                  $id
 * @property string|null                  $name
 * @property array<array-key, mixed>|null $content
 * @property ProfileContract|null         $creator
 * @property ProfileContract|null         $updater
 *
 * @method static TranslationFileFactory          factory($count = null, $state = [])
 * @method static Builder<static>|TranslationFile newModelQuery()
 * @method static Builder<static>|TranslationFile newQuery()
 * @method static Builder<static>|TranslationFile query()
 * @method static Builder<static>|TranslationFile whereContent($value)
 * @method static Builder<static>|TranslationFile whereId($value)
 * @method static Builder<static>|TranslationFile whereKey($value)
 * @method static Builder<static>|TranslationFile whereName($value)
 * @method static Builder<static>|TranslationFile wherePath($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class TranslationFile extends BaseModel
{
    use Sushi;

    protected $fillable = [
        'id',
        'name',
        'path',
        'content',
    ];

    /** @var array<string, string> */
    protected array $form = [
        'key' => 'string',
        'path' => 'string',
        'id' => 'string',
        'name' => 'string',
        'content' => 'json',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $files = app(GetAllTranslationAction::class)->execute();

        /** @var array<int, array<string, mixed>> $result */
        $result = Arr::map($files, function ($item) {
            if (! is_array($item)) {
                return [];
            }

            $key = $item['key'] ?? null;
            $keyStr = is_string($key) ? $key : (string) $key;
            $item['id'] = isset($item['key']) ? $keyStr : '';

            $pathValue = $item['path'] ?? null;
            $pathStr = is_string($pathValue) ? $pathValue : (string) $pathValue;
            $item['name'] = isset($item['path']) ? basename($pathStr, '.php') : '';

            if (isset($item['path'])) {
                $path = $pathStr;
                if (File::exists($path)) {
                    try {
                        $content = File::getRequire($path);
                        $item['content'] = json_encode($content);
                    } catch (\Exception $e) {
                        $item['content'] = '';
                    }
                } else {
                    $item['content'] = '';
                }
            } else {
                $item['content'] = '';
            }

            /*
             * // Carica il contenuto del file
             * try {
             * $readAction = app(ReadTranslationFileAction::class);
             * $item['content'] = $readAction->execute($item['path']);
             * } catch (\Exception $e) {
             * $item['content'] = [];
             * }
             */
            // dddx($item);
            return $item;
        });

        return $result;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }
}
