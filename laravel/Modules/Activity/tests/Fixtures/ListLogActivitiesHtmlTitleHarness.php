<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Contracts\Support\Htmlable;

final class ListLogActivitiesHtmlTitleHarness extends ListLogActivitiesPageHarness
{
    public function getRecordTitle(): Htmlable
    {
<<<<<<< .merge_file_NVk67z
        return new HtmlableRecordTitle();
=======
        return new HtmlableRecordTitle;
>>>>>>> .merge_file_7FuUFS
    }
}
