<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Filament\Resources;

use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Schemas\TreatmentForm;
use PHPUnit\Framework\Assert;

/*
 * Il form vero del trattamento e' `TreatmentForm` (`XotBaseResource::form()` usa solo lui). Il DPO deve poter
 * modificare da qui versione e URL del documento, che la registrazione scrive nella prova dei consensi (DCP-178).
 * Fino al 2026-10-14 questi campi esistevano solo in `TreatmentResource::getFormSchemaOld()`, mai arrivato al pannello.
 */

/**
 * @param  array<mixed>  $components
 * @return list<string>
 */
function treatmentFormFieldNames(array $components): array
{
    $names = [];
    foreach ($components as $component) {
        if ($component instanceof Field) {
            $names[] = $component->getName();
        }
        if ($component instanceof Component) {
            $children = $component->getDefaultChildComponents();
            $names = [...$names, ...treatmentFormFieldNames($children instanceof Schema ? $children->getComponents() : $children)];
        }
    }

    return $names;
}

test('treatment_form_exposes_every_attribute_the_dpo_edits', function (): void {
    $names = treatmentFormFieldNames(app(TreatmentForm::class)->getFormSchema());

    foreach (['active', 'required', 'name', 'description', 'documentVersion', 'documentUrl', 'weight'] as $field) {
        Assert::assertContains($field, $names, sprintf('Il campo "%s" del trattamento non e\' modificabile dal pannello.', $field));
    }
});
