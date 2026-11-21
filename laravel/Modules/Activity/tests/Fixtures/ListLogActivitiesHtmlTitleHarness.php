<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Contracts\Support\Htmlable;

final class ListLogActivitiesHtmlTitleHarness extends ListLogActivitiesPageHarness
{
    public function getRecordTitle(): Htmlable
    {
        return new HtmlableRecordTitle;
    }
}
