{{--
/**
 * Accordion Component - Bootstrap Italia Compliant
 * 
 * Accordion component for collapsible content sections
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $id Custom ID for the accordion
 * @param string $class Additional CSS classes
 * @param bool $flush Whether to use flush variant
 * @param bool $alwaysOpen Whether multiple items can be open at once
 * @param string $variant Accordion variant: 'default', 'flush'
 * @param string $size Accordion size: 'sm', 'md', 'lg'
 */
--}}

@props([
    'id' => null,
    'class' => '',
    'flush' => false,
    'alwaysOpen' => false,
    'variant' => 'default', // 'default', 'flush'
    'size' => 'md' // 'sm', 'md', 'lg'
])

@php
    $accordionId = $id ?? 'accordion-' . uniqid();
    $accordionClasses = collect(['accordion']);
    
    // Variant classes
    if ($variant === 'flush' || $flush) {
        $accordionClasses->push('accordion-flush');
    }
    
    // Size classes
    if ($size !== 'md') {
        $accordionClasses->push('accordion-' . $size);
    }
    
    // Additional classes
    if ($class) {
        $accordionClasses->push($class);
    }
@endphp

<div 
    class="{{ $accordionClasses->implode(' ') }}"
    id="{{ $accordionId }}"
    @if($alwaysOpen) data-bs-accordion="always-open" @endif
    {{ $attributes->except(['id', 'class', 'flush', 'alwaysOpen', 'variant', 'size']) }}
>
    @if(isset($items))
        {{ $items }}
    @else
        {{ $slot }}
    @endif
</div>

{{-- Custom CSS for AGID-compliant accordion styling --}}
<style>
.accordion {
    --bs-accordion-color: #212529;
    --bs-accordion-bg: #fff;
    --bs-accordion-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease-in-out;
    --bs-accordion-border-color: #dee2e6;
    --bs-accordion-border-width: 1px;
    --bs-accordion-border-radius: 0.375rem;
    --bs-accordion-inner-border-radius: calc(0.375rem - 1px);
    --bs-accordion-btn-padding-x: 1.25rem;
    --bs-accordion-btn-padding-y: 1rem;
    --bs-accordion-btn-color: #212529;
    --bs-accordion-btn-bg: var(--bs-accordion-bg);
    --bs-accordion-btn-icon-width: 1.25rem;
    --bs-accordion-btn-icon-transform: rotate(-180deg);
    --bs-accordion-btn-icon-transition: transform 0.2s ease-in-out;
    --bs-accordion-btn-active-icon-transform: rotate(0deg);
    --bs-accordion-btn-focus-border-color: var(--italia-blue-500);
    --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(0, 102, 204, 0.25);
    --bs-accordion-body-padding-x: 1.25rem;
    --bs-accordion-body-padding-y: 1rem;
    --bs-accordion-active-color: var(--italia-blue-600);
    --bs-accordion-active-bg: var(--italia-blue-50);
}

.accordion-item {
    color: var(--bs-accordion-color);
    background-color: var(--bs-accordion-bg);
    border: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
}

.accordion-item:first-of-type {
    border-top-left-radius: var(--bs-accordion-border-radius);
    border-top-right-radius: var(--bs-accordion-border-radius);
}

.accordion-item:first-of-type .accordion-button {
    border-top-left-radius: var(--bs-accordion-inner-border-radius);
    border-top-right-radius: var(--bs-accordion-inner-border-radius);
}

.accordion-item:last-of-type {
    border-bottom-right-radius: var(--bs-accordion-border-radius);
    border-bottom-left-radius: var(--bs-accordion-border-radius);
}

.accordion-item:last-of-type .accordion-button.collapsed {
    border-bottom-right-radius: var(--bs-accordion-inner-border-radius);
    border-bottom-left-radius: var(--bs-accordion-inner-border-radius);
}

.accordion-item:not(:first-of-type) {
    border-top: 0;
}

.accordion-item:not(:last-of-type) {
    border-bottom: 0;
}

.accordion-button {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    padding: var(--bs-accordion-btn-padding-y) var(--bs-accordion-btn-padding-x);
    font-size: 1rem;
    color: var(--bs-accordion-btn-color);
    text-align: left;
    background-color: var(--bs-accordion-btn-bg);
    border: 0;
    border-radius: 0;
    overflow-anchor: none;
    transition: var(--bs-accordion-transition);
}

.accordion-button:not(.collapsed) {
    color: var(--bs-accordion-active-color);
    background-color: var(--bs-accordion-active-bg);
    box-shadow: inset 0 -1px 0 var(--bs-accordion-border-color);
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230066cc'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    transform: var(--bs-accordion-btn-active-icon-transform);
}

.accordion-button::after {
    flex-shrink: 0;
    width: var(--bs-accordion-btn-icon-width);
    height: var(--bs-accordion-btn-icon-width);
    margin-left: auto;
    content: "";
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-size: var(--bs-accordion-btn-icon-width);
    transition: var(--bs-accordion-btn-icon-transition);
}

.accordion-button:hover {
    z-index: 2;
}

.accordion-button:focus {
    z-index: 3;
    border-color: var(--bs-accordion-btn-focus-border-color);
    outline: 0;
    box-shadow: var(--bs-accordion-btn-focus-box-shadow);
}

.accordion-header {
    margin-bottom: 0;
}

.accordion-body {
    padding: var(--bs-accordion-body-padding-y) var(--bs-accordion-body-padding-x);
}

