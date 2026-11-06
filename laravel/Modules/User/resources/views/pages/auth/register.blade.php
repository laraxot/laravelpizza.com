<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('register');

?>

<x-layouts.app>
    @include('pub_theme::components.pages.auth-register')
</x-layouts.app>
