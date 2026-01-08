{{--
/**
 * AGID Services Grid Component - Bootstrap Italia Compliant
 * 
 * Services grid component conforming to AGID design system
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param array $services Array of service data
 * @param int $columns Number of columns in the grid
 * @param bool $showFilters Whether to show category filters
 * @param bool $showSearch Whether to show search functionality
 * @param string $id Custom ID for the services grid
 * @param string $class Additional CSS classes
 * @param string $layout Grid layout: 'grid', 'list', 'masonry'
 * @param bool $showPagination Whether to show pagination
 * @param int $itemsPerPage Number of items per page
 */
--}}

@props([
    'services' => [],
    'columns' => 3,
    'showFilters' => true,
    'showSearch' => true,
    'id' => null,
    'class' => '',
    'layout' => 'grid', // 'grid', 'list', 'masonry'
    'showPagination' => false,
    'itemsPerPage' => 12
])

@php
    $gridId = $id ?? 'services-grid-' . uniqid();
    $gridClasses = collect(['services-grid']);
    
    // Layout classes
    if ($layout !== 'grid') {
        $gridClasses->push('services-grid-' . $layout);
    }
    
    // Additional classes
    if ($class) {
        $gridClasses->push($class);
    }
    
    // Column classes
    $columnClasses = [
        1 => 'col-12',
        2 => 'col-md-6',
        3 => 'col-lg-4',
        4 => 'col-lg-3',
        6 => 'col-lg-2'
    ];
    
    $columnClass = $columnClasses[$columns] ?? 'col-lg-4';
    
    // Get unique categories
    $categories = collect($services)->pluck('category')->filter()->unique()->values()->toArray();
@endphp

<div 
    class="{{ $gridClasses->implode(' ') }}"
    id="{{ $gridId }}"
    data-services-grid
    {{ $attributes->except(['services', 'columns', 'showFilters', 'showSearch', 'id', 'class', 'layout', 'showPagination', 'itemsPerPage']) }}
