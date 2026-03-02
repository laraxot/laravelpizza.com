<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notify\Models\MailTemplateVersion;

class MailTemplateVersionFactory extends Factory
{
    protected $model = MailTemplateVersion::class;

    public function definition(): array
    {
        return [];
    }
}
