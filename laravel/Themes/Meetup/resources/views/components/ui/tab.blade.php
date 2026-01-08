{{--
/**
 * Tab Component - Bootstrap Italia Compliant
 * 
 * Tab navigation component for organizing content
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $orientation Tab orientation: 'horizontal', 'vertical'
 * @param bool $fullWidth Whether tabs should take full width
 * @param string $variant Tab variant: 'default', 'pills', 'underline'
 * @param string $size Tab size: 'sm', 'md', 'lg'
 * @param string $id Custom ID for the tab container
 * @param string $class Additional CSS classes
 * @param bool $justify Whether to justify tabs
 * @param bool $fill Whether to fill available space
 * @param string $activeTab ID of the initially active tab
 */
--}}

@props([
    'orientation' => 'horizontal', // 'horizontal', 'vertical'
    'fullWidth' => false,
    'variant' => 'default', // 'default', 'pills', 'underline'
    'size' => 'md', // 'sm', 'md', 'lg'
    'id' => null,
    'class' => '',
    'justify' => false,
    'fill' => false,
    'activeTab' => null
])

@php
    $tabId = $id ?? 'tab-' . uniqid();
    $tabClasses = collect(['tab-container']);
    
    // Orientation classes
    if ($orientation === 'vertical') {
        $tabClasses->push('tab-vertical');
    } else {
        $tabClasses->push('tab-horizontal');
    }
    
    // Variant classes
    if ($variant !== 'default') {
        $tabClasses->push('tab-' . $variant);
    }
    
    // Size classes
    if ($size !== 'md') {
        $tabClasses->push('tab-' . $size);
    }
    
    // Additional classes
    if ($class) {
        $tabClasses->push($class);
    }
    
    $navClasses = collect(['nav']);
    
    if ($orientation === 'horizontal') {
        $navClasses->push('nav-tabs');
    } else {
        $navClasses->push('nav-pills', 'flex-column');
    }
    
    if ($variant === 'pills') {
        $navClasses->push('nav-pills');
    } elseif ($variant === 'underline') {
        $navClasses->push('nav-underline');
    }
    
    if ($justify) {
        $navClasses->push('nav-justified');
    }
    
    if ($fill) {
        $navClasses->push('nav-fill');
    }
    
    if ($fullWidth) {
        $navClasses->push('w-100');
    }
@endphp

<div 
    class="{{ $tabClasses->implode(' ') }}"
    id="{{ $tabId }}"
    {{ $attributes->except(['orientation', 'fullWidth', 'variant', 'size', 'id', 'class', 'justify', 'fill', 'activeTab']) }}
>
    @if(isset($tabs))
        <ul 
            class="{{ $navClasses->implode(' ') }}"
            role="tablist"
            @if($orientation === 'horizontal') aria-orientation="horizontal" @else aria-orientation="vertical" @endif
        >
            {{ $tabs }}
        </ul>
    @endif
    
    @if(isset($content))
        <div class="tab-content">
            {{ $content }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>

{{-- Custom CSS for AGID-compliant tab styling --}}
<style>
.tab-container {
    margin-bottom: 1rem;
}

.tab-horizontal {
    display: flex;
    flex-direction: column;
}

.tab-vertical {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

.tab-vertical .nav {
    flex: 0 0 auto;
    min-width: 200px;
}

.tab-vertical .tab-content {
    flex: 1;
}

/* Tab navigation styles */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 1rem;
}

.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    color: #495057;
    background-color: transparent;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
    color: var(--italia-blue-600);
    background-color: #f8f9fa;
}

.nav-tabs .nav-link.active {
    color: var(--italia-blue-600);
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
    border-bottom-color: transparent;
}

