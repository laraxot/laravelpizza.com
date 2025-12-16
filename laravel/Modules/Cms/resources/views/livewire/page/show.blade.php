<?php

declare(strict_types=1);

?>
@if (!empty($pageContent['error']))
    <div class="alert alert-danger">
        {{ $pageContent['error'] }}
        @if(isset($pageContent['file']) && isset($pageContent['line']))
            <div class="mt-2">
                <strong>File:</strong> {{ $pageContent['file'] }}
                <strong>Line:</strong> {{ $pageContent['line'] }}
            </div>
        @endif
    </div>
@else
    <div class="page-content">
        @if(isset($pageContent['title']))
            <h1 class="page-title">{{ $pageContent['title'] }}</h1>
        @endif

        @if(isset($pageContent['subtitle']))
            <h2 class="page-subtitle">{{ $pageContent['subtitle'] }}</h2>
        @endif

        @if(isset($pageContent['content']))
            <div class="page-body">
                {!! $pageContent['content'] !!}
            </div>
        @endif

        @if(isset($pageContent['blocks']) && is_array($pageContent['blocks']))
            <div class="page-blocks">
                @foreach($pageContent['blocks'] as $block)
                    @if(isset($block['type']) && isset($block['content']))
                        @php
                            $blockType = $block['type'];
                            $blockContent = $block['content'];
                            $blockView = "cms::components.blocks.{$blockType}";
                        @endphp

                        @if(view()->exists($blockView))
                            @include($blockView, ['content' => $blockContent])
                        @else
                            <div class="block block-{{ $blockType }}">
                                @if(is_string($blockContent))
                                    {!! $blockContent !!}
                                @elseif(is_array($blockContent))
                                    @foreach($blockContent as $key => $value)
                                        @if(is_string($value))
                                            <div class="block-item" data-key="{{ $key }}">
                                                {!! $value !!}
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif
