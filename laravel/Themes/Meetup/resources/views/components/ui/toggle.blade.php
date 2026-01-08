{{--
/**
 * Toggle Component - Bootstrap Italia Compliant
 * 
 * Toggle switch component for on/off states
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $name Name attribute for the input
 * @param string $label Label text for the toggle
 * @param bool $checked Whether the toggle is initially checked
 * @param bool $disabled Whether the toggle is disabled
 * @param string $leverLeft Whether to use left-lever style
 * @param string $size Size variant: 'sm', 'md', 'lg'
 * @param string $color Color variant: 'primary', 'success', 'warning', 'danger'
 * @param string $id Custom ID for the toggle
 * @param string $class Additional CSS classes
 * @param string $value Value for the input
 * @param string $help Help text below the toggle
 */
--}}

@props([
    'name' => 'toggle',
    'label' => 'Toggle option',
    'checked' => false,
    'disabled' => false,
    'leverLeft' => false,
    'size' => 'md', // 'sm', 'md', 'lg'
    'color' => 'primary', // 'primary', 'success', 'warning', 'danger'
    'id' => null,
    'class' => '',
    'value' => '1',
    'help' => ''
])

@php
    $toggleId = $id ?? 'toggle-' . $name . '-' . uniqid();
    $toggleClasses = collect(['toggle-switch']);
    
    // Size classes
    switch ($size) {
        case 'sm':
            $toggleClasses->push('toggle-sm');
            break;
        case 'lg':
            $toggleClasses->push('toggle-lg');
            break;
        default:
            // md is default, no additional class needed
            break;
    }
    
    // Color classes
    switch ($color) {
        case 'success':
            $toggleClasses->push('toggle-success');
            break;
        case 'warning':
            $toggleClasses->push('toggle-warning');
            break;
        case 'danger':
            $toggleClasses->push('toggle-danger');
            break;
        default:
            // primary is default, no additional class needed
            break;
    }
    
    // Lever position
    if ($leverLeft) {
        $toggleClasses->push('toggle-lever-left');
    }
    
    // Additional classes
    if ($class) {
        $toggleClasses->push($class);
    }
@endphp

<div class="toggle-wrapper">
    <div class="form-check form-switch">
        <input 
            class="form-check-input {{ $toggleClasses->implode(' ') }}"
            type="checkbox" 
            role="switch"
            id="{{ $toggleId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $attributes->except(['name', 'label', 'checked', 'disabled', 'leverLeft', 'size', 'color', 'id', 'class', 'value', 'help']) }}
        >
        <label 
            class="form-check-label" 
            for="{{ $toggleId }}"
        >
            {{ $label }}
        </label>
    </div>
    
    @if($help)
        <div class="form-text text-muted mt-1">
            {{ $help }}
        </div>
    @endif
</div>

{{-- Custom CSS for AGID-compliant toggle styling --}}
<style>
.toggle-switch {
    width: 3rem;
    height: 1.5rem;
    background-color: #e9ecef;
    border: 2px solid #e9ecef;
    border-radius: 1rem;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.toggle-switch:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    border-color: var(--italia-blue-500);
}

.toggle-switch:checked {
    background-color: var(--italia-blue-500);
    border-color: var(--italia-blue-500);
}

.toggle-switch:checked::before {
    transform: translateX(1.5rem);
    background-color: white;
}

