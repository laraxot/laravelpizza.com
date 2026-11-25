<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Modules\Rating\Filament\Concerns\DecoratesRatingFormFields;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('DecoratesRatingFormFields', function (): void {
    test('applica label al Fieldset e al Field', function (): void {
        $host = new class
        {
            use DecoratesRatingFormFields;

            public function decorate(RatingContract $rating, Component $component): Component
            {
                return $this->applyDefaultRatingFieldDecoration($rating, $component);
            }
        };

        $rating = new Rating;
        $rating->forceFill(['id' => 1, 'title' => 'Ruolo', 'txt' => 'Ruolo <i>x</i>']);

        $fieldset = $host->decorate($rating, Fieldset::make());
        Assert::assertInstanceOf(Fieldset::class, $fieldset);
        Assert::assertSame('Ruolo x', $fieldset->getLabel());

        $select = $host->decorate($rating, Select::make('x'));
        Assert::assertInstanceOf(Select::class, $select);
        Assert::assertSame('Ruolo x', $select->getLabel());
    });
});