.nav-pills .nav-link {
    border-radius: 0.375rem;
    color: #495057;
    background-color: transparent;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.nav-pills .nav-link:hover {
    color: var(--italia-blue-600);
    background-color: #f8f9fa;
}

.nav-pills .nav-link.active {
    color: #fff;
    background-color: var(--italia-blue-500);
}

.nav-underline .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #495057;
    background-color: transparent;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.nav-underline .nav-link:hover {
    color: var(--italia-blue-600);
    border-bottom-color: #dee2e6;
}

.nav-underline .nav-link.active {
    color: var(--italia-blue-600);
    border-bottom-color: var(--italia-blue-500);
}

/* Tab content styles */
.tab-content {
    padding: 1rem 0;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.tab-pane.fade {
    opacity: 0;
    transition: opacity 0.15s linear;
}

.tab-pane.fade.active {
    opacity: 1;
}

/* Size variants */
.tab-sm .nav-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.tab-lg .nav-link {
    padding: 1rem 1.5rem;
    font-size: 1.125rem;
}

/* Full width tabs */
.tab-container .nav.w-100 {
    width: 100%;
}

.tab-container .nav.w-100 .nav-item {
    flex: 1;
}

.tab-container .nav.w-100 .nav-link {
    text-align: center;
}

/* Justified tabs */
.nav-justified .nav-item {
    flex: 1;
}

.nav-justified .nav-link {
    text-align: center;
}

/* Fill tabs */
.nav-fill .nav-item {
    flex: 1;
}

.nav-fill .nav-link {
    width: 100%;
    text-align: center;
}

/* High contrast mode support */
.high-contrast .nav-tabs .nav-link {
    border-color: #000000;
    color: #000000;
}

.high-contrast .nav-tabs .nav-link:hover {
    background-color: #f0f0f0;
    border-color: #000000;
}

.high-contrast .nav-tabs .nav-link.active {
    background-color: #000000;
    color: #ffffff;
    border-color: #000000;
}

.high-contrast .nav-pills .nav-link {
    color: #000000;
    border: 1px solid #000000;
}

.high-contrast .nav-pills .nav-link:hover {
    background-color: #f0f0f0;
}

.high-contrast .nav-pills .nav-link.active {
    background-color: #000000;
    color: #ffffff;
}

/* Focus styles */
.nav-link:focus {
    outline: 2px solid var(--italia-blue-500);
    outline-offset: 2px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .tab-vertical {
        flex-direction: column;
    }
    
    .tab-vertical .nav {
        min-width: auto;
        margin-bottom: 1rem;
    }
    
    .nav-tabs .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .nav-pills .nav-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .nav-link,
    .tab-pane.fade {
        transition: none;
    }
}
</style>

{{-- JavaScript for tab functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabContainers = document.querySelectorAll('.tab-container');
    
    tabContainers.forEach(function(container) {
        const tabLinks = container.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
        const tabPanes = container.querySelectorAll('.tab-pane');
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                
                if (targetPane) {
                    // Remove active class from all tabs and panes
                    tabLinks.forEach(function(tab) {
                        tab.classList.remove('active');
                        tab.setAttribute('aria-selected', 'false');
                    });
                    
                    tabPanes.forEach(function(pane) {
                        pane.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab and target pane
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');
                    targetPane.classList.add('active');
                    
                    // Trigger custom event
                    container.dispatchEvent(new CustomEvent('tabChanged', {
                        detail: { 
                            activeTab: this,
                            activePane: targetPane,
                            targetId: targetId
                        }
                    }));
                }
            });
        });
        
        // Keyboard navigation
        tabLinks.forEach(function(link) {
            link.addEventListener('keydown', function(e) {
                const currentIndex = Array.from(tabLinks).indexOf(this);
                let targetIndex;
                
                switch(e.key) {
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        targetIndex = currentIndex > 0 ? currentIndex - 1 : tabLinks.length - 1;
                        break;
                    case 'ArrowRight':
                    case 'ArrowDown':
                        e.preventDefault();
                        targetIndex = currentIndex < tabLinks.length - 1 ? currentIndex + 1 : 0;
                        break;
                    case 'Home':
                        e.preventDefault();
                        targetIndex = 0;
                        break;
                    case 'End':
                        e.preventDefault();
                        targetIndex = tabLinks.length - 1;
                        break;
                    default:
                        return;
                }
                
                if (targetIndex !== undefined) {
                    tabLinks[targetIndex].focus();
                    tabLinks[targetIndex].click();
                }
            });
        });
    });
});
</script>

{{-- 
Usage Examples:

1. Basic horizontal tabs:
<x-pub_theme::ui.tab orientation="horizontal">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab">
                Tab 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab">
                Tab 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1" role="tabpanel">
            Content for tab 1
        </div>
        <div class="tab-pane" id="tab2" role="tabpanel">
            Content for tab 2
        </div>
    </div>
</x-pub_theme::ui.tab>

2. Vertical tabs:
<x-pub_theme::ui.tab orientation="vertical">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#vtab1" type="button" role="tab">
                Vertical Tab 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vtab2" type="button" role="tab">
                Vertical Tab 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="vtab1" role="tabpanel">
            Content for vertical tab 1
        </div>
        <div class="tab-pane" id="vtab2" role="tabpanel">
            Content for vertical tab 2
        </div>
    </div>
</x-pub_theme::ui.tab>

3. Pills variant:
<x-pub_theme::ui.tab variant="pills">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pill1" type="button" role="tab">
                Pill 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pill2" type="button" role="tab">
                Pill 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="pill1" role="tabpanel">
            Content for pill 1
        </div>
        <div class="tab-pane" id="pill2" role="tabpanel">
            Content for pill 2
        </div>
    </div>
</x-pub_theme::ui.tab>

4. Underline variant:
<x-pub_theme::ui.tab variant="underline">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#underline1" type="button" role="tab">
                Underline 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#underline2" type="button" role="tab">
                Underline 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="underline1" role="tabpanel">
            Content for underline 1
        </div>
        <div class="tab-pane" id="underline2" role="tabpanel">
            Content for underline 2
        </div>
    </div>
</x-pub_theme::ui.tab>

5. Full width tabs:
<x-pub_theme::ui.tab orientation="horizontal" full-width="true">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#full1" type="button" role="tab">
                Full Width 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#full2" type="button" role="tab">
                Full Width 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="full1" role="tabpanel">
            Content for full width 1
        </div>
        <div class="tab-pane" id="full2" role="tabpanel">
            Content for full width 2
        </div>
    </div>
</x-pub_theme::ui.tab>

6. Justified tabs:
<x-pub_theme::ui.tab orientation="horizontal" justify="true">
    <x-slot name="tabs">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#justify1" type="button" role="tab">
                Justified 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#justify2" type="button" role="tab">
                Justified 2
            </button>
        </li>
    </x-slot>
    <div class="tab-content">
        <div class="tab-pane active" id="justify1" role="tabpanel">
            Content for justified 1
        </div>
        <div class="tab-pane" id="justify2" role="tabpanel">
            Content for justified 2
        </div>
    </div>
</x-pub_theme::ui.tab>

7. Different sizes:
<x-pub_theme::ui.tab size="sm">
    <!-- Small tabs -->
</x-pub_theme::ui.tab>

<x-pub_theme::ui.tab size="lg">
    <!-- Large tabs -->
</x-pub_theme::ui.tab>

8. With custom event handling:
<script>
document.addEventListener('tabChanged', function(event) {
    console.log('Tab changed:', event.detail);
    // Custom logic when tab changes
});
</script>

Accessibility Features:
- Proper ARIA attributes (role="tablist", role="tab", role="tabpanel")
- Keyboard navigation (Arrow keys, Home, End)
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
--}}
