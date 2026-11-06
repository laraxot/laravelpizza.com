<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;
use Modules\Lang\Filament\Resources\TranslationFileResource;

final class LangBaseListRecordsStub extends LangBaseListRecords
{
    protected static string $resource = TranslationFileResource::class;
}