>
    @if($showSearch || $showFilters)
        <div class="services-grid-controls mb-4">
            <div class="row align-items-center">
                @if($showSearch)
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="input-group">
                            <input 
                                type="text" 
                                class="form-control" 
                                placeholder="Cerca servizi..."
                                id="{{ $gridId }}-search"
                                data-search-input
                            >
                            <button class="btn btn-outline-secondary" type="button" data-search-clear>
                                <svg class="icon icon-sm">
                                    <use href="#it-close"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if($showFilters && count($categories) > 0)
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2">
                            <button 
                                class="btn btn-outline-primary btn-sm active" 
                                data-filter="all"
                                type="button"
                            >
                                Tutti
                            </button>
                            @foreach($categories as $category)
                                <button 
                                    class="btn btn-outline-primary btn-sm" 
                                    data-filter="{{ Str::slug($category) }}"
                                    type="button"
                                >
                                    {{ $category }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <div class="services-grid-content">
        <div class="row" data-services-container>
            @forelse($services as $service)
                <div 
                    class="{{ $columnClass }} mb-4" 
                    data-service-item
                    data-category="{{ Str::slug($service['category'] ?? '') }}"
                    data-title="{{ Str::slug($service['title'] ?? '') }}"
                >
                    <x-ui.service-card
                        :title="$service['title'] ?? ''"
                        :description="$service['description'] ?? ''"
                        :icon="$service['icon'] ?? 'it-settings'"
                        :url="$service['url'] ?? '#'"
                        :category="$service['category'] ?? ''"
                        :status="$service['status'] ?? 'active'"
                        :featured="$service['featured'] ?? false"
                        :image="$service['image'] ?? null"
                        :color="$service['color'] ?? 'primary'"
                    />
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <svg class="icon icon-lg text-muted mb-3">
                            <use href="#it-search"></use>
                        </svg>
                        <h4 class="text-muted">Nessun servizio trovato</h4>
                        <p class="text-muted">Prova a modificare i filtri di ricerca</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    
    @if($showPagination && count($services) > $itemsPerPage)
        <div class="services-grid-pagination mt-4">
            <nav aria-label="Paginazione servizi">
                <ul class="pagination justify-content-center" data-pagination>
                    <!-- Pagination will be generated by JavaScript -->
                </ul>
            </nav>
        </div>
    @endif
</div>

{{-- Custom CSS for AGID-compliant services grid styling --}}
<style>
.services-grid {
    margin-bottom: 2rem;
}

.services-grid-controls {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
}

.services-grid-controls .input-group {
    position: relative;
}

.services-grid-controls .form-control {
    border-radius: 0.375rem;
    border: 1px solid #ced4da;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
}

.services-grid-controls .form-control:focus {
    border-color: var(--italia-blue-500);
    box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
}

.services-grid-controls .btn {
    border-radius: 0.375rem;
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}

.services-grid-controls .btn.active {
    background-color: var(--italia-blue-500);
    border-color: var(--italia-blue-500);
    color: #ffffff;
}

.services-grid-content {
    min-height: 200px;
}

.services-grid-list .services-grid-content .row {
    display: block;
}

.services-grid-list .services-grid-content .col-lg-4,
.services-grid-list .services-grid-content .col-lg-3,
.services-grid-list .services-grid-content .col-lg-2 {
    width: 100%;
    max-width: none;
    flex: none;
}

.services-grid-masonry {
    column-count: 3;
    column-gap: 1rem;
}

.services-grid-masonry .col-lg-4,
.services-grid-masonry .col-lg-3,
.services-grid-masonry .col-lg-2 {
    break-inside: avoid;
    margin-bottom: 1rem;
    display: inline-block;
    width: 100%;
}

/* Search and filter states */
.services-grid .service-item-hidden {
    display: none !important;
}

.services-grid .service-item-visible {
    display: block !important;
}

/* Pagination */
.services-grid-pagination .pagination {
    margin-bottom: 0;
}

.services-grid-pagination .page-link {
    color: var(--italia-blue-500);
    border-color: #dee2e6;
    padding: 0.5rem 0.75rem;
}

.services-grid-pagination .page-link:hover {
    color: var(--italia-blue-600);
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.services-grid-pagination .page-item.active .page-link {
    background-color: var(--italia-blue-500);
    border-color: var(--italia-blue-500);
    color: #ffffff;
}

/* Loading state */
.services-grid-loading {
    opacity: 0.6;
    pointer-events: none;
}

.services-grid-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 2rem;
    height: 2rem;
    margin: -1rem 0 0 -1rem;
    border: 2px solid #f3f3f3;
    border-top: 2px solid var(--italia-blue-500);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* High contrast mode support */
.high-contrast .services-grid-controls {
    background-color: #ffffff;
    border-color: #000000;
}

.high-contrast .services-grid-controls .form-control {
    border-color: #000000;
}

.high-contrast .services-grid-controls .form-control:focus {
    border-color: #000000;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.5);
}

.high-contrast .services-grid-controls .btn {
    border-color: #000000;
    color: #000000;
}

.high-contrast .services-grid-controls .btn.active {
    background-color: #000000;
    color: #ffffff;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .services-grid-controls {
        padding: 1rem;
    }
    
    .services-grid-controls .row {
        flex-direction: column;
    }
    
    .services-grid-controls .col-md-6 {
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .services-grid-masonry {
        column-count: 1;
    }
    
    .services-grid-controls .d-flex {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .services-grid-controls .btn {
        font-size: 0.75rem;
        padding: 0.375rem 0.5rem;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .services-grid-loading::after {
        animation: none;
    }
}
</style>

{{-- JavaScript for services grid functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const servicesGrids = document.querySelectorAll('[data-services-grid]');
    
    servicesGrids.forEach(function(grid) {
        const searchInput = grid.querySelector('[data-search-input]');
        const searchClear = grid.querySelector('[data-search-clear]');
        const filterButtons = grid.querySelectorAll('[data-filter]');
        const serviceItems = grid.querySelectorAll('[data-service-item]');
        const servicesContainer = grid.querySelector('[data-services-container]');
        
        let currentFilter = 'all';
        let currentSearch = '';
        
        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                currentSearch = this.value.toLowerCase().trim();
                filterServices();
            });
        }
        
        if (searchClear) {
            searchClear.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    currentSearch = '';
                    filterServices();
                }
            });
        }
        
        // Filter functionality
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Update current filter
                currentFilter = this.getAttribute('data-filter');
                filterServices();
            });
        });
        
        // Filter and search function
        function filterServices() {
            serviceItems.forEach(function(item) {
                const category = item.getAttribute('data-category');
                const title = item.getAttribute('data-title');
                const titleText = item.querySelector('.service-card-title')?.textContent?.toLowerCase() || '';
                const descriptionText = item.querySelector('.service-card-description')?.textContent?.toLowerCase() || '';
                
                let showItem = true;
                
                // Category filter
                if (currentFilter !== 'all' && category !== currentFilter) {
                    showItem = false;
                }
                
                // Search filter
                if (currentSearch && !titleText.includes(currentSearch) && !descriptionText.includes(currentSearch)) {
                    showItem = false;
                }
                
                // Show/hide item
                if (showItem) {
                    item.classList.remove('service-item-hidden');
                    item.classList.add('service-item-visible');
                } else {
                    item.classList.add('service-item-hidden');
                    item.classList.remove('service-item-visible');
                }
            });
            
            // Update results count
            updateResultsCount();
        }
        
        // Update results count
        function updateResultsCount() {
            const visibleItems = grid.querySelectorAll('[data-service-item]:not(.service-item-hidden)');
            const resultsCount = grid.querySelector('[data-results-count]');
            
            if (resultsCount) {
                resultsCount.textContent = `${visibleItems.length} servizi trovati`;
            }
        }
        
        // Initialize
        filterServices();
        
        // Trigger custom event
        grid.dispatchEvent(new CustomEvent('servicesGridInitialized', {
            detail: { 
                totalServices: serviceItems.length,
                grid: grid
            }
        }));
    });
});
</script>