.toggle-switch::before {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 1rem;
    height: 1rem;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-switch:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Size variants */
.toggle-sm {
    width: 2rem;
    height: 1rem;
}

.toggle-sm::before {
    width: 0.75rem;
    height: 0.75rem;
}

.toggle-sm:checked::before {
    transform: translateX(1rem);
}

.toggle-lg {
    width: 4rem;
    height: 2rem;
}

.toggle-lg::before {
    width: 1.5rem;
    height: 1.5rem;
}

.toggle-lg:checked::before {
    transform: translateX(2rem);
}

/* Color variants */
.toggle-success:checked {
    background-color: var(--italia-green-500);
    border-color: var(--italia-green-500);
}

.toggle-warning:checked {
    background-color: var(--italia-yellow-500);
    border-color: var(--italia-yellow-500);
}

.toggle-danger:checked {
    background-color: var(--italia-red-500);
    border-color: var(--italia-red-500);
}

/* Lever left variant */
.toggle-lever-left:checked::before {
    transform: translateX(-1.5rem);
}

.toggle-lever-left.toggle-sm:checked::before {
    transform: translateX(-1rem);
}

.toggle-lever-left.toggle-lg:checked::before {
    transform: translateX(-2rem);
}

/* Form check label styling */
.form-check-label {
    margin-left: 0.5rem;
    font-weight: 500;
    color: #495057;
    cursor: pointer;
    user-select: none;
}

.toggle-wrapper {
    margin-bottom: 1rem;
}

/* High contrast mode support */
.high-contrast .toggle-switch {
    border-width: 3px;
}

.high-contrast .toggle-switch:focus {
    box-shadow: 0 0 0 0.3rem rgba(0, 102, 204, 0.5);
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .toggle-switch,
    .toggle-switch::before {
        transition: none;
    }
}
</style>

{{-- 
Usage Examples:

1. Basic toggle:
<x-toggle 
    name="notifications"
    label="Enable notifications"
/>

2. Checked toggle with help text:
<x-toggle 
    name="dark_mode"
    label="Dark mode"
    checked="true"
    help="Switch to dark theme for better viewing in low light"
/>

3. Different sizes:
<x-toggle 
    name="small_toggle"
    label="Small toggle"
    size="sm"
/>

<x-toggle 
    name="large_toggle"
    label="Large toggle"
    size="lg"
/>

4. Color variants:
<x-toggle 
    name="success_toggle"
    label="Success toggle"
    color="success"
    checked="true"
/>

<x-toggle 
    name="warning_toggle"
    label="Warning toggle"
    color="warning"
/>

<x-toggle 
    name="danger_toggle"
    label="Danger toggle"
    color="danger"
/>

5. Lever left variant:
<x-toggle 
    name="lever_left"
    label="Lever left toggle"
    lever-left="true"
/>

6. Disabled toggle:
<x-toggle 
    name="disabled_toggle"
    label="Disabled toggle"
    disabled="true"
/>

7. With custom attributes:
<x-toggle 
    name="custom_toggle"
    label="Custom toggle"
    data-custom="value"
    x-data="{ enabled: false }"
    x-model="enabled"
/>

8. Form integration:
<form>
    <div class="mb-3">
        <x-toggle 
            name="terms_accepted"
            label="I accept the terms and conditions"
            required
        />
    </div>
    
    <div class="mb-3">
        <x-toggle 
            name="newsletter"
            label="Subscribe to newsletter"
            help="Receive updates about new features and content"
        />
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

9. Alpine.js integration:
<div x-data="{ settings: { notifications: true, darkMode: false } }">
    <x-toggle 
        name="notifications"
        label="Enable notifications"
        x-model="settings.notifications"
    />
    
    <x-toggle 
        name="dark_mode"
        label="Dark mode"
        x-model="settings.darkMode"
    />
    
    <div class="mt-3">
        <pre x-text="JSON.stringify(settings, null, 2)"></pre>
    </div>
</div>

10. Livewire integration:
<x-toggle 
    name="live_toggle"
    label="Live toggle"
    wire:model="liveSetting"
/>

Accessibility Features:
- Proper ARIA attributes (role="switch")
- Keyboard navigation support
- Screen reader friendly labels
- Focus indicators with high contrast
- Semantic HTML structure
- Support for reduced motion preferences

AGID Design System Compliance:
- Uses official AGID color palette
- Follows Italian PA design guidelines
- High contrast mode support
- Consistent with Bootstrap Italia styling
- Mobile-first responsive design

Performance Considerations:
- Lightweight CSS-only animations
- No JavaScript dependencies
- Efficient DOM structure
- Optimized for mobile devices
- Reduced motion support
--}}
