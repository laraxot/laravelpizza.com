<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Image;

use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager as InterventionImageManager;
use Intervention\Image\Interfaces\ImageInterface;
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
        $manager = new InterventionImageManager(new GdDriver);

        /** @var ImageInterface $image1 */
        $image1 = $manager->read($path1); // @phpstan-ignore method.notFound
        /** @var ImageInterface $image2 */
        $image2 = $manager->read($path2); // @phpstan-ignore method.notFound

        $image1->place($image2, 'center'); // @phpstan-ignore method.notFound

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

        $manager = new InterventionImageManager(new GdDriver);

        /** @var list<ImageInterface> $images */
        $images = [];
        $totalWidth = 0;
        $totalHeight = 0;

        foreach ($absolutePaths as $path) {
            /** @var ImageInterface $img */
            $img = $manager->read($path); // @phpstan-ignore method.notFound
            $images[] = $img;
            $totalWidth = max($totalWidth, $img->width());
            $totalHeight += $img->height();
        }

        /** @var ImageInterface $final */
        $final = $manager->create($totalWidth, $totalHeight); // @phpstan-ignore method.notFound

        $yOffset = 0;
        foreach ($images as $img) {
            $xOffset = (int) (($totalWidth - $img->width()) / 2);
            $final->place($img, 'top-left', $xOffset, $yOffset); // @phpstan-ignore method.notFound
            $yOffset += $img->height();
        }

        $outputPath = public_path($outputFilename);
        File::ensureDirectoryExists(dirname($outputPath));
        $final->save($outputPath);

        return File::exists($outputPath);
    }
}
