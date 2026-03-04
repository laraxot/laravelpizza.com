# Marketing Components Implementation - UI Module

**Date**: February 6, 2026
**Status**: Planning Phase
**Priority**: High

---

## Overview

This document outlines the marketing components that need to be implemented in the UI Module to support SEO, lead generation, and monetization features.

---

## Component Architecture

### Component Hierarchy

```
Modules/UI/resources/views/components/
├── ads/
│   ├── sense.blade.php
│   ├── leaderboard.blade.php
│   ├── sidebar.blade.php
│   └── footer.blade.php
├── popups/
│   ├── exit-intent.blade.php
│   ├── lead-magnet.blade.php
│   └── newsletter.blade.php
├── forms/
│   ├── lead-capture.blade.php
│   ├── lead-magnet-download.blade.php
│   └── newsletter-subscribe.blade.php
├── seo/
│   ├── meta-tags.blade.php
│   ├── schema-markup.blade.php
│   └── structured-data.blade.php
└── social/
    ├── share-buttons.blade.php
    ├── follow-links.blade.php
    └── social-proof.blade.php
```

---

## Component Specifications

### 1. AdSense Components

#### 1.1 Leaderboard Ad (728x90)

**File**: `resources/views/components/ads/leaderboard.blade.php`

```blade
@props([
    'slotId' => null,
    'clientId' => config('analytics.adsense.client_id'),
])

<div class="w-full flex justify-center my-8" aria-label="Advertisement">
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="{{ $clientId }}"
         @if($slotId)
         data-ad-slot="{{ $slotId }}"
         @endif
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
</div>

@once
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
@endonce
```

**Usage**:
```blade
<x-ui.ads.leaderboard slotId="1234567890" />
```

#### 1.2 Sidebar Ad (300x250)

**File**: `resources/views/components/ads/sidebar.blade.php`

```blade
@props([
    'slotId' => null,
    'clientId' => config('analytics.adsense.client_id'),
])

<div class="w-[300px] h-[250px] mx-auto" aria-label="Advertisement">
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:250px"
         data-ad-client="{{ $clientId }}"
         @if($slotId)
         data-ad-slot="{{ $slotId }}"
         @endif></ins>
</div>

@once
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
@endonce
```

#### 1.3 Responsive Ad

**File**: `resources/views/components/ads/sense.blade.php`

```blade
@props([
    'slotId' => null,
    'clientId' => config('analytics.adsense.client_id'),
    'position' => 'below-fold', // above-fold, below-fold, sidebar, footer
])

<div class="ad-container ad-{{ $position }} flex justify-center my-8" 
     aria-label="Advertisement">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ $clientId }}"
         @if($slotId)
         data-ad-slot="{{ $slotId }}"
         @endif
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
</div>

@once
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
@endonce

@push('styles')
<style>
    .ad-above-fold { margin-top: 2rem; }
    .ad-below-fold { margin: 3rem 0; }
    .ad-sidebar { margin: 2rem 0; }
    .ad-footer { margin: 2rem auto; max-width: 728px; }
</style>
@endpush
```

---

### 2. Popup Components

#### 2.1 Exit-Intent Popup

**File**: `resources/views/components/popups/exit-intent.blade.php`

