<?php

declare(strict_types=1);

?>
<x-filament::section>
    <div class="flex flex-wrap items-center gap-4">
        <div>
            <span class="font-medium">{{ __('user::widgets.user_widget.start_date.label') }}</span>
            <span>{{ $startDate }}</span>
        </div>
        <div>
            <span class="font-medium">{{ __('user::widgets.user_widget.end_date.label') }}</span>
            <span>{{ $endDate }}</span>
        </div>
    </div>
</x-filament::section>

