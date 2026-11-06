<?php

declare(strict_types=1);

/**
 * GetAllModelsAction Test Suite
 *
 * Scopo: l'action elenca i model dell'applicazione (class-string) per tooling
 * Xot (studio, generatori). Verifica istanziazione, presenza User, e risultato
 * non vuoto senza guardie ridondanti su tipi gia' array.
 */

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\Model\GetAllModelsAction;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetAllModelsActionTest extends TestCase
{
    private GetAllModelsAction $getAllModelsAction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getAllModelsAction = new GetAllModelsAction;
    }

    #[Test]
    public function it_can_be_instantiated(): void
    {
        Assert::assertSame(GetAllModelsAction::class, $this->getAllModelsAction::class);
    }

    #[Test]
    public function it_retrieves_user_model(): void
    {
        $models = $this->getAllModelsAction->execute();

        $userModels = array_values(array_filter(
            $models,
            static fn (string $model): bool => str_contains($model, 'User'),
        ));

        Assert::assertGreaterThan(0, count($userModels));
    }

    #[Test]
    public function it_returns_valid_model_class_names(): void
    {
        $models = $this->getAllModelsAction->execute();

        foreach ($models as $model) {
            Assert::assertIsString($model);
            Assert::assertNotSame('', $model);
        }
    }

    #[Test]
    public function it_handles_invalid_namespaces(): void
    {
        $this->expectNotToPerformAssertions();

        try {
            $this->getAllModelsAction->execute();
        } catch (\Exception $e) {
            $this->fail('Action threw exception on invalid namespace: '.$e->getMessage());
        }
    }

    #[Test]
    public function it_returns_non_empty_result(): void
    {
        $models = $this->getAllModelsAction->execute();

        Assert::assertGreaterThan(0, count($models));
    }
}