```blade
@props([
    'title' => 'Non andare via senza questo regalo!',
    'description' => 'Iscriviti ora e ricevi la nostra guida gratuita sulla radioprotezione.',
    'discountCode' => 'RADIO10',
    'ctaLabel' => 'Ricevi la Guida Gratuitamente',
    'delay' => 0, // milliseconds
])

<div 
    x-data="{ 
        show: false, 
        hasShown: {{ $delay > 0 ? 'false' : 'true' }},
        close() { this.show = false; localStorage.setItem('exit-intent-shown', 'true'); },
        trigger() { 
            if (!localStorage.getItem('exit-intent-shown') && !this.hasShown) {
                this.show = true; 
                this.hasShown = true;
            }
        }
    }"
    @mouseout.window="if($event.clientY < 0) trigger()"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="exit-intent-title"
>
    <div 
        @click.away="close()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden"
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#1E5A96] to-[#2D8659] p-6 text-white relative">
            <button 
                @click="close()"
                class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors"
                aria-label="Chiudi"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <div>
                    <h3 id="exit-intent-title" class="text-xl font-bold">{{ $title }}</h3>
                    <p class="text-sm text-white/80">Offerta limitata</p>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-6">
            <p class="text-gray-700 mb-6">{{ $description }}</p>
            
            <!-- Discount Badge -->
            <div class="bg-[#E67E22]/10 border-2 border-dashed border-[#E67E22] rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Codice Sconto</p>
                        <p class="text-2xl font-bold text-[#E67E22]">{{ $discountCode }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Sconto</p>
                        <p class="text-xl font-bold text-[#2E7D32]">-10%</p>
                    </div>
                </div>
            </div>
            
            <!-- Lead Magnet Form -->
            <form wire:submit="submitExitIntent" class="space-y-4">
                <x-ui.input 
                    name="email" 
                    label="Email" 
                    type="email" 
                    required 
                    placeholder="nome@esempio.com"
                />
                
                <button 
                    type="submit"
                    class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ $ctaLabel }}
                </button>
            </form>
            
            <!-- Trust Indicators -->
            <div class="mt-6 flex items-center justify-center gap-4 text-xs text-gray-500">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-[#2E7D32]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Niente spam</span>
                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-[#2E7D32]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Disiscrizione facile</span>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Usage**:
```blade
<x-ui.popups.exit-intent 
    title="Non andare via senza questo regalo!"
    description="Iscriviti ora e ricevi la nostra guida gratuita sulla radioprotezione."
    discountCode="RADIO10"
    ctaLabel="Ricevi la Guida Gratuitamente"
/>
```

#### 2.2 Lead Magnet Popup

**File**: `resources/views/components/popups/lead-magnet.blade.php`

```blade
@props([
    'title' => 'Guida Gratuita: Radioprotezione Odontoiatrica',
    'description' => 'Scarica la guida completa e scopri tutti gli obblighi di legge.',
    'leadMagnetId' => null,
    'coverImage' => null,
    'ctaLabel' => 'Scarica Gratuitamente',
])

<div 
    x-data="{ show: false, close() { this.show = false; } }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
    role="dialog"
    aria-modal="true"
>
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden flex flex-col md:flex-row">
        <!-- Left: Cover Image -->
        @if($coverImage)
        <div class="md:w-1/2 bg-gradient-to-br from-[#1E5A96] to-[#2D8659] p-8 flex items-center justify-center">
            <img 
                src="{{ $coverImage }}" 
                alt="{{ $title }}"
                class="max-w-xs rounded-lg shadow-xl transform -rotate-3 hover:rotate-0 transition-transform duration-300"
            >
        </div>
        @endif
        
        <!-- Right: Content -->
        <div class="md:w-1/2 p-8 relative">
            <button 
                @click="close()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                aria-label="Chiudi"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 bg-[#2E7D32]/10 text-[#2E7D32] px-3 py-1 rounded-full text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>100% Gratuito</span>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-gray-600">{{ $description }}</p>
            </div>
            
            <!-- What's Inside -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Cosa troverai dentro:</h4>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-[#2E7D32] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Guida completa agli obblighi di legge</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-[#2E7D32] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Checklist per la conformità D.Lgs 101/2020</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-[#2E7D32] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Template di documentazione pronti all'uso</span>
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-[#2E7D32] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Consigli pratici per la sicurezza</span>
                    </li>
                </ul>
            </div>
            
            <!-- Download Form -->
            <form wire:submit="submitLeadMagnet" class="space-y-4">
                <x-ui.input 
                    name="email" 
                    label="Email" 
                    type="email" 
                    required 
                    placeholder="nome@esempio.com"
                />
                
                <x-ui.input 
                    name="studio_name" 
                    label="Nome Studio" 
                    type="text" 
                    placeholder="Nome del tuo studio"
                />
                
                <button 
                    type="submit"
                    class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ $ctaLabel }}
                </button>
            </form>
            
            <!-- Privacy Note -->
            <p class="text-xs text-gray-500 text-center mt-4">
                Niente spam, solo contenuti di qualità. Puoi disiscriverti quando vuoi.
            </p>
        </div>
    </div>
