<?php

declare(strict_types=1);

?>
@props(['block'])

@component("components.blocks.{$block['type']}", $block['data'] ?? []) @endcomponent
