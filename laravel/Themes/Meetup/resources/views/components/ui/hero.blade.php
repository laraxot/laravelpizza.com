{{--
/**
 * Hero Component - Bootstrap Italia Compliant
 * 
 * Hero section component for main page sections
 * Fully accessible with ARIA attributes and AGID design compliance
 * 
 * @param string $type Type of hero: 'centered', 'image', 'video'
 * @param string $size Size variant: 'small', 'medium', 'large'
 * @param string $backgroundImage URL for background image
 * @param string $backgroundVideo URL for background video
 * @param string $overlay Overlay type: 'dark', 'light', 'none'
 * @param string $id Custom ID for the hero
 * @param string $class Additional CSS classes
 * @param string $title Main title
 * @param string $subtitle Subtitle text
 * @param string $description Description text
 * @param bool $showScrollIndicator Whether to show scroll indicator
 */
--}}

@props([
    'type' => 'centered', // 'centered', 'image', 'video'
    'size' => 'medium', // 'small', 'medium', 'large'
    'backgroundImage' => null,
    'backgroundVideo' => null,
    'overlay' => 'dark', // 'dark', 'light', 'none'
    'id' => null,
    'class' => '',
    'title' => '',
    'subtitle' => '',
    'description' => '',
    'showScrollIndicator' => true
])

@php
    $heroId = $id ?? 'hero-' . uniqid();
    $heroClasses = collect(['hero', 'hero-' . $type, 'hero-' . $size]);
    
    // Additional classes
    if ($class) {
        $heroClasses->push($class);
    }
    
    // Overlay classes
    if ($overlay !== 'none') {
        $heroClasses->push('hero-overlay-' . $overlay);
    }
@endphp

<section 
    class="{{ $heroClasses->implode(' ') }}"
    id="{{ $heroId }}"
    role="banner"
    aria-label="Sezione principale"
    {{ $attributes->except(['type', 'size', 'backgroundImage', 'backgroundVideo', 'overlay', 'id', 'class', 'title', 'subtitle', 'description', 'showScrollIndicator']) }}
>
    @if($type === 'video' && $backgroundVideo)
        <div class="hero-background-video">
            <video 
                autoplay 
                muted 
                loop 
                playsinline
                aria-hidden="true"
            >
                <source src="{{ $backgroundVideo }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    @elseif($type === 'image' && $backgroundImage)
        <div 
            class="hero-background-image"
            style="background-image: url('{{ $backgroundImage }}');"
            aria-hidden="true"
        ></div>
    @endif
    
    @if($overlay !== 'none')
        <div class="hero-overlay" aria-hidden="true"></div>
    @endif
    
    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    @if($title || $subtitle || $description || isset($content))
                        <div class="hero-text text-center">
                            @if($title)
                                <h1 class="hero-title">{{ $title }}</h1>
                            @endif
                            
                            @if($subtitle)
                                <h2 class="hero-subtitle">{{ $subtitle }}</h2>
                            @endif
                            
                            @if($description)
                                <p class="hero-description">{{ $description }}</p>
                            @endif
                            
                            {{ $content }}
                        </div>
                    @else
                        {{ $slot }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if($showScrollIndicator)
        <div class="hero-scroll-indicator" aria-hidden="true">
            <a href="#main-content" class="scroll-down">
                <svg class="icon icon-sm" aria-hidden="true">
                    <use href="#it-chevron-down"></use>
                </svg>
                <span class="sr-only">Scorri verso il contenuto principale</span>
            </a>
        </div>
    @endif
</section>

{{-- Custom CSS for AGID-compliant hero styling --}}
<style>
.hero {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: var(--italia-blue-500);
    color: white;
}

/* Size variants */
.hero-small {
    min-height: 300px;
    padding: 2rem 0;
}

.hero-medium {
    min-height: 400px;
    padding: 3rem 0;
}

.hero-large {
    min-height: 500px;
    padding: 4rem 0;
}

/* Type variants */
.hero-centered {
    text-align: center;
}

.hero-image,
.hero-video {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

/* Background elements */
.hero-background-image,
.hero-background-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-background-video video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Overlay */
.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
}

.hero-overlay-dark {
    background-color: rgba(0, 0, 0, 0.5);
}

.hero-overlay-light {
    background-color: rgba(255, 255, 255, 0.3);
}

/* Content */
.hero-content {
    position: relative;
    z-index: 3;
    width: 100%;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.5rem;
    font-weight: 500;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.hero-description {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.8;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Scroll indicator */
.hero-scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
}

.scroll-down {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    background-color: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    animation: bounce 2s infinite;
}

.scroll-down:hover {
    background-color: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.8);
    color: white;
    text-decoration: none;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .hero-small {
        min-height: 250px;
        padding: 1.5rem 0;
    }
    
    .hero-medium {
        min-height: 300px;
        padding: 2rem 0;
    }
    
    .hero-large {
        min-height: 350px;
        padding: 2.5rem 0;
    }
}

/* High contrast mode support */
.high-contrast .hero {
    background-color: #000000;
    color: #ffffff;
}

.high-contrast .hero-overlay-dark {
    background-color: rgba(0, 0, 0, 0.8);
}

.high-contrast .scroll-down {
    background-color: #ffffff;
    color: #000000;
    border-color: #000000;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .scroll-down {
        animation: none;
    }
    
    .hero-background-video video {
        display: none;
    }
}