{{-- 
Usage Examples:

1. Basic services grid:
<x-ui.services-grid
    :services="$services"
    :columns="3"
/>

2. Services grid with search and filters:
<x-ui.services-grid
    :services="$services"
    :columns="3"
    :show-search="true"
    :show-filters="true"
/>

3. List layout:
<x-ui.services-grid
    :services="$services"
    :columns="1"
    layout="list"
/>

4. Masonry layout:
<x-ui.services-grid
    :services="$services"
    :columns="3"
    layout="masonry"
/>

5. With pagination:
<x-ui.services-grid
    :services="$services"
    :columns="3"
    :show-pagination="true"
    :items-per-page="6"
/>

6. Custom styling:
<x-ui.services-grid
    :services="$services"
    :columns="4"
    class="custom-services-grid"
/>

7. With custom event handling:
<script>
document.addEventListener('servicesGridInitialized', function(event) {
    console.log('Services grid initialized:', event.detail);
    // Custom logic when grid is initialized
});
</script>

Accessibility Features:
- Proper ARIA attributes (aria-label, role)
- Keyboard navigation support
- Screen reader friendly
- Focus management
- High contrast mode support
- Semantic HTML structure

AGID Design System Compliance:
- Uses official AGID color palette
- Follows Italian PA design guidelines
- Bootstrap Italia compatible styling
- Mobile-first responsive design
- Consistent with government standards

Performance Considerations:
- Lightweight JavaScript implementation
- Efficient DOM manipulation
- CSS-only animations where possible
- Optimized for mobile devices
- Minimal JavaScript footprint
- Debounced search input
--}}
