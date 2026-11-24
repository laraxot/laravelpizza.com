<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Subtitle;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Extracts the plain text of a subtitle file and stores it on the given model field.
 */
class UpdateModelSubtitleFieldAction
{
    use QueueableAction;

    public function execute(Model $model, string $filePath, string $fieldName = 'txt'): Model
    {
        $plain = app(ExtractSubtitlePlainTextAction::class)->execute($filePath);

        $model->update([$fieldName => $plain]);

        return $model;
    }
}
