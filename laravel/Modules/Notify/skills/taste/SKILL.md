# Taste Skill - High-End Design Intelligence

## 🎯 Panoramica

Skill per insegnare agli agenti AI a progettare come un'agenzia high-end. Definisce font, spacing, ombre, strutture card e animazioni che fanno sembrare "costoso" un sito web.

## 📦 Installazione

```bash
cd /var/www/_bases/base_fixcity_fila5
git clone https://github.com/Leonxlnx/taste-skill.git skills/taste
```

## 🎨 Design Principles

### 1. Typography Scale

```css
/* Modular Scale (1.250 - Major Third) */
--text-xs: 0.75rem;    /* 12px */
--text-sm: 0.9375rem;  /* 15px */
--text-base: 1.125rem; /* 18px */
--text-lg: 1.406rem;   /* 22.5px */
--text-xl: 1.758rem;   /* 28px */
--text-2xl: 2.197rem;  /* 35px */
--text-3xl: 2.746rem;  /* 44px */
--text-4xl: 3.433rem;  /* 55px */
--text-5xl: 4.291rem;  /* 69px */
```

### 2. Spacing System

```css
/* 8px Grid System */
--space-1: 0.25rem;  /* 2px */
--space-2: 0.5rem;   /* 4px */
--space-3: 1rem;     /* 8px */
--space-4: 1.5rem;   /* 12px */
--space-5: 2rem;     /* 16px */
--space-6: 3rem;     /* 24px */
--space-7: 4rem;     /* 32px */
--space-8: 6rem;     /* 48px */
--space-9: 8rem;     /* 64px */
--space-10: 12rem;   /* 96px */
```

### 3. Shadow System

```css
/* Elevation Shadows */
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
--shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
--shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
```

### 4. Border Radius

```css
/* Radius Scale */
--radius-sm: 0.25rem;  /* 4px */
--radius: 0.5rem;      /* 8px */
--radius-md: 0.75rem;  /* 12px */
--radius-lg: 1rem;     /* 16px */
--radius-xl: 1.5rem;   /* 24px */
--radius-2xl: 2rem;    /* 32px */
--radius-full: 9999px; /* Pill */
```

### 5. Color Palette

```css
/* Neutral Colors */
--neutral-50: #fafafa;
--neutral-100: #f4f4f5;
--neutral-200: #e4e4e7;
--neutral-300: #d4d4d8;
--neutral-400: #a1a1aa;
--neutral-500: #71717a;
--neutral-600: #52525b;
--neutral-700: #3f3f46;
--neutral-800: #27272a;
--neutral-900: #18181b;

/* Primary (Customizable) */
--primary-50: #eff6ff;
--primary-100: #dbeafe;
--primary-200: #bfdbfe;
--primary-300: #93c5fd;
--primary-400: #60a5fa;
--primary-500: #3b82f6;
--primary-600: #2563eb;
--primary-700: #1d4ed8;
--primary-800: #1e40af;
--primary-900: #1e3a8a;
```

## 🎨 Card Structures

### Basic Card

```blade
<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Card Title</h3>
        <p class="text-gray-600 mb-4">Card description goes here.</p>
        <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">
            Learn more →
        </a>
    </div>
</div>
```

### Featured Card

```blade
<div class="relative bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl shadow-xl overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="relative p-8 text-white">
        <h3 class="text-2xl font-bold mb-3">Featured Card</h3>
        <p class="text-primary-100 mb-6">This card has a gradient background.</p>
        <button class="bg-white text-primary-700 px-6 py-2 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
            Call to Action
        </button>
    </div>
</div>
```

### Image Card

```blade
<div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
    <div class="relative overflow-hidden aspect-w-16 aspect-h-9">
        <img src="/image.jpg" alt="Card image" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
    </div>
    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Image Card</h3>
        <p class="text-gray-600">Card with image and hover effect.</p>
    </div>
</div>
```

## ✨ Animation Guidelines

### Micro-interactions

```css
/* Button Hover */
.btn {
    @apply transition-all duration-200 ease-in-out;
}

.btn:hover {
    @apply transform -translate-y-0.5;
}

.btn:active {
    @apply transform translate-y-0;
}

/* Card Hover */
.card {
    @apply transition-shadow duration-300;
}

.card:hover {
    @apply shadow-xl;
}

/* Link Hover */
.link {
    @apply relative inline-block;
}

.link::after {
    content: '';
    @apply absolute bottom-0 left-0 w-0 h-0.5 bg-primary-600 transition-all duration-200;
}

.link:hover::after {
    @apply w-full;
}
```

### Page Transitions

```css
/* Fade In */
.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Slide Up */
.slide-up {
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scale In */
.scale-in {
    animation: scaleIn 0.4s ease-out;
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
```

## 🚫 Anti-Patterns (What to Avoid)

### 1. Generic AI Aesthetics
```blade
{{-- ❌ WRONG: Generic gradient --}}
<div class="bg-gradient-to-r from-blue-500 to-purple-600">

{{-- ✅ CORRECT: Subtle, refined gradient --}}
<div class="bg-gradient-to-br from-primary-500 to-primary-700">
```

### 2. Heavy Shadows
```blade
{{-- ❌ WRONG: Too heavy --}}
<div class="shadow-2xl">

{{-- ✅ CORRECT: Subtle elevation --}}
<div class="shadow-md hover:shadow-lg">
```

### 3. Inconsistent Spacing
```blade
{{-- ❌ WRONG: Random spacing --}}
<div class="p-3 m-5 gap-7">

{{-- ✅ CORRECT: Consistent scale --}}
<div class="p-6 m-4 gap-4">
```

### 4. Too Many Colors
```blade
{{-- ❌ WRONG: Rainbow --}}
<div class="text-red-500 bg-blue-300 border-green-600">

{{-- ✅ CORRECT: Limited palette --}}
<div class="text-gray-900 bg-white border-gray-200">
```

## ✅ Best Practices

### 1. Use Design Tokens
```blade
{{-- Define in CSS --}}
:root {
    --color-brand: #3b82f6;
    --spacing-unit: 0.25rem;
    --radius-default: 0.5rem;
}

{{-- Use in components --}}
<div class="bg-[var(--color-brand)] p-[calc(var(--spacing-unit)*4)] rounded-[var(--radius-default)]">
```

### 2. Maintain Hierarchy
```blade
<h1 class="text-4xl font-bold mb-6">Page Title</h1>
<h2 class="text-3xl font-semibold mb-4">Section</h2>
<h3 class="text-2xl font-medium mb-3">Subsection</h3>
<p class="text-base text-gray-600 mb-4">Body text</p>
```

### 3. White Space is Your Friend
```blade
{{-- Give content room to breathe --}}
<div class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Content -->
    </div>
</div>
```

### 4. Test in Multiple States
```blade
<button class="
    bg-primary-600 
    hover:bg-primary-700 
    focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
    active:bg-primary-800
    disabled:bg-gray-300 disabled:cursor-not-allowed
    transition-all duration-200
">
```

## 🔗 References

### External
- [Taste Skill GitHub](https://github.com/Leonxlnx/taste-skill)
- [High-End Design Guide](https://highenddesign.guide/)
- [Refactoring UI](https://www.refactoringui.com/)

### Internal
- [UI/UX Pro Max Skill](./ui-ux-pro-max/SKILL.md)
- [Bootstrap Italia Integration](./BOOTSTRAP_ITALIA_TAILWIND_CONVERSION.md)

---

**Version**: 1.0  
**Date**: 2026-03-30  
**Status**: ✅ Ready to Use  
**OpenViking URI**: `viking://skills/taste`