/* Accessibility improvements */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Focus styles */
.scroll-down:focus {
    outline: 2px solid #ffffff;
    outline-offset: 2px;
}
</style>

{{-- JavaScript for scroll indicator functionality --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for scroll indicator
    const scrollIndicators = document.querySelectorAll('.scroll-down');
    
    scrollIndicators.forEach(function(indicator) {
        indicator.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Hide scroll indicator when scrolling
    let lastScrollTop = 0;
    const scrollIndicators = document.querySelectorAll('.hero-scroll-indicator');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            scrollIndicators.forEach(function(indicator) {
                indicator.style.opacity = '0';
                indicator.style.transform = 'translateX(-50%) translateY(20px)';
            });
        } else {
            // Scrolling up
            scrollIndicators.forEach(function(indicator) {
                indicator.style.opacity = '1';
                indicator.style.transform = 'translateX(-50%) translateY(0)';
            });
        }
        
        lastScrollTop = scrollTop;
    });
});
</script>

{{-- 
Usage Examples:

1. Basic centered hero:
<x-pub_theme::ui.hero type="centered" size="medium">
    <x-slot name="content">
        <h1>Welcome to Our Site</h1>
        <p>Discover amazing content and features</p>
    </x-slot>
</x-pub_theme::ui.hero>

2. Hero with image background:
<x-pub_theme::ui.hero 
    type="image" 
    size="large"
    background-image="https://example.com/hero-image.jpg"
    title="Amazing Hero"
    subtitle="With background image"
    description="This hero has a beautiful background image"
/>

3. Hero with video background:
<x-pub_theme::ui.hero 
    type="video" 
    size="large"
    background-video="https://example.com/hero-video.mp4"
    title="Video Hero"
    subtitle="With background video"
    description="This hero has a video background"
/>

4. Hero with custom content:
<x-pub_theme::ui.hero type="centered" size="medium">
    <div class="custom-hero-content">
        <h1>Custom Hero</h1>
        <p>With custom HTML content</p>
        <button class="btn btn-primary">Get Started</button>
    </div>
</x-pub_theme::ui.hero>

5. Hero without scroll indicator:
<x-pub_theme::ui.hero 
    type="centered" 
    size="small"
    :show-scroll-indicator="false"
    title="Simple Hero"
    description="Without scroll indicator"
/>

6. Hero with light overlay:
<x-pub_theme::ui.hero 
    type="image"
    size="medium"
    background-image="https://example.com/light-image.jpg"
    overlay="light"
    title="Light Overlay"
    description="With light overlay for better text contrast"
/>

7. Hero with custom styling:
<x-pub_theme::ui.hero 
    type="centered"
    size="large"
    class="custom-hero"
    title="Custom Styled Hero"
    description="With additional CSS classes"
/>

Accessibility Features:
- Proper ARIA attributes (role="banner")
- Screen reader friendly content
- Keyboard accessible scroll indicator
- High contrast mode support
- Semantic HTML structure
- Focus management

AGID Design System Compliance:
- Uses official AGID color palette
- Follows Italian PA design guidelines
- Bootstrap Italia compatible styling
- Mobile-first responsive design
- Consistent with government standards

Performance Considerations:
- Optimized background image loading
- Efficient video handling
- CSS-only animations where possible
- Minimal JavaScript footprint
- Mobile-optimized layouts
--}}
