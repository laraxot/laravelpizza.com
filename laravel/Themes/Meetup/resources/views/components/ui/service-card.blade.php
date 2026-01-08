{{--
/**
 * AGID Service Card Component - Bootstrap Italia Compliant
 * 
 * Service card component conforming to AGID design system
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $title Title of the service
 * @param string $description Description of the service
 * @param string $icon Icon name for the service
 * @param string $url URL to the service page
 * @param string $category Category of the service
 * @param string $status Status of the service: 'active', 'inactive', 'maintenance'
 * @param string $id Custom ID for the service card
 * @param string $class Additional CSS classes
 * @param bool $featured Whether the service is featured
 * @param string $image Background image URL
 * @param string $color Accent color for the service
 */
--}}

@props([
    'title' => '',
    'description' => '',
    'icon' => 'it-settings',
    'url' => '#',
    'category' => '',
    'status' => 'active', // 'active', 'inactive', 'maintenance'
    'id' => null,
    'class' => '',
    'featured' => false,
    'image' => null,
    'color' => 'primary'
])

@php
    $cardId = $id ?? 'service-card-' . uniqid();
    $cardClasses = collect(['service-card', 'card', 'h-100']);
    
    // Status classes
    switch ($status) {
        case 'inactive':
            $cardClasses->push('service-card-inactive');
            break;
        case 'maintenance':
            $cardClasses->push('service-card-maintenance');
            break;
        default:
            // active is default, no additional class needed
            break;
    }
    
    // Featured class
    if ($featured) {
        $cardClasses->push('service-card-featured');
    }
    
    // Color classes
    if ($color !== 'primary') {
        $cardClasses->push('service-card-' . $color);
    }
    
    // Additional classes
    if ($class) {
        $cardClasses->push($class);
    }
    
    $statusLabels = [
        'active' => 'Attivo',
        'inactive' => 'Non disponibile',
        'maintenance' => 'In manutenzione'
    ];
    
    $statusIcons = [
        'active' => 'it-check-circle',
        'inactive' => 'it-close-circle',
        'maintenance' => 'it-tool'
    ];
@endphp

<div 
    class="{{ $cardClasses->implode(' ') }}"
    id="{{ $cardId }}"
    data-service-card
    {{ $attributes->except(['title', 'description', 'icon', 'url', 'category', 'status', 'id', 'class', 'featured', 'image', 'color']) }}
>
    @if($image)
        <div class="service-card-image" style="background-image: url('{{ $image }}');" aria-hidden="true"></div>
    @endif
    
    <div class="card-body d-flex flex-column">
        <div class="service-card-header mb-3">
            @if($category)
                <span class="service-card-category badge bg-light text-dark mb-2">
                    {{ $category }}
                </span>
            @endif
            
            @if($featured)
                <span class="service-card-featured-badge badge bg-warning text-dark mb-2">
                    In evidenza
                </span>
            @endif
            
            <div class="service-card-icon mb-3">
                <svg class="icon icon-lg text-primary">
                    <use href="#{{ $icon }}"></use>
                </svg>
            </div>
            
            <h3 class="service-card-title card-title h5 mb-3">
                <a href="{{ $url }}" class="text-decoration-none text-dark">
                    {{ $title }}
                </a>
            </h3>
        </div>
        
        <div class="service-card-content flex-grow-1">
            @if($description)
                <p class="service-card-description card-text text-muted mb-3">
                    {{ $description }}
                </p>
            @endif
            
            {{ $slot }}
        </div>
        
        <div class="service-card-footer mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div class="service-card-status">
                    <span class="service-card-status-badge badge bg-{{ $status === 'active' ? 'success' : ($status === 'maintenance' ? 'warning' : 'secondary') }}">
                        <svg class="icon icon-sm me-1">
                            <use href="#{{ $statusIcons[$status] }}"></use>
                        </svg>
                        {{ $statusLabels[$status] }}
                    </span>
                </div>
                
                <a 
                    href="{{ $url }}" 
                    class="service-card-link btn btn-outline-primary btn-sm"
                    aria-label="Accedi al servizio: {{ $title }}"
                >
                    Accedi
                    <svg class="icon icon-sm ms-1">
                        <use href="#it-arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS for AGID-compliant service card styling --}}
<style>
.service-card {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-color: var(--italia-blue-300);
}

.service-card-image {
    height: 120px;
    background-size: cover;
    background-position: center;
    border-radius: 0.5rem 0.5rem 0 0;
}

.service-card-header {
    position: relative;
}

.service-card-category {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.service-card-featured-badge {
    font-size: 0.75rem;
    font-weight: 600;
}

.service-card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background-color: var(--italia-blue-50);
    border-radius: 50%;
    margin: 0 auto;
}

