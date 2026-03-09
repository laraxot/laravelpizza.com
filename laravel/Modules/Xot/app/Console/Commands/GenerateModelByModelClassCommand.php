<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Actions\Generate\GenerateModelByModelClass;
use Webmozart\Assert\Assert;

class GenerateModelByModelClassCommand extends Command
{
    protected $signature = 'xot:generate-model {model_class}';
    protected $description = 'generate a model from model_class';

    public function handle(): void
    {
        $model_class = (string) $this->argument('model_class');
        Assert::classExists($model_class);

        app(GenerateModelByModelClass::class)
            ->setCustomReplaces(['DummyTable' => 'lime_survey_xxx'])
            ->execute($model_class);
    }
}
