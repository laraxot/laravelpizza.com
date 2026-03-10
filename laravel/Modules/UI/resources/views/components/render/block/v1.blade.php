<?php

declare(strict_types=1);

?>
@props(['block'])

@component("ui::components.blocks.{$block['type']}", $block['data'] ?? []) @endcomponent
