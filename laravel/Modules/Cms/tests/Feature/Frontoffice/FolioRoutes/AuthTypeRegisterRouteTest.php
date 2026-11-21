<?php

declare(strict_types=1);
use Modules\Cms\Tests\TestCase;

<<<<<<< .merge_file_skdhg1
uses(TestCase::class);

=======
>>>>>>> .merge_file_lyKn5h
it('SKIP dynamic /it/auth/{type}/register', function (): void {
    $this->markTestSkipped('Dynamic type route requires fixture.');
});
