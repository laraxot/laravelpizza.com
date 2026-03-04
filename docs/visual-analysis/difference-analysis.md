# Technical Difference Analysis: UI Inconsistencies

This document breaks down the technical reasons for visual differences between the local Meetup theme (Filament 5 / Tailwind 4) and the production reference.

## 🛠 Tech Stack Discrepancy

- **Local**: Laravel 12, Filament 5, **Tailwind CSS v4.0** (using `@tailwindcss/vite`).
- **Production (Target)**: Likely Laravel 10/11, Filament 3/4, Tailwind CSS v3.x.

### Impact of Tailwind 4
Tailwind 4 uses a **CSS-first configuration** (`@theme` block in `app.css`). This changes how we handle colors compared to the traditional `tailwind.config.js` (which is still present but deprecated in some aspects).

## 🧩 Component Breakdown

### 1. Navigation Manager (`navigation.js`)
The local implementation uses a custom `NavigationManager` class with Alpine.js interaction.
- **Difference**: The local dropdown uses `backdrop-blur-md` and `bg-slate-800/80`.
- **Optimization**: This is actually a visual upgrade over the production site, but it must be tested for performance on low-end devices.

### 2. Button Component Styling
Local implementation in `app.css`:
```css
.btn-primary {
    @apply bg-red-600 text-white px-6 py-3 rounded-lg font-semibold;
    @apply hover:bg-red-700 transition-colors duration-200;
}
```
- **Comparison**: Production uses a slightly different border-radius (possibly `rounded-md` instead of `rounded-lg`).
- **Fix**: Align `--radius` variables in the `@theme` block.

### 3. Feature Section (Background mismatch)
As identified in `gap-documentation.md`, the local body section defaults to light mode or white background.
- **Technical Reason**: The `index.html` has `bg-slate-50` in the body but the sections inside don't all have `dark:` variants that force dark mode.
- **Solution**: We need to enforce `dark` class on `html` tag by default if we want parity with `laravelpizza.com`.

## 🚨 Filament 5 Specific Differences

Filament 5 actions (buttons in modals/forms) have a new class prefix `.fi-ac` and `.fi-btn`.
- **Action Item**: We must ensure our global `.btn-primary` styles or CSS hooks target `.fi-btn` to ensure consistent branding across the public site and administrative actions.

```css
/* In app.css */
.fi-btn {
    @apply rounded-xl; /* Matching our premium rounded style */
}
```

---
**Next Steps**: Implementation of full-dark mode enforcement.
