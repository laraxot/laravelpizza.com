<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Filament;

use Modules\Job\Filament\Widgets\JobStatusWidget;

final class JobStatusWidgetProbe extends JobStatusWidget
{
    public string $probeEnvFile = '';

    public function __construct() {}

    protected function envFilePath(): string
    {
        return $this->probeEnvFile;
    }
}
