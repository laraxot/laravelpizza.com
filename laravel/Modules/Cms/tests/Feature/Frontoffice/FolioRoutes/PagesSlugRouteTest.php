<?php

declare(strict_types=1);

it('SKIP dynamic /it/pages/{slug}', function (): void {
    $this->markTestSkipped('Dynamic pages slug requires fixture.');
});