</div>
```

---

### 3. Form Components

#### 3.1 Lead Capture Form

**File**: `resources/views/components/forms/lead-capture.blade.php`

```blade
@props([
    'title' => 'Rimani Aggiornato',
    'description' => 'Iscriviti alla nostra newsletter per ricevere aggiornamenti normativi e consigli pratici.',
    'ctaLabel' => 'Iscriviti',
    'showStudioName' => false,
])

<div class="bg-white rounded-2xl shadow-lg p-8">
    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-600 mb-6">{{ $description }}</p>
    
    <form wire:submit="submitNewsletter" class="space-y-4">
        <x-ui.input 
            name="email" 
            label="Email" 
            type="email" 
            required 
            placeholder="nome@esempio.com"
        />
        
        @if($showStudioName)
        <x-ui.input 
            name="studio_name" 
            label="Nome Studio" 
            type="text" 
            placeholder="Nome del tuo studio"
        />
        @endif
        
        <button 
            type="submit"
            class="w-full bg-[#1976D2] hover:bg-[#0D47A1] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
        >
            {{ $ctaLabel }}
        </button>
    </form>
    
    <div class="mt-6 flex items-center justify-center gap-4 text-xs text-gray-500">
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-[#2E7D32]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>Niente spam</span>
        </div>
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-[#2E7D32]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>Disiscrizione facile</span>
        </div>
    </div>
</div>
```

---

### 4. SEO Components

#### 4.1 Meta Tags Component

**File**: `resources/views/components/seo/meta-tags.blade.php`

```blade
@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'ogImage' => null,
    'ogType' => 'website',
    'canonical' => null,
    'noindex' => false,
    'nofollow' => false,
])