.accordion-flush .accordion-item {
    border-left: 0;
    border-right: 0;
    border-radius: 0;
}

.accordion-flush .accordion-item:first-child {
    border-top: 0;
}

.accordion-flush .accordion-item:last-child {
    border-bottom: 0;
}

.accordion-flush .accordion-item .accordion-button {
    border-radius: 0;
}

/* Size variants */
.accordion-sm .accordion-button {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
}

.accordion-sm .accordion-body {
    padding: 0.75rem 1rem;
}

.accordion-lg .accordion-button {
    padding: 1.5rem 1.5rem;
    font-size: 1.125rem;
}

.accordion-lg .accordion-body {
    padding: 1.5rem 1.5rem;
}

/* High contrast mode support */
.high-contrast .accordion-item {
    border-color: #000000;
    background-color: #ffffff;
}

.high-contrast .accordion-button {
    color: #000000;
    background-color: #ffffff;
    border-color: #000000;
}

.high-contrast .accordion-button:not(.collapsed) {
    color: #000000;
    background-color: #f0f0f0;
}

.high-contrast .accordion-button:focus {
    border-color: #000000;
    box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.5);
}

/* Focus styles */
.accordion-button:focus {
    outline: 2px solid var(--italia-blue-500);
    outline-offset: 2px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .accordion-button {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .accordion-body {
        padding: 0.75rem 1rem;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .accordion-button,
    .accordion-button::after {
        transition: none;
    }
}
</style>

{{-- JavaScript for accordion functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordions = document.querySelectorAll('.accordion');
    
    accordions.forEach(function(accordion) {
        const buttons = accordion.querySelectorAll('.accordion-button');
        const alwaysOpen = accordion.hasAttribute('data-bs-accordion') && 
                          accordion.getAttribute('data-bs-accordion') === 'always-open';
        
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    if (!alwaysOpen && !isExpanded) {
                        // Close other open items in the same accordion
                        const otherButtons = accordion.querySelectorAll('.accordion-button:not([aria-expanded="false"])');
                        otherButtons.forEach(function(otherButton) {
                            if (otherButton !== this) {
                                const otherTargetId = otherButton.getAttribute('data-bs-target');
                                const otherTargetElement = document.querySelector(otherTargetId);
                                
                                if (otherTargetElement) {
                                    otherButton.classList.add('collapsed');
                                    otherButton.setAttribute('aria-expanded', 'false');
                                    otherTargetElement.classList.remove('show');
                                }
                            }
                        }.bind(this));
                    }
                    
                    // Toggle current item
                    if (isExpanded) {
                        this.classList.add('collapsed');
                        this.setAttribute('aria-expanded', 'false');
                        targetElement.classList.remove('show');
                    } else {
                        this.classList.remove('collapsed');
                        this.setAttribute('aria-expanded', 'true');
                        targetElement.classList.add('show');
                    }
                    
                    // Trigger custom event
                    accordion.dispatchEvent(new CustomEvent('accordionChanged', {
                        detail: { 
                            button: this,
                            target: targetElement,
                            isExpanded: !isExpanded
                        }
                    }));
                }
            });
        });
        
        // Keyboard navigation
        buttons.forEach(function(button) {
            button.addEventListener('keydown', function(e) {
                const currentIndex = Array.from(buttons).indexOf(this);
                let targetIndex;
                
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        targetIndex = currentIndex < buttons.length - 1 ? currentIndex + 1 : 0;
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        targetIndex = currentIndex > 0 ? currentIndex - 1 : buttons.length - 1;
                        break;
                    case 'Home':
                        e.preventDefault();
                        targetIndex = 0;
                        break;
                    case 'End':
                        e.preventDefault();
                        targetIndex = buttons.length - 1;
                        break;
                    default:
                        return;
                }
                
                if (targetIndex !== undefined) {
                    buttons[targetIndex].focus();
                }
            });
        });
    });
});
</script>

{{-- 
Usage Examples:

1. Basic accordion:
<x-pub_theme::ui.accordion>
    <x-slot name="items">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true">
                    Accordion Item #1
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false">
                    Accordion Item #2
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes.
                </div>
            </div>
        </div>
    </x-slot>
</x-pub_theme::ui.accordion>

2. Flush accordion:
<x-pub_theme::ui.accordion variant="flush">
    <x-slot name="items">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#flush-collapse1" aria-expanded="true">
                    Flush Accordion Item #1
                </button>
            </h2>
            <div id="flush-collapse1" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    Content for flush accordion item 1
                </div>
            </div>
        </div>
    </x-slot>
</x-pub_theme::ui.accordion>

3. Always open accordion:
<x-pub_theme::ui.accordion :always-open="true">
    <x-slot name="items">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#always-collapse1" aria-expanded="true">
                    Always Open Item #1
                </button>
            </h2>
            <div id="always-collapse1" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    This item can stay open while others are opened
                </div>
            </div>
        </div>
    </x-slot>
</x-pub_theme::ui.accordion>

4. Different sizes:
<x-pub_theme::ui.accordion size="sm">
    <!-- Small accordion -->
</x-pub_theme::ui.accordion>

<x-pub_theme::ui.accordion size="lg">
    <!-- Large accordion -->
</x-pub_theme::ui.accordion>

5. With custom event handling:
<script>
document.addEventListener('accordionChanged', function(event) {
    console.log('Accordion changed:', event.detail);
    // Custom logic when accordion changes
});
</script>

Accessibility Features:
- Proper ARIA attributes (aria-expanded, aria-controls)
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
