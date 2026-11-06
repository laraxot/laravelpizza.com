<?php

declare(strict_types=1);
?>
@php
    header("Location: $to");
    exit();
@endphp
<meta http-equiv="refresh" content="0; url={{ $to }}">
<div class="container">
    <h1>{{ __('ui::redirect.widget.redirecting.message') }}</h1>
    <p>{!! __('ui::redirect.widget.fallback.label', ['link' => '<a href="'.e($to).'" class="link">'.e(__('ui::redirect.widget.link.label')).'</a>']) !!}</p>
    <p><small>{{ __('ui::redirect.widget.destination.label', ['url' => $to]) }}</small></p>
</div>

<script>
    // Fallback JavaScript redirect
    setTimeout(function() {
        window.location.href = @json($to);
    }, 10);
</script>
