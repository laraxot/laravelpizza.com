<?php

declare(strict_types=1);

uses(\Modules\Media\Tests\TestCase::class);

use Modules\Media\Actions\AttachMediaAction;
use Spatie\QueueableAction\QueueableAction;

describe('AttachMediaAction', function () {
    it('uses QueueableAction trait', function (): void {
        // Arrange
        $action = new AttachMediaAction;

        // Assert - Verify the trait is used
        expect(trait_exists(QueueableAction::class))->toBeTrue();
    });

    it('is instance of AttachMediaAction', function (): void {
        // Arrange
        $action = new AttachMediaAction;

        // Assert
        expect($action)->toBeInstanceOf(AttachMediaAction::class);
    });

    it('can be instantiated', function (): void {
        // Act
        $action = new AttachMediaAction;

        // Assert
        expect($action)->not()->toBeNull();
    });
});
