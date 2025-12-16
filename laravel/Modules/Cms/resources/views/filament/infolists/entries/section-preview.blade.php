<?php

declare(strict_types=1);

?>
@php
    $section = $getRecord();
    $currentLocale = app()->getLocale();
    $translation = $section->translations->where('lang', $currentLocale)->first();
@endphp

<div class="p-4 bg-white rounded-lg shadow">
    @if($translation)
        <h2 class="text-2xl font-bold mb-4">{{ $translation->title }}</h2>
        
        @if($translation->description)
            <div class="prose max-w-none mb-6">
                {!! $translation->description !!}
            </div>
        @endif

        @if($section->blocks->isNotEmpty())
            <div class="space-y-6">
                @foreach($section->blocks->sortBy('order') as $block)
                    @if($block->is_active)
                        <div class="border rounded-lg p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $block->name }}</h3>
                            <div class="prose max-w-none">
                                {!! $block->getContent($currentLocale) !!}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-gray-500 italic">
                Nessun blocco configurato per questa sezione
            </div>
        @endif
    @else
        <div class="text-gray-500 italic">
            Nessuna traduzione disponibile per la lingua corrente
        </div>
    @endif
</div>
