<?php

declare(strict_types=1);

?>
@php
    $section = $getRecord();
    $content = $section->content;
@endphp

<div class="p-4 bg-white rounded-lg shadow">
    <div class="prose max-w-none">
        @if($content)
            {!! $content !!}
        @else
            <div class="text-gray-500">
                {{ __('cms::sections.preview.empty') }}
            </div>
        @endif
    </div>
</div>
