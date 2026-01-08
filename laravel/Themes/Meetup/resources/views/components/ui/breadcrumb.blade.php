@props(['items' => []])

{{--
    AGID Compliant Breadcrumb Component
    
    Usage:
    <x-agid.breadcrumb :items="[
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Segnalazioni', 'url' => '/tickets'],
        ['label' => 'Dettaglio'],
    ]" />
--}}

<nav class="breadcrumb-container" aria-label="{{ __('Percorso di navigazione') }}">
    <ol class="breadcrumb" vocab="https://schema.org/" typeof="BreadcrumbList">
        @foreach($items as $index => $item)
            <li class="breadcrumb-item" 
                property="itemListElement" 
                typeof="ListItem"
                @if($loop->last) aria-current="page" @endif>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" property="item" typeof="WebPage">
                        <span property="name">{{ $item['label'] }}</span>
                    </a>
                    <meta property="position" content="{{ $index + 1 }}">
                @else
                    <span property="name">{{ $item['label'] }}</span>
                    <meta property="position" content="{{ $index + 1 }}">
                @endif
            </li>
        @endforeach
    </ol>
</nav>
