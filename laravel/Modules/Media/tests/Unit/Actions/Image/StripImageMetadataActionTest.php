<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Actions\Image\StripImageMetadataAction;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_put_contents;
use function Safe\imagecolorat;
use function Safe\imagecreatetruecolor;
use function Safe\imagecreatefromstring;
use function Safe\imagefill;
use function Safe\imagefilledrectangle;
use function Safe\imagejpeg;
use function Safe\imagepng;
use function Safe\ob_get_clean;
use function Safe\ob_start;
use function Safe\tempnam;
use function Safe\unlink;

uses(TestCase::class)->group('media-db');

/**
 * Privacy: la foto allegata a una segnalazione non deve portare con se' posizione GPS, camera o testo nascosto. Le fixture sono file veri
 * costruiti byte per byte (Exif little-endian con Orientation=6 e GPS IFD; PNG con chunk tEXt), e ogni test verifica PRIMA che il dato
 * da togliere ci sia davvero: senza quel controllo "GPS assente" sarebbe vero anche per un file che non l'ha mai avuto.
 */

/** @var list<string> $stripActionTempFiles */
$GLOBALS['stripActionTempFiles'] = [];

afterEach(function (): void {
    /** @var list<string> $tempFiles */
    $tempFiles = $GLOBALS['stripActionTempFiles'];
    foreach ($tempFiles as $path) {
        if (is_file($path)) {
            unlink($path);
        }
    }
    $GLOBALS['stripActionTempFiles'] = [];
});

/** JPEG 64x48 con un quadrato rosso 20x20 in alto a sinistra su fondo blu: la rotazione si vede dal pixel. */
function stripActionPlainJpeg(): string
{
    $image = imagecreatetruecolor(64, 48);
    imagefill($image, 0, 0, (int) imagecolorallocate($image, 0, 0, 255));
    imagefilledrectangle($image, 0, 0, 19, 19, (int) imagecolorallocate($image, 255, 0, 0));
    ob_start();
    imagejpeg($image, null, 95);

    return (string) ob_get_clean();
}

/** Stesso JPEG con APP1 Exif reale subito dopo SOI: Orientation=6 (ruota di 90 gradi in senso orario), GPS 45 27'51" N, 9 11'24" E. */
function stripActionGpsJpeg(): string
{
    $rationals = static fn (array $parts): string => implode('', array_map(static fn (int $part): string => pack('VV', $part, 1), $parts));
    $tiff = 'II'.pack('vV', 42, 8)
        .pack('v', 2).pack('vvVv', 0x0112, 3, 1, 6).pack('v', 0).pack('vvVV', 0x8825, 4, 1, 38).pack('V', 0)
        .pack('v', 4).pack('vvV', 1, 2, 2)."N\0\0\0".pack('vvVV', 2, 5, 3, 92)
        .pack('vvV', 3, 2, 2)."E\0\0\0".pack('vvVV', 4, 5, 3, 116).pack('V', 0)
        .$rationals([45, 27, 51]).$rationals([9, 11, 24]);
    $app1 = "\xFF\xE1".pack('n', 2 + 6 + strlen($tiff))."Exif\0\0".$tiff;
    $jpeg = stripActionPlainJpeg();

    return substr($jpeg, 0, 2).$app1.substr($jpeg, 2);
}

/** @return array{GPS?: array{GPSLatitude?: list<string>}, IFD0?: array{Orientation?: int}}|false */
function stripActionExif(string $bytes): array|false
{
    $path = tempnam(sys_get_temp_dir(), 'exif');
    file_put_contents($path, $bytes);
    /** @var list<string> $tempFiles */
    $tempFiles = $GLOBALS['stripActionTempFiles'];
    $tempFiles[] = $path;
    $GLOBALS['stripActionTempFiles'] = $tempFiles;

    $data = @exif_read_data($path, null, true);
    if ($data === false) {
        return false;
    }

    $result = [];
    if (isset($data['GPS']) && is_array($data['GPS'])) {
        $gps = [];
        if (isset($data['GPS']['GPSLatitude']) && is_array($data['GPS']['GPSLatitude'])) {
            $latitude = [];
            foreach ($data['GPS']['GPSLatitude'] as $value) {
                if (is_string($value)) {
                    $latitude[] = $value;
                }
            }
            if (count($latitude) === count($data['GPS']['GPSLatitude'])) {
                $gps['GPSLatitude'] = $latitude;
            }
        }
        $result['GPS'] = $gps;
    }
    if (isset($data['IFD0']) && is_array($data['IFD0']) && is_int($data['IFD0']['Orientation'] ?? null)) {
        $result['IFD0'] = ['Orientation' => $data['IFD0']['Orientation']];
    }

    return $result;
}

/** PNG 32x32 con un chunk tEXt (e uno iTXt) subito dopo IHDR, CRC corretti. */
function stripActionPngWithText(): string
{
    $image = imagecreatetruecolor(32, 32);
    imagefill($image, 0, 0, (int) imagecolorallocate($image, 10, 120, 200));
    ob_start();
    imagepng($image);
    $png = (string) ob_get_clean();

    $chunk = static fn (string $type, string $data): string => pack('N', strlen($data)).$type.$data.pack('N', crc32($type.$data));
    $text = $chunk('tEXt', "Comment\0posizione segreta 45.4642 9.1900").$chunk('iTXt', "XML:com.adobe.xmp\0\0\0\0\0<x:xmpmeta>segreto-xmp</x:xmpmeta>");
    $afterIhdr = 8 + 25;

    return substr($png, 0, $afterIhdr).$text.substr($png, $afterIhdr);
}

