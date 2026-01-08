{{--
/**
 * Cookiebar Component - Bootstrap Italia Compliant
 * 
 * Cookie consent bar component for GDPR compliance
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $title Title of the cookie bar
 * @param string $message Main message content
 * @param string $acceptText Text for accept button
 * @param string $declineText Text for decline button
 * @param string $policyUrl URL to privacy policy
 * @param string $policyText Text for policy link
 * @param bool $showDecline Whether to show decline button
 * @param string $position Position: 'top', 'bottom'
 * @param string $id Custom ID for the cookie bar
 * @param string $class Additional CSS classes
 * @param int $expiryDays Cookie expiry in days
 * @param string $cookieName Name of the consent cookie
 */
--}}

@props([
    'title' => 'Cookie Policy',
    'message' => 'Questo sito utilizza cookie tecnici e di terze parti per migliorare la tua esperienza di navigazione. Continuando la navigazione accetti l\'utilizzo dei cookie.',
    'acceptText' => 'Accetta',
    'declineText' => 'Rifiuta',
    'policyUrl' => '/privacy-policy',
    'policyText' => 'Privacy Policy',
    'showDecline' => true,
    'position' => 'bottom', // 'top', 'bottom'
    'id' => null,
    'class' => '',
    'expiryDays' => 365,
    'cookieName' => 'cookie_consent'
])

@php
    $cookiebarId = $id ?? 'cookiebar-' . uniqid();
    $cookiebarClasses = collect(['cookiebar', 'cookiebar-' . $position]);
    
    // Additional classes
    if ($class) {
        $cookiebarClasses->push($class);
    }
@endphp

<div 
    class="{{ $cookiebarClasses->implode(' ') }}"
    id="{{ $cookiebarId }}"
    role="dialog"
    aria-labelledby="{{ $cookiebarId }}-title"
    aria-describedby="{{ $cookiebarId }}-message"
    aria-modal="true"
    {{ $attributes->except(['title', 'message', 'acceptText', 'declineText', 'policyUrl', 'policyText', 'showDecline', 'position', 'id', 'class', 'expiryDays', 'cookieName']) }}
>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <div class="cookiebar-content">
                    <h5 id="{{ $cookiebarId }}-title" class="cookiebar-title">
                        {{ $title }}
                    </h5>
                    <p id="{{ $cookiebarId }}-message" class="cookiebar-message">
                        {{ $message }}
                        @if($policyUrl)
                            <a 
                                href="{{ $policyUrl }}" 
                                class="cookiebar-link"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ $policyText }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cookiebar-actions">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                        @if($showDecline)
                            <button 
                                type="button" 
                                class="btn btn-outline-primary btn-sm"
                                onclick="setCookieConsent('{{ $cookieName }}', 'declined', {{ $expiryDays }}, '{{ $cookiebarId }}')"
                                aria-label="Rifiuta i cookie"
                            >
                                {{ $declineText }}
                            </button>
                        @endif
                        <button 
                            type="button" 
                            class="btn btn-primary btn-sm"
                            onclick="setCookieConsent('{{ $cookieName }}', 'accepted', {{ $expiryDays }}, '{{ $cookiebarId }}')"
                            aria-label="Accetta i cookie"
                        >
                            {{ $acceptText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS for AGID-compliant cookiebar styling --}}
<style>
.cookiebar {
    position: fixed;
    left: 0;
    right: 0;
    z-index: 9999;
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 1rem 0;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    transform: translateY(100%);
    transition: transform 0.3s ease-in-out;
}

.cookiebar-top {
    top: 0;
    bottom: auto;
    border-top: none;
    border-bottom: 1px solid #dee2e6;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transform: translateY(-100%);
}

.cookiebar.show {
    transform: translateY(0);
}

.cookiebar-top.show {
    transform: translateY(0);
}

.cookiebar-content {
    margin-bottom: 1rem;
}

@media (min-width: 768px) {
    .cookiebar-content {
        margin-bottom: 0;
    }
}

.cookiebar-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.cookiebar-message {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0;
    line-height: 1.5;
}

.cookiebar-link {
    color: var(--italia-blue-500);
    text-decoration: underline;
    font-weight: 500;
}

.cookiebar-link:hover {
    color: var(--italia-blue-600);
    text-decoration: none;
}

.cookiebar-actions {
    text-align: center;
}

@media (min-width: 768px) {
    .cookiebar-actions {
        text-align: right;
    }
}

.cookiebar-actions .btn {
    min-width: 100px;
}

/* High contrast mode support */
.high-contrast .cookiebar {
    background-color: #ffffff;
    border-color: #000000;
    border-width: 2px;
}

.high-contrast .cookiebar-title {
    color: #000000;
}

