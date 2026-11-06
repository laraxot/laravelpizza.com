<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;
use Modules\Lang\Filament\Resources\TranslationFileResource;

final class LangBaseEditRecordStub extends LangBaseEditRecord
{
    protected static string $resource = TranslationFileResource::class;
}