function stripActionMedia(string $bytes, string $fileName, ?string $mimeType): Media
{
    Storage::fake('public');

    $media = new Media;
    $media->forceFill([
        'model_type' => 'strip-action-test',
        'model_id' => '1',
        'uuid' => (string) Str::uuid(),
        'collection_name' => 'attachments',
        'name' => pathinfo($fileName, PATHINFO_FILENAME),
        'file_name' => $fileName,
        'mime_type' => $mimeType,
        'disk' => 'public',
        'size' => strlen($bytes),
        'manipulations' => [],
        'custom_properties' => [],
        'generated_conversions' => [],
        'responsive_images' => [],
        'order_column' => 1,
    ])->save();

    Storage::disk('public')->put($media->getPathRelativeToRoot(), $bytes);

    return $media;
}

it('removes GPS and Exif from a JPEG, applies its orientation and updates the stored size', function (): void {
    $original = stripActionGpsJpeg();

    // precondizione: senza questo il test sarebbe vuoto
    $before = stripActionExif($original);
    Assert::assertIsArray($before);
    Assert::assertSame(['45/1', '27/1', '51/1'], $before['GPS']['GPSLatitude'] ?? null, 'La fixture non ha il GPS.');
    Assert::assertSame(6, $before['IFD0']['Orientation'] ?? null, 'La fixture non ha Orientation=6.');
    Assert::assertSame([64, 48], array_slice((array) getimagesizefromstring($original), 0, 2));

    $media = stripActionMedia($original, 'foto.jpg', 'image/jpeg');
    $path = $media->getPathRelativeToRoot();

    (new StripImageMetadataAction)->execute($media);

    $clean = (string) Storage::disk('public')->get($path);
    $after = stripActionExif($clean);
    Assert::assertTrue($after === false || ! isset($after['GPS']), 'Il GPS e\' ancora nel file.');
    Assert::assertTrue($after === false || ! isset($after['IFD0']['Orientation']), 'L\'Exif e\' ancora nel file.');
    Assert::assertStringNotContainsString("Exif\0\0", $clean);

    // Orientation=6: larghezza e altezza scambiate, e il quadrato rosso (in alto a sinistra) finisce in alto a destra
    Assert::assertSame([48, 64], array_slice((array) getimagesizefromstring($clean), 0, 2));
    $decoded = imagecreatefromstring($clean);
    $topRight = imagecolorat($decoded, 44, 3);
    Assert::assertGreaterThan(180, ($topRight >> 16) & 0xFF, 'Il quadrato rosso non e\' in alto a destra: orientamento non applicato.');
    Assert::assertLessThan(80, $topRight & 0xFF);

    Assert::assertNotSame(strlen($original), strlen($clean));
    $media->refresh();
    Assert::assertSame(strlen($clean), (int) $media->size, 'La colonna size non e\' stata aggiornata.');
    Assert::assertSame('image/jpeg', $media->mime_type);
});

it('removes text and XMP chunks from a PNG and keeps the picture', function (): void {
    $original = stripActionPngWithText();
    Assert::assertStringContainsString('tEXt', $original);
    Assert::assertStringContainsString('posizione segreta', $original);
    Assert::assertStringContainsString('segreto-xmp', $original);
    Assert::assertSame([32, 32], array_slice((array) getimagesizefromstring($original), 0, 2), 'Il PNG di partenza non e\' valido.');

    $media = stripActionMedia($original, 'foto.png', 'image/png');

    (new StripImageMetadataAction)->execute($media);

    $clean = (string) Storage::disk('public')->get($media->getPathRelativeToRoot());
    Assert::assertStringStartsWith("\x89PNG\r\n\x1a\n", $clean);
    Assert::assertStringNotContainsString('tEXt', $clean);
    Assert::assertStringNotContainsString('iTXt', $clean);
    Assert::assertStringNotContainsString('posizione segreta', $clean);
    Assert::assertStringNotContainsString('segreto-xmp', $clean);
    Assert::assertSame([32, 32], array_slice((array) getimagesizefromstring($clean), 0, 2));
    $media->refresh();
    Assert::assertSame(strlen($clean), (int) $media->size);
});

it('leaves a PDF byte for byte identical and does not touch the record', function (): void {
    $pdf = "%PDF-1.4\n1 0 obj<</Type/Catalog>>endobj\n%\xE2\xE3\xCF\xD3\ntrailer<</Root 1 0 R>>\n%%EOF\n";
    $media = stripActionMedia($pdf, 'modulo.pdf', 'application/pdf');
    $size = (int) $media->size;

    (new StripImageMetadataAction)->execute($media);

    Assert::assertSame($pdf, Storage::disk('public')->get($media->getPathRelativeToRoot()));
    $media->refresh();
    Assert::assertSame($size, (int) $media->size);
});

it('control: the same GPS JPEG recorded with another mime type keeps its GPS (the action goes by the record, and the GPS check can fail)', function (): void {
    $original = stripActionGpsJpeg();
    $media = stripActionMedia($original, 'foto.bin', 'application/octet-stream');

    (new StripImageMetadataAction)->execute($media);

    $kept = (string) Storage::disk('public')->get($media->getPathRelativeToRoot());
    Assert::assertSame($original, $kept);
    $exif = stripActionExif($kept);
    Assert::assertIsArray($exif);
    Assert::assertArrayHasKey('GPS', $exif, 'Il controllo "GPS assente" non puo\' mai fallire: exif_read_data non vede il GPS nemmeno dove c\'e\'.');
});
