<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Enums;

use Illuminate\Support\Facades\Lang;
use Modules\Media\Enums\AttachmentTypeEnum;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Enum dei tipi di allegato. Le etichette passano dal traduttore, non dal database.
 */

uses(TestCase::class)->group('no-media-db');

test('the enum covers the four attachment types', function (): void {
    Assert::assertSame(
        ['image', 'video', 'document', 'manual'],
        array_map(static fn (AttachmentTypeEnum $case): string => $case->value, AttachmentTypeEnum::cases()),
    );
});

test('the enum satisfies the filament label contract', function (): void {
    Assert::assertNotEmpty(AttachmentTypeEnum::IMAGE->getLabel());
});

test('each case has a label built from its own value', function (): void {
    foreach (AttachmentTypeEnum::cases() as $case) {
        $label = $case->getLabel();

        Assert::assertNotSame('', $label);
        // senza traduzione registrata Lang restituisce la chiave: in entrambi i casi
        // l'etichetta deve derivare dal value del case, non essere hardcoded altrove.
        Assert::assertTrue(
            $label === trans('media::attachments.types.'.$case->value),
            "etichetta incoerente per {$case->value}",
        );
    }
});

test('a type note is returned only when the translation exists', function (): void {
    foreach (AttachmentTypeEnum::cases() as $case) {
        $key = 'media::attachments.type_notes.'.$case->value;
        $note = $case->getTypeNote();

        if (Lang::has($key)) {
            Assert::assertSame(trans($key), $note);
        } else {
            Assert::assertNull($note);
        }
    }
});

test('the note map only contains cases that actually have a note', function (): void {
    $descriptions = AttachmentTypeEnum::getTypeNoteDescriptionsByValues();

    foreach (AttachmentTypeEnum::cases() as $case) {
        $hasNote = $case->getTypeNote() !== null;
        Assert::assertSame($hasNote, array_key_exists($case->value, $descriptions));
    }

    foreach ($descriptions as $value => $note) {
        Assert::assertNotNull(AttachmentTypeEnum::tryFrom($value));
        Assert::assertNotSame('', $note);
    }
});