.service-card-title {
    font-weight: 600;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.service-card-title a:hover {
    color: var(--italia-blue-600) !important;
}

.service-card-description {
    font-size: 0.875rem;
    line-height: 1.5;
    color: #6c757d;
}

.service-card-status-badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.service-card-link {
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.service-card-link:hover {
    background-color: var(--italia-blue-500);
    border-color: var(--italia-blue-500);
    color: #ffffff;
}

/* Status variants */
.service-card-inactive {
    opacity: 0.7;
    background-color: #f8f9fa;
}

.service-card-inactive .service-card-title a {
    color: #6c757d !important;
}

.service-card-maintenance {
    border-color: #ffc107;
    background-color: #fffbf0;
}

.service-card-maintenance .service-card-icon {
    background-color: #fff3cd;
}

/* Featured variant */
.service-card-featured {
    border-color: var(--italia-blue-500);
    box-shadow: 0 4px 8px rgba(0, 102, 204, 0.2);
}

.service-card-featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--italia-blue-500), var(--italia-green-500));
    border-radius: 0.5rem 0.5rem 0 0;
}

/* Color variants */
.service-card-success .service-card-icon {
    background-color: var(--italia-green-50);
    color: var(--italia-green-600);
}

.service-card-warning .service-card-icon {
    background-color: var(--italia-yellow-50);
    color: var(--italia-yellow-600);
}

.service-card-danger .service-card-icon {
    background-color: var(--italia-red-50);
    color: var(--italia-red-600);
}

/* High contrast mode support */
.high-contrast .service-card {
    border-color: #000000;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.high-contrast .service-card:hover {
    border-color: #000000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.high-contrast .service-card-title a {
    color: #000000 !important;
}

.high-contrast .service-card-title a:hover {
    color: #0000ff !important;
}

.high-contrast .service-card-link {
    border-color: #000000;
    color: #000000;
}

.high-contrast .service-card-link:hover {
    background-color: #000000;
    color: #ffffff;
}

/* Focus styles */
.service-card-link:focus {
    outline: 2px solid var(--italia-blue-500);
    outline-offset: 2px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .service-card {
        margin-bottom: 1rem;
    }
    
    .service-card-icon {
        width: 50px;
        height: 50px;
    }
    
    .service-card-title {
        font-size: 1.125rem;
    }
    
    .service-card-description {
        font-size: 0.8rem;
    }
    
    .service-card-link {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .service-card,
    .service-card-link {
        transition: none;
    }
    
    .service-card:hover {
        transform: none;
    }
}
</style>

{{-- JavaScript for service card functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('[data-service-card]');
    
    serviceCards.forEach(function(card) {
        const links = card.querySelectorAll('a');
        
        // Handle link clicks
        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                // Track service card clicks (optional)
                const serviceTitle = card.querySelector('.service-card-title')?.textContent?.trim();
                
                // Trigger custom event
                card.dispatchEvent(new CustomEvent('serviceCardClicked', {
                    detail: { 
                        title: serviceTitle,
                        url: this.getAttribute('href'),
                        category: card.querySelector('.service-card-category')?.textContent?.trim()
                    }
                }));
            });
        });
        
        // Keyboard navigation
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const mainLink = card.querySelector('.service-card-title a');
                if (mainLink) {
                    mainLink.click();
                }
            }
        });
        
        // Make card focusable
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'article');
    });
});
</script>

{{-- 
Usage Examples:

1. Basic service card:
<x-ui.service-card
    title="Servizio Anagrafe"
    description="Gestione anagrafe cittadini e servizi demografici"
    icon="it-user"
    url="/servizi/anagrafe"
    category="Demografici"
/>

2. Featured service card:
<x-ui.service-card
    title="Servizio Tributi"
    description="Pagamento tasse e tributi comunali"
    icon="it-credit-card"
    url="/servizi/tributi"
    category="Fiscali"
    :featured="true"
/>

3. Service card with image:
<x-ui.service-card
    title="Servizio Cultura"
    description="Eventi culturali e biblioteca comunale"
    icon="it-book"
    url="/servizi/cultura"
    category="Cultura"
    image="https://example.com/culture-bg.jpg"
/>

4. Service card with different status:
<x-ui.service-card
    title="Servizio in Manutenzione"
    description="Servizio temporaneamente non disponibile"
    icon="it-tool"
    url="/servizi/manutenzione"
    category="Tecnici"
    status="maintenance"
/>

5. Service card with custom color:
<x-ui.service-card
    title="Servizio Ambiente"
    description="Gestione rifiuti e ambiente"
    icon="it-leaf"
    url="/servizi/ambiente"
    category="Ambiente"
    color="success"
/>

6. Service card with custom content:
<x-ui.service-card
    title="Servizio Personalizzato"
    description="Descrizione del servizio"
    icon="it-settings"
    url="/servizi/personalizzato"
    category="Generale"
>
    <div class="custom-content">
        <p>Contenuto personalizzato per il servizio</p>
        <ul>
            <li>Funzionalità 1</li>
            <li>Funzionalità 2</li>
        </ul>
    </div>
</x-ui.service-card>

7. Service card with custom event handling:
<script>
document.addEventListener('serviceCardClicked', function(event) {
    console.log('Service card clicked:', event.detail);
    // Track analytics, redirect, etc.
});
</script>

Accessibility Features:
- Proper ARIA attributes (role="article")
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
- Lightweight implementation
- Efficient DOM manipulation
- CSS-only animations where possible
- Optimized for mobile devices
- Minimal JavaScript footprint
--}}
