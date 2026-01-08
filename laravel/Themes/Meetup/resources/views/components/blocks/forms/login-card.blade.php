@props([
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere all\'area riservata',
    // 'livewireComponent' => '\Modules\User\Http\Livewire\Auth\Login'
    'livewireComponent' => Modules\User\Http\Livewire\Auth\Login::class,
])

<!-- Beautiful Login Card -->
<div class="login-card-beautiful fade-in-scale">
    
    <!-- Beautiful Header Card -->
    <div class="login-card-header text-white px-8 py-6">
        <div class="flex items-center relative z-10">
            <div class="login-icon mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1 drop-shadow-sm">{{ $title }}</h2>
                <p class="text-blue-100 text-sm drop-shadow-sm">{{ $subtitle }}</p>
            </div>
        </div>
    </div>
    
    <!-- Body Card -->
    <div class="px-6 py-8">
        <!-- Livewire Login Component -->
        @livewire($livewireComponent)
        @livewire($livewireComponent)
    </div>
    
    <!-- Footer Card con Assistenza -->
    <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
        <div class="text-center">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 110 19.5 9.75 9.75 0 010-19.5z"></path>
                </svg>
                {{ __('Hai bisogno di aiuto?') }}
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <!-- Telefono -->
                <div class="flex items-center justify-center p-3 bg-white rounded-lg border border-gray-200 hover:border-primary-300 transition-colors">
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">{{ __('Telefono') }}</p>
                        <a href="tel:+390123456789" class="text-primary-600 hover:text-primary-800 font-semibold">
                            01 2345 6789
                        </a>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="flex items-center justify-center p-3 bg-white rounded-lg border border-gray-200 hover:border-primary-300 transition-colors">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">{{ __('Email') }}</p>
                        <a href="mailto:supporto@fixcity.gov.it" class="text-primary-600 hover:text-primary-800">
                            supporto@fixcity.gov.it
                        </a>
                    </div>
                </div>
            </div>
            
            <p class="text-xs text-gray-500 mt-3 flex items-center justify-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Orari: Lun-Ven 9:00-17:00 | Sab 9:00-13:00') }}
            </p>
        </div>
    </div>
</div>
