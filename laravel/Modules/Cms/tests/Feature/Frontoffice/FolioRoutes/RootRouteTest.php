<?php

declare(strict_types=1);

it('GET / redirects to /{locale}', function (): void {
    $locale = app()->getLocale();
    $this->get('/')->assertRedirect('/'.$locale);
});
