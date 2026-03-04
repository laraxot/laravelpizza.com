<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Enums;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Traits\EnumTrait;

enum TestEnum: string
{
    use EnumTrait;

    case ALPHA = 'alpha';
    case BETA = 'beta';

    public static function getColumnDefinitions(): array
    {
        return [
            'alpha' => fn (Blueprint $table) => $table->string('alpha')->nullable(),
            'beta' => fn (Blueprint $table) => $table->string('beta')->nullable(),
        ];
    }
}
