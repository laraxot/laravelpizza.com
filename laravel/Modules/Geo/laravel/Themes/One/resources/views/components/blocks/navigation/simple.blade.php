{{--
/**
 * Simple Navigation Component - Theme Zero
 *
 * Componente di navigazione semplice per il tema Zero (base/fallback).
 * Utilizzato per blocchi CMS di navigazione base.
 *
 * @var array $data Dati di configurazione del blocco
 */
--}}

<nav class="simple-navigation" role="navigation" aria-label="Navigation">
    <div class="navigation-wrapper">
        {{-- Contenuto di base della navigazione --}}
        @if(isset($data['title']) || isset($data['brand']))
            <div class="nav-title">
                <h2>{{ $data['brand'] ?? $data['title'] }}</h2>
            </div>
        @endif

        {{-- Menu items se disponibili --}}
        @if(isset($data['menu_items']) && is_array($data['menu_items']))
            <ul class="nav-menu">
                @foreach($data['menu_items'] as $item)
                    <li class="nav-item">
                        <a 
                            href="{{ $item['url'] ?? '#' }}" 
                            class="nav-link"
                            @if($item['external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                        >
                            {{ $item['label'] ?? $item['title'] ?? 'Menu Item' }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Fallback content --}}
        @if(!isset($data['menu_items']) || empty($data['menu_items']))
            <div class="nav-placeholder">
                <p>Simple navigation component loaded successfully</p>
            </div>
        @endif
    </div>
</nav>

<style>
/* Stili base per il tema Zero */
.simple-navigation {
    padding: 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.navigation-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

.nav-title h2 {
    margin: 0 0 1rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    gap: 1.5rem;
}

.nav-item {
    margin: 0;
}

.nav-link {
    color: #495057;
    text-decoration: none;
    padding: 0.5rem 0;
    transition: color 0.2s ease;
}

.nav-link:hover {
    color: #007bff;
}

.nav-placeholder {
    color: #6c757d;
    font-style: italic;
}
</style>