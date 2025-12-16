<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Image;

use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager as InterventionImageManager;
use Spatie\QueueableAction\QueueableAction;

class Merge
{
    use QueueableAction;

    /**
     * Unisce due immagini in una sola.
     *
     * @param  string  $path1  Percorso assoluto della prima immagine
     * @param  string  $path2  Percorso assoluto della seconda immagine
     * @param  string  $outputPath  Percorso assoluto di salvataggio
     */
    public function handle(string $path1, string $path2, string $outputPath): bool
    {
        // Intervention Image v3: il costruttore richiede un DriverInterface
        $manager = new InterventionImageManager(new GdDriver);

        // Carica le immagini
        $image1 = $manager->read($path1);
        $image2 = $manager->read($path2);

        // Inserisce image2 sopra image1 (centrato) - v3 usa place()
        $image1->place($image2, 'center');

        // Salva il risultato
        File::ensureDirectoryExists(dirname($outputPath));
        $image1->save($outputPath);

        return File::exists($outputPath);
    }

    /**
     * Unisce array di immagini verticalmente.
     *
     * Questo metodo unisce tutte le immagini in $filenames verticalmente
     * in un'unica immagine, mantenendo la larghezza massima e sommando le altezze.
     *
     * @param  array<int, string>  $filenames  Array di percorsi relativi (es: 'chart/123-0.png')
     * @param  string  $outputFilename  Nome file output relativo (es: 'chart/123.png')
     * @return bool Successo operazione
     */
    public function execute(array $filenames, string $outputFilename): bool
    {
        if (empty($filenames)) {
            return false;
        }

        // Se c'è solo un'immagine, copiala
        if (count($filenames) === 1) {
            $sourcePath = public_path($filenames[0]);
            $outputPath = public_path($outputFilename);
            if (!File::exists($sourcePath)) {
                return false;
            }
            File::ensureDirectoryExists(dirname($outputPath));
            File::copy($sourcePath, $outputPath);
            return File::exists($outputPath);
        }

        // Converti percorsi relativi in assoluti
        $absolutePaths = array_map(static function (string $filename): string {
            return public_path($filename);
        }, $filenames);

        // Verifica che tutte le immagini esistano
        foreach ($absolutePaths as $path) {
            if (!File::exists($path)) {
                logger()->error('Immagine non trovata per merge', ['path' => $path]);

                return false;
            }
        }

        // Intervention Image v3
        $manager = new InterventionImageManager(new GdDriver);

        // Carica tutte le immagini e calcola dimensioni totali
        $images = [];
        $totalWidth = 0;
        $totalHeight = 0;

        foreach ($absolutePaths as $path) {
            $img = $manager->read($path);
            $images[] = $img;
            $totalWidth = max($totalWidth, $img->width());
            $totalHeight += $img->height();
        }

        // Crea canvas finale con dimensioni calcolate
        $final = $manager->create($totalWidth, $totalHeight);

        // Posiziona ogni immagine verticalmente, centrata orizzontalmente
        $yOffset = 0;
        foreach ($images as $img) {
            // Calcola offset X per centrare orizzontalmente
            $xOffset = (int) (($totalWidth - $img->width()) / 2);
            // Posiziona immagine
            $final->place($img, 'top-left', $xOffset, $yOffset);
            // Incrementa offset Y per prossima immagine
            $yOffset += $img->height();
        }

        // Salva risultato
        $outputPath = public_path($outputFilename);
        File::ensureDirectoryExists(dirname($outputPath));
        $final->save($outputPath);

        return File::exists($outputPath);
    }
}
