<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('login2');
?>

<x-layouts.guest>
    <x-slot name="title">
        {{ __('auth.login.title') }} - {{ config('app.name') }}
    </x-slot>

    <x-slot name="meta">
        <meta name="description" content="{{ __('auth.login.meta_description') }}">
        <meta name="robots" content="noindex, nofollow">
    </x-slot>

    <!-- AGID-Compliant Login Container -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Skip Links for Accessibility (WCAG 2.1 AA) -->
        <div class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-50">
            <a href="#main-content" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ __('accessibility.skip_to_main_content') }}
            </a>
        </div>

        <!-- Main Login Container - Wider and More Professional -->
        <div class="max-w-2xl w-full space-y-8" id="main-content" role="main">
            
            <!-- AGID Institutional Header -->
            <div class="text-center">
                <!-- Institution Logo -->
                <div class="flex justify-center mb-6">
                    <x-pub_theme::ui.logo 
                    <x-pub_theme::ui.logo 
                        class="h-16 w-auto text-blue-600" 
                        alt="{{ config('app.institution_name', 'Logo Istituzionale') }}"
                    />
                </div>
                
                <!-- Institution Name -->
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ config('app.institution_name', 'Ente di appartenenza') }}
                </h1>
                
                <!-- Service Title -->
                <h2 class="text-lg font-semibold text-blue-600 mb-1">
                    {{ __('auth.login.service_title', ['service' => config('app.name')]) }}
                </h2>
                
                <!-- Service Description -->
                <p class="text-sm text-gray-600 mb-8">
                    {{ __('auth.login.service_description') }}
                </p>
            </div>

            <!-- AGID-Compliant Login Card - Wider Layout -->
            <div class="bg-white shadow-xl rounded-lg border border-gray-200 overflow-hidden max-w-4xl mx-auto">
                
                <!-- Card Header with AGID Colors -->
                <div class="bg-blue-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('auth.login.card_title') }}
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">
                        {{ __('auth.login.card_subtitle') }}
                    </p>
                </div>

                <!-- Card Body with Livewire Component (MANDATORY - DO NOT MODIFY) -->
                <div class="px-6 py-8">
                    @livewire(\Modules\User\Http\Livewire\Auth\Login::class)
                </div>

                <!-- Card Footer with AGID Information -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    
                    <!-- Technical Support Info -->
                    <div class="text-center mb-4">
                        <p class="text-xs text-gray-600 mb-2">
                            {{ __('auth.login.support_text') }}
                        </p>
                        @if(config('app.support_email'))
                            <a href="mailto:{{ config('app.support_email') }}" 
                               class="text-blue-600 hover:text-blue-800 text-xs font-medium underline">
                                {{ config('app.support_email') }}
                            </a>
                        @endif
                        @if(config('app.support_phone'))
                            <span class="text-gray-400 mx-2">•</span>
                            <a href="tel:{{ config('app.support_phone') }}" 
                               class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                {{ config('app.support_phone') }}
                            </a>
                        @endif
                    </div>

                    <!-- Accessibility and Legal Links -->
                    <div class="flex flex-wrap justify-center items-center text-xs text-gray-500 space-x-4">
                        <a href="{{ route('pages.view', ['slug' => 'privacy']) }}" 
                           class="hover:text-blue-600 underline">
                            {{ __('footer.privacy_policy') }}
                        </a>
                        <a href="{{ route('pages.view', ['slug' => 'accessibility']) }}" 
                           class="hover:text-blue-600 underline">
                            {{ __('footer.accessibility_statement') }}
                        </a>
                        <a href="{{ route('pages.view', ['slug' => 'legal-notes']) }}" 
                           class="hover:text-blue-600 underline">
                            {{ __('footer.legal_notes') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Registration Link (if enabled) -->
            @if (Route::has('register'))
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        {{ __('auth.login.no_account') }}
                        <a href="{{ route('register') }}" 
                           class="text-blue-600 hover:text-blue-800 underline font-medium ml-1">
                            {{ __('auth.login.create_account') }}
                        </a>
                    </p>
                </div>
            @endif

            <!-- SPID/CIE Integration (if available) -->
            @if(config('auth.spid_enabled') || config('auth.cie_enabled'))
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-center text-sm font-medium text-gray-700 mb-4">
                        {{ __('auth.login.alternative_methods') }}
                    </h4>
                    
                    <div class="flex justify-center space-x-4">
                        @if(config('auth.spid_enabled'))
                            <a href="{{ route('spid.login') }}" 
                               class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <img src="{{ asset('themes/Sixteen/resources/images/spid-logo.svg') }}" 
                                     alt="SPID" class="h-5 w-auto mr-2">
                                {{ __('auth.login.spid_login') }}
                            </a>
                        @endif
                        
                        @if(config('auth.cie_enabled'))
                            <a href="{{ route('cie.login') }}" 
                               class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <img src="{{ asset('themes/Sixteen/resources/images/cie-logo.svg') }}" 
                                     alt="CIE" class="h-5 w-auto mr-2">
                                {{ __('auth.login.cie_login') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- AGID Compliance Badge -->
            <div class="text-center mt-8">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('agid.compliance_badge') }}
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            /* AGID-Compliant Custom Styles */
            :root {
                --agid-primary: #0066CC;
                --agid-primary-dark: #004080;
                --agid-primary-light: #CCE6FF;
                --agid-secondary: #5A6772;
                --agid-light-grey: #F5F5F5;
            }

            /* Focus Management for Accessibility */
            *:focus {
                outline: 2px solid var(--agid-primary);
                outline-offset: 2px;
            }

            /* AGID Typography Enhancement */
            body {
                font-family: 'Titillium Web', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            /* Enhanced Button Styles */
            .btn-agid-primary {
                background-color: var(--agid-primary);
                border-color: var(--agid-primary);
                color: white;
                transition: all 0.2s ease-in-out;
            }

            .btn-agid-primary:hover {
                background-color: var(--agid-primary-dark);
                border-color: var(--agid-primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 102, 204, 0.3);
            }

            /* Loading State Animation */
            .loading-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* Responsive Enhancements */
            @media (max-width: 640px) {
                .login-container {
                    padding: 1rem;
                }
            }

            /* High Contrast Mode Support */
            @media (prefers-contrast: high) {
                .bg-blue-600 {
                    background-color: #000080;
                }
                
                .text-blue-600 {
                    color: #000080;
                }
            }

            /* Reduced Motion Support */
            @media (prefers-reduced-motion: reduce) {
                * {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // AGID-Compliant Focus Management
                const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
                const modal = document.querySelector('#main-content');
                
                if (modal) {
                    const firstFocusableElement = modal.querySelectorAll(focusableElements)[0];
                    const focusableContent = modal.querySelectorAll(focusableElements);
                    const lastFocusableElement = focusableContent[focusableContent.length - 1];

                    // Set initial focus
                    if (firstFocusableElement) {
                        firstFocusableElement.focus();
                    }

                    // Trap focus within login form
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Tab') {
                            if (e.shiftKey) {
                                if (document.activeElement === firstFocusableElement) {
                                    lastFocusableElement.focus();
                                    e.preventDefault();
                                }
                            } else {
                                if (document.activeElement === lastFocusableElement) {
                                    firstFocusableElement.focus();
                                    e.preventDefault();
                                }
                            }
                        }
                    });
                }

                // Enhanced Error Handling with ARIA Live Regions
                const errorContainer = document.createElement('div');
                errorContainer.setAttribute('aria-live', 'polite');
                errorContainer.setAttribute('aria-atomic', 'true');
                errorContainer.className = 'sr-only';
                document.body.appendChild(errorContainer);

                // Form Validation Enhancement
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const submitButton = form.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __("auth.login.processing") }}';
                            
                            // Re-enable after timeout to prevent permanent disable
                            setTimeout(() => {
                                submitButton.disabled = false;
                                submitButton.innerHTML = '{{ __("auth.login.submit") }}';
                            }, 10000);
                        }
                    });
                });

                // Accessibility Announcements
                window.announceToScreenReader = function(message) {
                    errorContainer.textContent = message;
                    setTimeout(() => {
                        errorContainer.textContent = '';
                    }, 1000);
                };

                // Auto-clear flash messages
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(message => {
                    setTimeout(() => {
                        message.style.opacity = '0';
                        setTimeout(() => {
                            message.remove();
                        }, 300);
                    }, 5000);
                });
            });
        </script>
    @endpush
</x-layouts.guest>
