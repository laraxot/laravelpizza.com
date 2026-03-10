@props([
    'title' => '',
    'id' => 'item-' . uniqid(),
    'parentId' => 'accordion',
    'open' => false,
    'icon' => 'it-expand',
])

@php
$collapseId = $id . '-collapse';
$headingId = $id . '-heading';
@endphp

<div 
    class="accordion-item"
    x-data="{ open: @js($open) }"
>
    <h2 class="accordion-header" id="{{ $headingId }}">
        <button 
            class="accordion-button"
            :class="{ 'collapsed': !open }"
            type="button"
            @click="open = !open"
            :aria-expanded="open"
            aria-controls="{{ $collapseId }}"
        >
            {{ $title }}
            <svg class="icon icon-sm" aria-hidden="true">
                <use :href="open ? '#it-collapse' : '#{{ $icon }}'"></use>
            </svg>
        </button>
    </h2>
    <div 
        id="{{ $collapseId }}"
        class="accordion-collapse collapse"
        :class="{ 'show': open }"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-screen"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 max-h-screen"
        x-transition:leave-end="opacity-0 max-h-0"
        :aria-labelledby="'{{ $headingId }}'"
        data-bs-parent="#{{ $parentId }}"
        role="region"
    >
        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>

<style>
.accordion {
    --bs-accordion-color: #17324d;
    --bs-accordion-bg: #fff;
    --bs-accordion-border-color: #e3e7eb;
    --bs-accordion-border-width: 1px;
    --bs-accordion-border-radius: 4px;
    --bs-accordion-inner-border-radius: 3px;
    --bs-accordion-btn-padding-x: 1.25rem;
    --bs-accordion-btn-padding-y: 1rem;
    --bs-accordion-btn-color: #17324d;
    --bs-accordion-btn-bg: #f5f6f7;
    --bs-accordion-btn-focus-border-color: #0066cc;
    --bs-accordion-btn-focus-box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.25);
    --bs-accordion-body-padding-x: 1.25rem;
    --bs-accordion-body-padding-y: 1rem;
    --bs-accordion-active-color: #0066cc;
    --bs-accordion-active-bg: #e8f1fa;
}

.accordion-item {
    background-color: var(--bs-accordion-bg);
    border: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
    border-radius: var(--bs-accordion-border-radius);
    margin-bottom: 0.5rem;
}

.accordion-item:last-child {
    margin-bottom: 0;
}

.accordion-header {
    margin-bottom: 0;
}

.accordion-button {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    padding: var(--bs-accordion-btn-padding-y) var(--bs-accordion-btn-padding-x);
    font-size: 1rem;
    font-weight: 600;
    color: var(--bs-accordion-btn-color);
    text-align: left;
    background-color: var(--bs-accordion-btn-bg);
    border: 0;
    border-radius: var(--bs-accordion-inner-border-radius);
    overflow-anchor: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.accordion-button:hover {
    background-color: var(--bs-accordion-active-bg);
    color: var(--bs-accordion-active-color);
}

.accordion-button:focus {
    outline: 0;
    box-shadow: var(--bs-accordion-btn-focus-box-shadow);
    border-color: var(--bs-accordion-btn-focus-border-color);
}

.accordion-button:not(.collapsed) {
    color: var(--bs-accordion-active-color);
    background-color: var(--bs-accordion-active-bg);
}

.accordion-button .icon {
    margin-left: auto;
    flex-shrink: 0;
    width: 1.25rem;
    height: 1.25rem;
    transition: transform 0.3s ease;
}

.accordion-button:not(.collapsed) .icon {
    transform: rotate(180deg);
}

.accordion-collapse {
    overflow: hidden;
}

.accordion-body {
    padding: var(--bs-accordion-body-padding-y) var(--bs-accordion-body-padding-x);
    color: var(--bs-accordion-color);
}

/* Flush variant */
.accordion-flush .accordion-item {
    border-right: 0;
    border-left: 0;
    border-radius: 0;
}

.accordion-flush .accordion-item:first-child {
    border-top: 0;
}

.accordion-flush .accordion-item:last-child {
    border-bottom: 0;
}

.accordion-flush .accordion-button {
    border-radius: 0;
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .accordion {
        --bs-accordion-color: #f0f4f8;
        --bs-accordion-bg: #1a2332;
        --bs-accordion-border-color: #2d3748;
        --bs-accordion-btn-color: #e2e8f0;
        --bs-accordion-btn-bg: #2d3748;
        --bs-accordion-active-color: #63b3ed;
        --bs-accordion-active-bg: #2c5282;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .accordion-button {
        border: 2px solid currentColor;
    }
    
    .accordion-button:focus {
        outline: 3px solid currentColor;
        outline-offset: 2px;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .accordion-button,
    .accordion-button .icon,
    .accordion-collapse {
        transition: none;
    }
}
</style>
