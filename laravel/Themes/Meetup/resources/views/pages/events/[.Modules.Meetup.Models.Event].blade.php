<?php

use function Laravel\Folio\name;

name('events.show');

?>
<x-layouts.app>
    <x-blocks.events.detail :event="$event" />
</x-layouts.app>
