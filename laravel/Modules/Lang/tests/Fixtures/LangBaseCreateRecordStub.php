<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;
use Modules\Lang\Filament\Resources\TranslationFileResource;

final class LangBaseCreateRecordStub extends LangBaseCreateRecord
{
    protected static string $resource = TranslationFileResource::class;
}