{{-- Basic Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif

@if($noindex)
<meta name="robots" content="noindex">
@endif

@if($nofollow)
<meta name="robots" content="nofollow">
@endif

@if($canonical)
<link rel="canonical" href="{{ $canonical }}">
@endif

{{-- Open Graph --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
<meta property="og:locale" content="{{ app()->getLocale() }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($ogImage)
<meta name="twitter:image" content="{{ $ogImage }}">
@endif
```

**Usage**:
```blade
<x-ui.seo.meta-tags 
    :title="$page->seo_title ?? $page->title"
    :description="$page->seo_description"
    :keywords="$page->seo_keywords"
    :canonical="$page->canonical_url"
/>
```

---

### 5. Social Components

#### 5.1 Share Buttons

**File**: `resources/views/components/social/share-buttons.blade.php`

```blade
@props([
    'title' => null,
    'url' => null,
    'description' => null,
    'showLabel' => false,
])

<div class="flex items-center gap-2">
    <a 
        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url ?? request()->url()) }}&title={{ urlencode($title) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="flex items-center gap-2 bg-[#1877F2] hover:bg-[#166FE5] text-white px-4 py-2 rounded-lg transition-colors duration-200"
        aria-label="Condividi su Facebook"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
        @if($showLabel)
        <span>Facebook</span>
        @endif
    </a>
    
    <a 
        href="https://twitter.com/intent/tweet?url={{ urlencode($url ?? request()->url()) }}&text={{ urlencode($title) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="flex items-center gap-2 bg-[#1DA1F2] hover:bg-[#0C85D0] text-white px-4 py-2 rounded-lg transition-colors duration-200"
        aria-label="Condividi su Twitter"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
        </svg>
        @if($showLabel)
        <span>Twitter</span>
        @endif
    </a>
    
    <a 
        href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url ?? request()->url()) }}"
        target="_blank"
        rel="noopener noreferrer"
        class="flex items-center gap-2 bg-[#0A66C2] hover:bg-[#004182] text-white px-4 py-2 rounded-lg transition-colors duration-200"
        aria-label="Condividi su LinkedIn"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
        </svg>
        @if($showLabel)
        <span>LinkedIn</span>
        @endif
    </a>
    
    <a 
        href="mailto:?subject={{ urlencode($title) }}&body={{ urlencode($description) }} {{ urlencode($url ?? request()->url()) }}"
        class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200"
        aria-label="Invia per email"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        @if($showLabel)
        <span>Email</span>
        @endif
    </a>
</div>
```

---

## Styling Guidelines

### Color Palette

```css
/* Primary Colors */
--brand-blue: #1E5A96;
--brand-green: #2E7D32;
--brand-orange: #F57C00;
--brand-red: #D32F2F;

/* Social Media Colors */
--facebook: #1877F2;
--twitter: #1DA1F2;
--linkedin: #0A66C2;
--instagram: #E4405F;

/* AdSense Colors */
--ad-background: #F5F5F5;
--ad-border: #E0E0E0;

/* Status Colors */
--success: #2E7D32;
--warning: #F57C00;
--error: #D32F2F;
--info: #1976D2;
```

### Typography Scale

```css
/* Headings */
--text-h1: 3.75rem;  /* 60px */
--text-h2: 3rem;     /* 48px */
--text-h3: 2.25rem;  /* 36px */
--text-h4: 1.75rem;  /* 28px */

/* Body */
--text-base: 1rem;   /* 16px */
--text-lg: 1.125rem; /* 18px */
--text-sm: 0.875rem; /* 14px */
--text-xs: 0.75rem;  /* 12px */
```

### Spacing Scale

```css
--spacing-xs: 0.5rem;   /* 8px */
--spacing-sm: 1rem;     /* 16px */
--spacing-md: 1.5rem;   /* 24px */
--spacing-lg: 2rem;     /* 32px */
--spacing-xl: 3rem;     /* 48px */
--spacing-2xl: 4rem;    /* 64px */
```

---

## Testing

### Component Testing

```php
// Modules/UI/tests/Components/AdsSenseTest.php
it('renders AdSense leaderboard ad', function () {
    $html = Blade::render('<x-ui.ads.leaderboard slotId="1234567890" />');
    
    expect($html)->toContain('adsbygoogle');
    expect($html)->toContain('data-ad-slot="1234567890"');
});

// Modules/UI/tests/Components/PopupsExitIntentTest.php
it('renders exit-intent popup with discount code', function () {
    $html = Blade::render('<x-ui.popups.exit-intent discountCode="RADIO10" />');
    
    expect($html)->toContain('RADIO10');
    expect($html)->toContain('Offerta limitata');
});
```

---

## Performance Optimization

### Lazy Loading

```javascript
// Load exit-intent popup only when needed
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadExitIntentPopup();
                observer.unobserve(entry.target);
            }
        });
    });
    
    observer.observe(document.body);
});
```

### AdSense Loading

```javascript
// Load AdSense asynchronously
(function() {
    const script = document.createElement('script');
    script.async = true;
    script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-XXXXXXXXXXXXXXXX';
    script.crossOrigin = 'anonymous';
    document.head.appendChild(script);
})();
```

---

## Conclusion

These marketing components provide a comprehensive toolkit for SEO optimization, lead generation, and monetization. All components follow Laraxot principles:

- **Modular**: Each component is independent and reusable
- **Accessible**: Proper ARIA labels and semantic HTML
- **Responsive**: Mobile-first design with Tailwind CSS
- **Performant**: Lazy loading and code splitting
- **Testable**: Unit and feature tests included

---

**Next Steps**:
1. Create component files in UI module
2. Add Livewire handlers for form submissions
3. Integrate with Analytics module for tracking
4. Test across browsers and devices
5. Document usage examples

---

**Document Version**: 1.0

**Author**: iFlow CLI
**Status**: Ready for Implementation