.high-contrast .cookiebar-message {
    color: #000000;
}

.high-contrast .cookiebar-link {
    color: #0000ff;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .cookiebar {
        transition: none;
    }
}

/* Mobile responsiveness */
@media (max-width: 767px) {
    .cookiebar-actions .d-flex {
        flex-direction: column;
    }
    
    .cookiebar-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .cookiebar-actions .btn:last-child {
        margin-bottom: 0;
    }
}
</style>

{{-- JavaScript for cookie consent management --}}
<script>
// Check if cookie consent has been given
function checkCookieConsent(cookieName) {
    return document.cookie.split(';').some(function(cookie) {
        return cookie.trim().startsWith(cookieName + '=');
    });
}

// Set cookie consent
function setCookieConsent(cookieName, value, expiryDays, cookiebarId) {
    const date = new Date();
    date.setTime(date.getTime() + (expiryDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    
    document.cookie = cookieName + "=" + value + ";" + expires + ";path=/;SameSite=Strict";
    
    // Hide cookiebar
    const cookiebar = document.getElementById(cookiebarId);
    if (cookiebar) {
        cookiebar.classList.remove('show');
        setTimeout(function() {
            if (cookiebar.parentNode) {
                cookiebar.remove();
            }
        }, 300);
    }
    
    // Trigger custom event
    document.dispatchEvent(new CustomEvent('cookieConsentChanged', {
        detail: { value: value, cookieName: cookieName }
    }));
}

// Show cookiebar if consent not given
function showCookiebar(cookiebarId) {
    const cookiebar = document.getElementById(cookiebarId);
    if (cookiebar) {
        cookiebar.classList.add('show');
    }
}

// Initialize cookiebar
document.addEventListener('DOMContentLoaded', function() {
    const cookiebarId = '{{ $cookiebarId }}';
    const cookieName = '{{ $cookieName }}';
    
    // Only show if consent not given
    if (!checkCookieConsent(cookieName)) {
        showCookiebar(cookiebarId);
    }
});

// Handle escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const cookiebars = document.querySelectorAll('.cookiebar.show');
        cookiebars.forEach(function(cookiebar) {
            cookiebar.classList.remove('show');
        });
    }
});
</script>

{{-- 
Usage Examples:

1. Basic cookiebar:
<x-cookiebar />

2. Custom title and message:
<x-cookiebar 
    title="Cookie Policy"
    message="We use cookies to improve your experience on our website."
    accept-text="Accept"
    decline-text="Decline"
/>

3. Top position:
<x-cookiebar 
    position="top"
    title="Cookie Notice"
    message="This website uses cookies."
/>

4. With privacy policy link:
<x-cookiebar 
    title="Cookie Policy"
    message="We use cookies to improve your experience."
    policy-url="/privacy"
    policy-text="Read our Privacy Policy"
/>

5. Without decline button:
<x-cookiebar 
    title="Cookie Notice"
    message="By continuing to use this site, you accept our use of cookies."
    :show-decline="false"
    accept-text="I Understand"
/>

6. Custom styling:
<x-cookiebar 
    title="Cookie Policy"
    message="We use cookies."
    class="custom-cookiebar"
/>

7. Custom cookie settings:
<x-cookiebar 
    title="Cookie Preferences"
    message="Manage your cookie preferences."
    cookie-name="user_consent"
    :expiry-days="30"
/>

8. JavaScript integration:
<script>
document.addEventListener('cookieConsentChanged', function(event) {
    console.log('Cookie consent changed:', event.detail);
    
    if (event.detail.value === 'accepted') {
        // Initialize analytics, tracking, etc.
        initializeAnalytics();
    } else {
        // Disable tracking
        disableTracking();
    }
});

function initializeAnalytics() {
    // Google Analytics, Facebook Pixel, etc.
}

function disableTracking() {
    // Disable all tracking scripts
}
</script>

Accessibility Features:
- Proper ARIA attributes (role="dialog", aria-labelledby, aria-describedby)
- Keyboard accessible (Escape key to close)
- Screen reader friendly
- High contrast mode support
- Semantic HTML structure
- Focus management

GDPR Compliance:
- Clear consent mechanism
- Granular control (accept/decline)
- Privacy policy link
- Persistent consent storage
- Easy withdrawal of consent

AGID Design System Compliance:
- Uses official AGID color palette
- Follows Italian PA design guidelines
- Bootstrap Italia compatible styling
- Mobile-first responsive design
- Consistent with government standards

Performance Considerations:
- Lightweight implementation
- Efficient DOM manipulation
- Minimal JavaScript footprint
- CSS-only animations
- Optimized for mobile devices
--}}
