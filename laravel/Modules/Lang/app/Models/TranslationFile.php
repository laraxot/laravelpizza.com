<?php

declare(strict_types=1);
/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Models/Translation.php
 */

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Modules\Lang\Database\Factories\TranslationFileFactory;
use Modules\Lang\Models\Traits\TranslationFileRowLoader;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property string|null $key
 * @property string|null $path
 * @property string|null $id
 * @property string|null $name
 * @property array<array-key, mixed>|null $content
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static TranslationFileFactory factory($count = null, $state = [])
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
 * @mixin Model
 */
class TranslationFile extends BaseModel
{
    use Sushi;
    use TranslationFileRowLoader;

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
        if ($this->isRunningIdeHelper()) {
            return [];
        }

        try {
            return $this->loadTranslationDataWithErrorHandling();
        } catch (\Throwable $e) {
            Log::warning('TranslationFile::getRows failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return [];
        }
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
