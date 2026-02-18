<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

?>


        <x-page 
            side="content" 
            :slug="$pageSlug" 
            :data="$data"
        />
    