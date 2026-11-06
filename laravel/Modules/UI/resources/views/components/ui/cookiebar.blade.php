<?php

declare(strict_types=1);
?>
@props([
    'showCookieBar' => true,
    'policyUrl' => '#',
    'privacyPolicyUrl' => '#',
    'acceptText' => __('ui::components_ui.cookiebar.accept_all.label'),
    'rejectText' => __('ui::components_ui.cookiebar.reject_all.label'),
    'customizeText' => __('ui::components_ui.cookiebar.customize.label'),
])

@if($showCookieBar)
<div id="cookie-bar" class="ui-cookiebar fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <!-- Cookie Message -->
            <div class="flex-1">
                <p class="text-sm text-gray-700 mb-2">
                    <strong>{{ __('ui::components_ui.cookiebar.notice.title') }}</strong>
                </p>
                <p class="text-sm text-gray-600">
                    {{ __('ui::components_ui.cookiebar.notice.description') }}
                    <a href="{{ $privacyPolicyUrl }}" class="text-primary-600 hover:text-primary-700 font-medium ml-1">
                        {{ __('ui::components_common.actions.learn_more.label') }}
                    </a>
                </p>
            </div>
            
            <!-- Cookie Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button 
                    type="button"
                    @click="$wire.acceptAllCookies()"
                    class="px-6 py-2 bg-primary-600 text-white rounded-lg font-medium hover:bg-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500"
                >
                    {{ $acceptText }}
                </button>
                
                <button 
                    type="button"
                    @click="$wire.rejectAllCookies()"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500"
                >
                    {{ $rejectText }}
                </button>
                
                <button 
                    type="button"
                    @click="$wire.showCookiePreferences()"
                    class="px-6 py-2 text-primary-600 rounded-lg font-medium hover:text-primary-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500"
                >
                    {{ $customizeText }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-hide after scroll (optional)
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        let cookieBar = document.getElementById('cookie-bar');
        
        if (cookieBar) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                cookieBar.style.transform = 'translateY(100%)';
                cookieBar.style.transition = 'transform 0.3s ease';
            } else {
                cookieBar.style.transform = 'translateY(0)';
                cookieBar.style.transition = 'transform 0.3s ease';
            }
        }
        
        lastScrollTop = scrollTop;
    });
</script>
@endif

<style>
.ui-cookiebar {
    transition: transform 0.3s ease;
}

@media (max-width: 768px) {
    .ui-cookiebar {
        padding: 1rem;
    }
}
</style>