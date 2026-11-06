<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Filament\Tables\Columns\OpeningHoursColumn;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('OpeningHoursColumn — controparte di OpeningHoursField', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $column = OpeningHoursColumn::make();
        Assert::assertSame('opening_hours', $column->getName());
    });

    it('returns an em dash when the state is not an array', function (): void {
        Assert::assertSame('—', OpeningHoursColumn::summarizeOpeningHours(null));
        Assert::assertSame('—', OpeningHoursColumn::summarizeOpeningHours('not-an-array'));
    });

    it('marks a day with no slots as closed', function (): void {
        $summary = OpeningHoursColumn::summarizeOpeningHours([
            'monday' => ['morning_from' => '', 'morning_to' => '', 'afternoon_from' => null, 'afternoon_to' => null],
        ]);

        Assert::assertStringContainsString('Mon chiuso', $summary);
    });

    it('formats a day with both morning and afternoon slots', function (): void {
        $summary = OpeningHoursColumn::summarizeOpeningHours([
            'monday' => [
                'morning_from' => '09:00',
                'morning_to' => '13:00',
                'afternoon_from' => '14:00',
                'afternoon_to' => '18:00',
            ],
        ]);

        Assert::assertStringContainsString('09:00-13:00', $summary);
        Assert::assertStringContainsString('14:00-18:00', $summary);
    });

    it('joins multiple days with a middle dot separator', function (): void {
        $summary = OpeningHoursColumn::summarizeOpeningHours([
            'monday' => ['morning_from' => '09:00', 'morning_to' => '13:00', 'afternoon_from' => null, 'afternoon_to' => null],
            'tuesday' => ['morning_from' => null, 'morning_to' => null, 'afternoon_from' => null, 'afternoon_to' => null],
        ]);

        Assert::assertStringContainsString(' · ', $summary);
    });

    it('covers all six configured weekdays in the summary', function (): void {
        $summary = OpeningHoursColumn::summarizeOpeningHours([]);

        Assert::assertSame(6, substr_count($summary, 'chiuso'));
    });
});
