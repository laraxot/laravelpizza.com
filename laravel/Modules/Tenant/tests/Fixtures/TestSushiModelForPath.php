<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Fixtures;

use Modules\Tenant\Models\TestSushiModel;

final class TestSushiModelForPath extends TestSushiModel
{
    private string $jsonPath = '';

    public function setJsonPath(string $jsonPath): self
    {
        $this->jsonPath = $jsonPath;

        return $this;
    }

    public function getJsonFile(): string
    {
        return $this->jsonPath;
    }
}
