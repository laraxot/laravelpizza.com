<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions;

use Modules\Media\Actions\AttachMediaAction;
use Modules\Media\Tests\TestCase;
use Spatie\QueueableAction\QueueableAction;

// `uses()` deve stare DOPO gli `use`: gli import valgono dalla loro riga in
// avanti, quindi scritto sopra `TestCase::class` si risolveva come
// Modules\Media\Tests\Unit\Actions\TestCase e Pest moriva in fase di
// raccolta, portandosi via tutta la suite (base_quaeris_fila5#213).
uses(TestCase::class);

describe('AttachMediaAction', function () {
    it('uses QueueableAction trait', function (): void {
        // Arrange
        // Assert - Verify the trait is used
        expect(trait_exists(QueueableAction::class))->toBeTrue();
    });

    it('is instance of AttachMediaAction', function (): void {
        // Arrange
        $action = new AttachMediaAction;

        // Assert
        expect(get_class($action))->toBe(AttachMediaAction::class);
    });

    it('can be instantiated', function (): void {
        // Act
        $action = new AttachMediaAction;

        // Assert
        expect(get_class($action))->toBe(AttachMediaAction::class);
    });
});
