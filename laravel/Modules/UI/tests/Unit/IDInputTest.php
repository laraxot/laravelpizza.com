<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Filament\Forms\Components\IDInput;
use Modules\UI\Tests\TestCase;

uses(TestCase::class);

/*
 * La chiave primaria in un form si legge e si copia, non si salva mai: sostituisce
 * TextInput::make('id')->disabled() ripetuto nei form (es. criteri di esclusione).
 */
test('id input is read-only, never saved and copyable', function (): void {
    $input = IDInput::make('id');

    expect($input->isDisabled())->toBeTrue()
        ->and($input->isDehydrated())->toBeFalse()
        ->and($input->isCopyable())->toBeTrue()
        ->and($input->getPrefixIcon())->toBe('heroicon-o-hashtag');
});
