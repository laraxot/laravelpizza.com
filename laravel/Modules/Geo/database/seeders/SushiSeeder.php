<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Safe\json_decode;

class SushiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/content/comuni.json');

        if (! File::exists($path)) {
            $this->command->error('File comuni.json non trovato');

            return;
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Errore nel parsing del file JSON: '.json_last_error_msg());

            return;
        }

        DB::table('comuni')->truncate();

        // Esempio di come implementare il seeding con type safety se necessario:
        if (is_array($data)) {
            foreach ($data as $comune) {
                /** @var array<string, mixed> $validComune */
                $validComune = (array) $comune;
                if (is_array($comune) && $this->isValidComuneData($validComune)) {
                    DB::table('comuni')->insert([
                        'id' => $validComune['id'],
                        'regione' => $validComune['regione'],
                        'provincia' => $validComune['provincia'],
                        'comune' => $validComune['comune'],
                        'cap' => $validComune['cap'],
                        'lat' => $validComune['lat'],
                        'lng' => $validComune['lng'],
                        'created_at' => $validComune['created_at'] ?? now(),
                        'updated_at' => $validComune['updated_at'] ?? now(),
                    ]);
                }
            }
        }

        $this->command->info('Database Sushi popolato con successo');
    }

    /**
     * Valida la struttura dati di un comune.
     *
     * @param  array<string, mixed>  $comune
     */
    private function isValidComuneData(array $comune): bool
    {
        $requiredFields = ['id', 'regione', 'provincia', 'comune', 'cap', 'lat', 'lng'];

        foreach ($requiredFields as $field) {
            if (! isset($comune[$field])) {
                return false;
            }
        }

        return true;
    }
}
