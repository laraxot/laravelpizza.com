<?php

declare(strict_types=1);

?>
<div {{ $attributes->merge(['class' => 'max-w-wide mx-auto p-2']) }}>
    {!! $slot !!}
</div>
