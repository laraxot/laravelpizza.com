<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

// use Squire\Models\Country;

class ContactSection extends XotBaseSection
{
    // protected string $view = 'filament-forms::components.group';

    protected bool $disableLiveUpdates = false;

    protected function setUp(): void
    {
        parent::setUp();
        // @var mixed schema(fn (;
        // @var mixed columns(2;
    }

    /**
     * @return array<int|string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return ContactTypeEnum::getFormSchema();
    }

    /*
     * public function saveRelationships(): void
     * {
     *
     * $state = // @var mixed getState(;
     * $record = // @var mixed getRecord(;
     * $relationship = $record->{// @var mixed getRelationship(;
     *
     * if (null === $relationship) {
     * return;
     * }
     * if ($address = $relationship->first()) {
     * $address->update($state);
     * } else {
     * $relationship->updateOrCreate($state);
     * }
     *
     * $record->touch();
     * }
     */
}
