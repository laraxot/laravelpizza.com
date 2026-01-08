{{--
/**
 * Notifiche Component - Bootstrap Italia Compliant
 * 
 * Notification component for displaying various types of messages
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $type Type of notification: 'success', 'info', 'warning', 'danger'
 * @param string $title Title of the notification
 * @param string $message Main message content
 * @param string $icon Icon name for the notification
 * @param string $position Position: 'static', 'fixed', 'absolute'
 * @param bool $dismissible Whether the notification can be dismissed
 * @param bool $showIcon Whether to show the icon
 * @param string $id Custom ID for the notification
 * @param string $class Additional CSS classes
 * @param int $timeout Auto-dismiss timeout in milliseconds (0 = no auto-dismiss)
 * @param string $size Size variant: 'sm', 'md', 'lg'
 */
--}}

@props([
    'type' => 'info', // 'success', 'info', 'warning', 'danger'
    'title' => '',
    'message' => '',
    'icon' => null,
    'position' => 'static', // 'static', 'fixed', 'absolute'
    'dismissible' => true,
    'showIcon' => true,
    'id' => null,
    'class' => '',
    'timeout' => 0,
    'size' => 'md' // 'sm', 'md', 'lg'
])

@php
    $notificationId = $id ?? 'notification-' . uniqid();
    $notificationClasses = collect(['alert', 'alert-dismissible', 'fade', 'show']);
    
    // Type classes
    switch ($type) {
        case 'success':
            $notificationClasses->push('alert-success');
            $defaultIcon = 'check-circle';
            break;
        case 'warning':
            $notificationClasses->push('alert-warning');
            $defaultIcon = 'exclamation-triangle';
            break;
        case 'danger':
            $notificationClasses->push('alert-danger');
            $defaultIcon = 'times-circle';
            break;
        default:
            $notificationClasses->push('alert-info');
            $defaultIcon = 'info-circle';
            break;
    }
    
    // Size classes
    switch ($size) {
        case 'sm':
            $notificationClasses->push('alert-sm');
            break;
        case 'lg':
            $notificationClasses->push('alert-lg');
            break;
        default:
            // md is default, no additional class needed
            break;
    }
    
    // Position classes
    switch ($position) {
        case 'fixed':
            $notificationClasses->push('position-fixed', 'top-0', 'end-0', 'm-3', 'z-3');
            break;
        case 'absolute':
            $notificationClasses->push('position-absolute', 'top-0', 'end-0', 'm-3', 'z-3');
            break;
        default:
            // static is default, no additional class needed
            break;
    }
    
    // Additional classes
    if ($class) {
        $notificationClasses->push($class);
    }
    
    // Icon to use
    $iconToUse = $icon ?? $defaultIcon;
@endphp

<div 
    class="{{ $notificationClasses->implode(' ') }}"
    id="{{ $notificationId }}"
    role="alert"
    aria-live="polite"
    @if($timeout > 0) data-timeout="{{ $timeout }}" @endif
    {{ $attributes->except(['type', 'title', 'message', 'icon', 'position', 'dismissible', 'showIcon', 'id', 'class', 'timeout', 'size']) }}
>
    <div class="d-flex align-items-start">
        @if($showIcon && $iconToUse)
            <div class="me-3">
                <svg class="icon icon-{{ $size === 'sm' ? 'sm' : 'md' }} text-{{ $type === 'info' ? 'primary' : $type }}">
                    <use href="#it-{{ $iconToUse }}"></use>
                </svg>
            </div>
        @endif
        
        <div class="flex-grow-1">
            @if($title)
                <h5 class="alert-heading mb-2">
                    {{ $title }}
                </h5>
            @endif
            
            @if($message)
                <p class="mb-0">
                    {{ $message }}
                </p>
            @endif
            
            {{ $slot }}
        </div>
        
        @if($dismissible)
            <button 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="alert" 
                aria-label="Chiudi notifica"
                onclick="dismissNotification('{{ $notificationId }}')"
            >
                <svg class="icon icon-sm">
                    <use href="#it-close"></use>
                </svg>
            </button>
        @endif
    </div>
</div>

{{-- Auto-dismiss functionality --}}
@if($timeout > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('{{ $notificationId }}');
    if (notification) {
        setTimeout(function() {
            if (notification && notification.parentNode) {
                notification.classList.remove('show');
                setTimeout(function() {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 150); // Match CSS transition duration
            }
        }, {{ $timeout }});
    }
});
</script>
@endif

