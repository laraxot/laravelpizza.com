<?php

declare(strict_types=1);

?>
<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        {{ $getState() }}
    </div>
</x-dynamic-component>
