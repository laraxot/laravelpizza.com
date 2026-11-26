<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form del consenso: trattamento e soggetto, con etichette italiane da lang/it/consents.php.
 *
 * @see Modules/Gdpr/docs/manuals/manuale-utente.md
 */
class ConsentForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     *
     * @see Modules/Gdpr/docs/manuals/manuale-utente.md
     */
    public function getFormSchema(): array
    {
        return [
            'treatment_id' => Select::make('treatment_id')
                ->label(__('gdpr::consents.fields.treatment.name.label'))
                ->relationship('treatment', 'name')
                ->required(),
            'subject_id' => TextInput::make('subject_id')
                ->label(__('gdpr::consents.fields.subject_id.label'))
                ->required()
                ->maxLength(191),
        ];
    }
}
