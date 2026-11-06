<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Actions\Robots;

use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;
use PHPUnit\Framework\Assert;

test('every area that robots.txt closes is also noindex in the page head', function (): void {
    // robots.txt e <head> restano due elenchi (un Disallow impedisce di leggere il noindex); il secondo deve almeno contenere il primo,
    // altrimenti un'area chiusa ai crawler ma indicizzabile finisce nell'indice come URL «senza descrizione».
    $closedButIndexable = array_values(array_diff(BuildRobotsTxtAction::PRIVATE_SEGMENTS, ResolveRobotsPolicyAction::HIDDEN_SEGMENTS));

    Assert::assertSame([], $closedButIndexable);
});
