<?php

declare(strict_types=1);

?>
@php
    header("Location: $to");
    exit();
@endphp
<meta http-equiv="refresh" content="0; url={{ $to }}">
<div class="container">
    <h1>Reindirizzamento in corso...</h1>
    <p>Se non vieni reindirizzato automaticamente, <a href="{{ $to }}" class="link">clicca qui</a>.</p>
    <p><small>Destinazione: {{ $to }}</small></p>
</div>

<script>
    // Fallback JavaScript redirect
    setTimeout(function() {
        window.location.href = @json($to);
    }, 10);
</script>
