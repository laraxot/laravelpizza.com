<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Support;

use Modules\Tenant\Models\TestSushiModel;

/**
 * TestSushiModel variant with an overridable JSON path, used by
 * SushiToJsonIntegrationTest to isolate storage per tenant.
 *
 * Named (not anonymous) class: PDepend/PHPMD crashes ("No node to visit
 * provided for visitAnonymousClass.") on the anonymous-class form when it
 * is instantiated inside a Pest top-level helper function.
 */
class TestSushiModelWithJsonPath extends TestSushiModel
{
    public string $jsonPath = '';

    public function setJsonPath(string $jsonPath): void
    {
        $this->jsonPath = $jsonPath;
    }

    public function getJsonFile(): string
    {
        return $this->jsonPath;
    }
}
