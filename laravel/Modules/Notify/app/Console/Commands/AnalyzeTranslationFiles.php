<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\Table;
use Webmozart\Assert\Assert;

class AnalyzeTranslationFiles extends Command
{
    protected $signature = 'notify:analyze-translations';
    protected $description = 'Analyze translation files in the Notify module';

    public function handle(): int
    {
        $this->info('Analyzing translation files in the Notify module...');
        $langPath = module_path('Notify', 'lang');
        if (! File::exists($langPath)) {
            $this->error('Lang path not found');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
}
