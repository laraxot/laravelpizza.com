<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Pages;

use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateTranslationFile extends XotBaseCreateRecord
{
    protected static string $resource = TranslationFileResource::class;
}
