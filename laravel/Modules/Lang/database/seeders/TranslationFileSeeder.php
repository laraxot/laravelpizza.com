<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lang\Models\TranslationFile;

/**
 * TranslationFile è Sushi (GetAllTranslationAction) — seeder scalda l'indice file lang.
 */
class TranslationFileSeeder extends Seeder
{
    public function run(): void
    {
        $count = TranslationFile::query()->count();

        if ($this->command !== null) {
            $this->command->info("TranslationFileSeeder: {$count} file lang indicizzati via Sushi.");
        }
    }
}
