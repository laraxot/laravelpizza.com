<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions\Subtitle;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Actions\Subtitle\ExtractSubtitlePlainTextAction;
use Modules\Media\Actions\Subtitle\UpdateModelSubtitleFieldAction;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Testo semplice dei sottotitoli XML (sostituisce i test del vecchio SubtitleService).
 * Legge la fixture dal disco, nessun database: il model registra l'update.
 */

uses(TestCase::class)->group('no-media-db');

test('plain text joins every item of the subtitle file', function (): void {
    $plain = (new ExtractSubtitlePlainTextAction)->execute(
        dirname(__DIR__, 3).'/Fixtures/subtitle.xml',
    );

    Assert::assertSame('Buongiorno a tutti Arrivederci ', $plain);
});

test('the plain text is stored on the requested model field', function (): void {
    $model = new class extends Model
    {
        /** @var array<string, mixed> */
        public array $updated = [];

        /**
         * @param  array<string, mixed>  $attributes
         * @param  array<string, mixed>  $options
         */
        public function update(array $attributes = [], array $options = []): bool
        {
            $this->updated = $attributes;

            return true;
        }
    };

    $returned = (new UpdateModelSubtitleFieldAction)->execute(
        $model,
        dirname(__DIR__, 3).'/Fixtures/subtitle.xml',
        'transcript',
    );

    Assert::assertSame($model, $returned);
    Assert::assertSame(['transcript' => 'Buongiorno a tutti Arrivederci '], $model->updated);
});
