<?php

declare(strict_types=1);

use Modules\Job\Filament\Resources\JobResource;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

/*
 * ADR docs/adr/jobs-table-read-only-in-admin.md: la tabella jobs la scrive la coda, non una persona.
 * Una pagina create/edit registrata nella risorsa riaprirebbe la scrittura a mano del payload.
 */
it('registers only list and board pages on JobResource, never create or edit', function (): void {
    expect(array_keys(JobResource::getPages()))->toEqualCanonicalizing(['index', 'board']);
});