{{-- Custom CSS for AGID-compliant notification styling --}}
<style>
.alert {
    border: 1px solid transparent;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-bottom: 1rem;
    position: relative;
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.alert-lg {
    padding: 1.5rem;
    font-size: 1.125rem;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-info {
    color: #0c5460;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-heading {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.btn-close {
    background: none;
    border: none;
    padding: 0.25rem;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.15s ease-in-out;
}

.btn-close:hover {
    opacity: 0.75;
}

.btn-close:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
}

/* Position variants */
.alert.position-fixed,
.alert.position-absolute {
    max-width: 400px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* Animation for dismiss */
.alert.fade {
    transition: opacity 0.15s linear;
}

.alert.fade:not(.show) {
    opacity: 0;
}

/* High contrast mode support */
.high-contrast .alert {
    border-width: 2px;
}

.high-contrast .alert-success {
    background-color: #d4edda;
    border-color: #28a745;
}

.high-contrast .alert-info {
    background-color: #d1ecf1;
    border-color: #17a2b8;
}

.high-contrast .alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
}

.high-contrast .alert-danger {
    background-color: #f8d7da;
    border-color: #dc3545;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .alert.fade {
        transition: none;
    }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .alert.position-fixed,
    .alert.position-absolute {
        left: 1rem;
        right: 1rem;
        max-width: none;
    }
}
</style>

{{-- JavaScript for notification management --}}
<script>
function dismissNotification(notificationId) {
    const notification = document.getElementById(notificationId);
    if (notification) {
        notification.classList.remove('show');
        setTimeout(function() {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 150); // Match CSS transition duration
    }
}

// Global function for showing dynamic notifications
function showDynamicNotification(type, title, message, timeout = 5000) {
    const container = document.getElementById('notification-container') || createNotificationContainer();
    
    const notificationId = 'notification-' + Date.now();
    const notification = document.createElement('div');
    notification.className = 'alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 end-0 m-3 z-3';
    notification.id = notificationId;
    notification.setAttribute('role', 'alert');
    notification.setAttribute('aria-live', 'polite');
    
    notification.innerHTML = `
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                ${title ? '<h5 class="alert-heading mb-2">' + title + '</h5>' : ''}
                ${message ? '<p class="mb-0">' + message + '</p>' : ''}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi notifica">
                <svg class="icon icon-sm"><use href="#it-close"></use></svg>
            </button>
        </div>
    `;
    
    container.appendChild(notification);
}

function createNotificationContainer() {
    const container = document.createElement('div');
    container.id = 'notification-container';
    container.className = 'position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}
</script>

{{-- 
Usage Examples:

1. Basic notification:
<x-notifiche 
    type="success"
    title="Success!"
    message="Operation completed successfully"
/>

2. Info notification with icon:
<x-notifiche 
    type="info"
    title="Information"
    message="This is an informational message"
    icon="info-circle"
/>

3. Warning notification:
<x-notifiche 
    type="warning"
    title="Warning"
    message="Please check your input"
    icon="exclamation-triangle"
/>

4. Danger notification:
<x-notifiche 
    type="danger"
    title="Error"
    message="Something went wrong"
    icon="times-circle"
/>

5. Non-dismissible notification:
<x-notifiche 
    type="info"
    title="Important"
    message="This message cannot be dismissed"
    :dismissible="false"
/>

6. Auto-dismiss notification:
<x-notifiche 
    type="success"
    title="Auto-dismiss"
    message="This will disappear in 5 seconds"
    :timeout="5000"
/>

7. Fixed position notification:
<x-notifiche 
    type="info"
    title="Fixed Position"
    message="This appears in the top-right corner"
    position="fixed"
/>

8. Different sizes:
<x-notifiche 
    type="info"
    title="Small"
    message="Small notification"
    size="sm"
/>

<x-notifiche 
    type="info"
    title="Large"
    message="Large notification"
    size="lg"
/>

9. Custom content with slot:
<x-notifiche 
    type="info"
    title="Custom Content"
>
    <p>This is custom content in the notification.</p>
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
    </ul>
</x-notifiche>

10. Dynamic notifications with JavaScript:
<button onclick="showDynamicNotification('success', 'Success!', 'Dynamic notification created')">
    Show Success
</button>

<button onclick="showDynamicNotification('warning', 'Warning!', 'Dynamic warning message')">
    Show Warning
</button>

Accessibility Features:
- Proper ARIA attributes (role="alert", aria-live="polite")
- Screen reader friendly
- Keyboard accessible dismiss button
- High contrast mode support
- Semantic HTML structure

AGID Design System Compliance:
- Uses official AGID color palette
- Follows Italian PA design guidelines
- Bootstrap Italia compatible styling
- Mobile-first responsive design
- Consistent with government standards

Performance Considerations:
- Lightweight CSS-only animations
- Efficient DOM manipulation
- Auto-cleanup for dismissed notifications
- Optimized for mobile devices
- Reduced motion support
--}}
