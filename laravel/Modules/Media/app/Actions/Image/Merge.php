<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Image;

use Illuminate\Support\Facades\File;
use Intervention\Image\Alignment;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager as InterventionImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Spatie\QueueableAction\QueueableAction;

/**
 * Unisce immagini (merge verticale / watermark-like overlay) via Intervention Image v4 + GD.
 *
 * Perché: chart e conversioni generano più PNG da accorpare in un unico asset pubblico;
 * Intervention v4 espone ImageManager tipizzato (decodePath/createImage/insert/save) senza
 * facade legacy v2.
 * @see docs/contracts/merge.md
 * @contract docs/contracts/merge.md
 */
class Merge
{
    use QueueableAction;

    /**
     * Unisce verticalmente due immagini in una sola (larghezza = max, altezza = somma).
     *
     * @param  string  $path1  Percorso assoluto della prima immagine
     * @param  string  $path2  Percorso assoluto della seconda immagine
     * @param  string  $outputPath  Percorso assoluto di salvataggio
     */
    public function handle(string $path1, string $path2, string $outputPath): bool
    {
        $manager = $this->manager();

        $image1 = $manager->decodePath($path1);
        $image2 = $manager->decodePath($path2);

        $width = max($image1->width(), $image2->width());
        $height = $image1->height() + $image2->height();

        $canvas = $manager->createImage($width, $height);
        $canvas->insert($image1, 0, 0, Alignment::TOP_LEFT);
        $canvas->insert($image2, 0, $image1->height(), Alignment::TOP_LEFT);

        File::ensureDirectoryExists(dirname($outputPath));
        $canvas->save($outputPath);

        return File::exists($outputPath);
    }

    /**
     * Unisce array di immagini verticalmente.
     *
     * Questo metodo unisce tutte le immagini in $filenames verticalmente
     * in un'unica immagine, mantenendo la larghezza massima e sommando le altezze.
     *
     * @param  list<string>  $filenames  Array di percorsi relativi (es: 'chart/123-0.png')
     * @param  string  $outputFilename  Nome file output relativo (es: 'chart/123.png')
     * @return bool Successo operazione
     */
    public function execute(array $filenames, string $outputFilename): bool
    {
        if ($filenames === []) {
            return false;
        }

        if (count($filenames) === 1) {
            $sourcePath = public_path($filenames[0]);
            $outputPath = public_path($outputFilename);
            if (! File::exists($sourcePath)) {
                return false;
            }
            File::ensureDirectoryExists(dirname($outputPath));
            File::copy($sourcePath, $outputPath);

            return File::exists($outputPath);
        }

        $absolutePaths = array_map(static function (string $filename): string {
            return public_path($filename);
        }, $filenames);

        foreach ($absolutePaths as $path) {
            if (! File::exists($path)) {
                logger()->error('Immagine non trovata per merge', ['path' => $path]);

                return false;
            }
        }

        $manager = $this->manager();

        /** @var list<ImageInterface> $images */
        $images = [];
        $totalWidth = 0;
        $totalHeight = 0;

        foreach ($absolutePaths as $path) {
            $img = $manager->decodePath($path);
            $images[] = $img;
            $totalWidth = max($totalWidth, $img->width());
            $totalHeight += $img->height();
        }

        $final = $manager->createImage($totalWidth, $totalHeight);

        $yOffset = 0;
        foreach ($images as $img) {
            $xOffset = (int) (($totalWidth - $img->width()) / 2);
            $final->insert($img, $xOffset, $yOffset, Alignment::TOP_LEFT);
            $yOffset += $img->height();
        }

        $outputPath = public_path($outputFilename);
        File::ensureDirectoryExists(dirname($outputPath));
        $final->save($outputPath);

        return File::exists($outputPath);
    }

    private function manager(): InterventionImageManager
    {
        return new InterventionImageManager(new GdDriver);
    }
}
