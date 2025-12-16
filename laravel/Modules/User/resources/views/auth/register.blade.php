<?php

declare(strict_types=1);

?>
@php
$title = 'Registrazione - ';
@endphp

<x-layouts.marketing :title="$title">
    <div class="wave-bg min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        {{-- Onde decorative animate --}}
        <div class="wave w-96 h-96 -left-20 bottom-20 transform rotate-45 animate-wave"></div>
        <div class="wave w-80 h-80 right-10 bottom-36 transform -rotate-12 animate-wave-delay"></div>
        <div class="wave w-64 h-64 left-10 bottom-40 transform rotate-30 animate-wave-delay-2"></div>

        {{-- Punti luminosi animati --}}
        <div class="absolute bottom-1/4 right-1/3 w-3 h-3 bg-blue-300 rounded-full blur-sm animate-pulse"></div>
        <div class="absolute bottom-1/5 left-1/3 w-2 h-2 bg-blue-300 rounded-full blur-sm animate-pulse-delay"></div>

        {{-- Logo e Titolo con animazione --}}
        <div class="text-white text-center z-10 mb-8 transform transition-all duration-500 hover:scale-105">
            <h1 class="logo-text text-4xl sm:text-5xl tracking-wider mb-2">
                <span class="inline-block transform transition-transform duration-300 hover:scale-110">S</span>ALUTE
                <span class="inline-block transform transition-transform duration-300 hover:scale-110">O</span>RA
                <span class="orale-text text-3xl sm:text-4xl">le</span>
            </h1>
            <p class="text-blue-200 text-lg animate-fade-in">Crea il tuo account</p>
        </div>

        {{-- Form di Registrazione con animazione --}}
        <div class="w-full max-w-md bg-white/10 backdrop-blur-sm rounded-lg shadow-xl p-8 z-10 transform transition-all duration-500 hover:shadow-2xl">
            <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{
                showPassword: false,
                showConfirmPassword: false,
                formValid: false,
                checkForm() {
                    this.formValid = this.$refs.form.checkValidity();
                }
            }" x-init="checkForm" @input="checkForm">
                @csrf

                {{-- Nome con animazione --}}
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <x-input-label for="name" :value="__('Nome')" class="text-white" />
                    <x-text-input id="name" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200 transition-all duration-300 focus:bg-white/30" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email con animazione --}}
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200 transition-all duration-300 focus:bg-white/30" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password con toggle --}}
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <div class="relative">
                        <x-text-input id="password" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200 transition-all duration-300 focus:bg-white/30"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            required />
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path x-show="showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Conferma Password con toggle --}}
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <x-input-label for="password_confirmation" :value="__('Conferma Password')" class="text-white" />
                    <div class="relative">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200 transition-all duration-300 focus:bg-white/30"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            name="password_confirmation"
                            required />
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path x-show="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path x-show="showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Pulsante Registrazione con animazione --}}
                <div class="flex items-center justify-end">
                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white transform transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!formValid">
                        {{ __('Registrati') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Link Login con animazione --}}
            <div class="mt-6 text-center">
                <p class="text-blue-200">
                    {{ __('Hai già un account?') }}
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-300 underline transform transition-all duration-300 hover:scale-105">
                        {{ __('Accedi') }}
                    </a>
                </p>
            </div>
        </div>

        {{-- SVG Background Animation --}}
        <div class="fixed bottom-0 left-0 w-full h-24 z-[-1] opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <path fill="#004481" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    <animate attributeName="d"
                        dur="10s"
                        repeatCount="indefinite"
                        values="
                            M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                            M0,160L48,149.3C96,139,192,117,288,122.7C384,128,480,160,576,176C672,192,768,192,864,197.3C960,203,1056,213,1152,202.7C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;
                            M0,192L48,176C96,160,192,128,288,128C384,128,480,160,576,165.3C672,171,768,149,864,154.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                    />
                </path>
            </svg>
        </div>
    </div>
</x-layouts.marketing>

@push('styles')
<style>
    .wave-bg {
        background: linear-gradient(to bottom, #002855 40%, #00387a 100%);
        position: relative;
        overflow: hidden;
    }

    .wave {
        position: absolute;
        opacity: 0.2;
        background: linear-gradient(to right, #0056b3, #007bff);
        border-radius: 50%;
    }

    @keyframes wave {
        0% { transform: scale(1) rotate(45deg); }
        50% { transform: scale(1.1) rotate(45deg); }
        100% { transform: scale(1) rotate(45deg); }
    }

    @keyframes wave-delay {
        0% { transform: scale(1) rotate(-12deg); }
        50% { transform: scale(1.1) rotate(-12deg); }
        100% { transform: scale(1) rotate(-12deg); }
    }

    @keyframes wave-delay-2 {
        0% { transform: scale(1) rotate(30deg); }
        50% { transform: scale(1.1) rotate(30deg); }
        100% { transform: scale(1) rotate(30deg); }
    }

    .animate-wave {
        animation: wave 8s ease-in-out infinite;
    }

    .animate-wave-delay {
        animation: wave-delay 8s ease-in-out infinite 2s;
    }

    .animate-wave-delay-2 {
        animation: wave-delay-2 8s ease-in-out infinite 4s;
    }

    @keyframes pulse {
        0% { opacity: 0.5; }
        50% { opacity: 1; }
        100% { opacity: 0.5; }
    }

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    .animate-pulse-delay {
        animation: pulse 2s ease-in-out infinite 1s;
    }

    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }

    .logo-text {
        font-family: 'Georgia', serif;
    }

    .orale-text {
        font-style: italic;
    }

    input::placeholder {
        color: rgba(191, 219, 254, 0.7);
    }

    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
</style>
@endpush
