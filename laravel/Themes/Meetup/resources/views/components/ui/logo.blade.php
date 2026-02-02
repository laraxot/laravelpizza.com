{{--
/**
 * Enhanced Laravel Pizza Logo Component
 * 
 * Authentic Italian pizza slice design with:
 * - Realistic pizza shape with crust
 * - Pepperoni toppings
 * - Cheese details
 * - Professional color scheme
 * - Hover animations
 */
--}}

<div class="relative {{ $class ?? '' }}">
    <!-- Enhanced Pizza Slice Logo -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" 
         class="h-20 w-20 text-red-500 group-hover:rotate-6 transition-transform duration-300" 
         aria-hidden="true">
        <!-- Main pizza slice -->
        <path d="M50 10 L85 80 L15 80 Z" fill="#DC2626" stroke="#991B1B" stroke-width="1.5"/>
        
        <!-- Golden crust -->
        <path d="M50 10 L85 80 L80 82 L48 15 Z" fill="#F59E0B" opacity="0.85"/>
        
        <!-- Pepperoni slices -->
        <circle cx="45" cy="45" r="4.5" fill="#7F1D1D"/>
        <circle cx="55" cy="55" r="3.5" fill="#7F1D1D"/>
        <circle cx="35" cy="60" r="4" fill="#7F1D1D"/>
        <circle cx="50" cy="65" r="3" fill="#7F1D1D"/>
        
        <!-- Melted cheese drips -->
        <ellipse cx="50" cy="35" rx="2.5" ry="4.5" fill="#FEF3C7" opacity="0.9"/>
        <ellipse cx="40" cy="50" rx="2" ry="3.5" fill="#FEF3C7" opacity="0.9"/>
        <ellipse cx="58" cy="48" rx="1.8" ry="3" fill="#FEF3C7" opacity="0.85"/>
        
        <!-- Light reflection for depth -->
        <path d="M45 25 L48 20 L52 28 Z" fill="#FCA5A5" opacity="0.4"/>
        <ellipse cx="42" cy="38" rx="3" ry="2" fill="#FCA5A5" opacity="0.3"/>
        
        <!-- Additional details for realism -->
        <circle cx="48" cy="42" r="1" fill="#F59E0B" opacity="0.6"/>
        <circle cx="53" cy="58" r="0.8" fill="#F59E0B" opacity="0.6"/>
    </svg>
    
    <!-- Subtle shadow for depth -->
    <div class="absolute -bottom-2 left-0 right-0 h-3 bg-black/10 dark:bg-black/30 blur-md transform scale-95 group-hover:scale-100 transition-transform duration-300"></div>
</div>