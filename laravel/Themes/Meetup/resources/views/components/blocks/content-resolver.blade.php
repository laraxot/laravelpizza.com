@props([
    'container0' => '',
    'slug0' => '',
])

@php
    $resolvedContent = app(\Modules\Cms\Actions\ResolvePageContentAction::class)->execute($container0, $slug0);
    $content = $resolvedContent['content'];
    $view = $resolvedContent['view'];
    $pageSlug = $resolvedContent['pageSlug'];
@endphp

{{-- Render dynamic model content --}}
@if($content && $view)
    @include('pub_theme::'.$view, [
        'item' => $content,
        'container0' => $container0,
        'slug0' => $slug0,
    ])

{{-- Render CMS page content --}}
@elseif($pageSlug)
    <x-page side="content" :slug="$pageSlug" :data="['container0' => $container0, 'slug0' => $slug0]" />

{{-- Nothing found --}}
@else
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 rounded-lg">
            <h2 class="text-lg font-bold mb-2">Content not found</h2>
            <p>Container: {{ $container0 }}</p>
            <p>Slug: {{ $slug0 }}</p>
        </div>
    </div>
@endif
