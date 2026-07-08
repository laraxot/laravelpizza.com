<?php

declare(strict_types=1);

?>
<div class="flex gap-2 justify-center">
    @foreach($getActions() as $action)
        {!! $action->record($getRecord())->render() !!}
    @endforeach

    <x-filament-actions::modals />
</div>
