# Meetup Theme Documentation

## Overview
The Meetup theme is a premium, multi-language responsive theme designed for the Laravel Pizza community platform. Built with Tailwind CSS 4.x, Vite 7, and Alpine.js, it follows Laraxot architecture principles and provides an enhanced user experience for Laravel developer meetups.

## Docs-First Governance
- Before editing any code that touches the public theme, study and improve this theme documentation and the related module documentation first.
- After local docs updates, align global `docs/rules`, `docs/memory`, `docs/skills` and evaluate whether the work should be tracked on GitHub Issues/Discussions.
- After editing PHP files in the theme or in related backend modules, apply the post-edit quality gate: `phpstan`, `phpmd`, `phpinsights`, plus the relevant Pest test when the changed behavior is testable.
- Public blocks and JSON-LD must rely on canonical backend relations; for many-to-many domain links in Meetup this means `belongsToManyX()`, not `belongsToMany()`.
- Public pages must also declare the correct page type (`WebPage`, `ProfilePage`, `ItemPage`, `CollectionPage`, `ContactPage`) and connect it to the entity via `mainEntity` or `mainEntityOfPage`.

## Key Features
- **Multi-Language Support**: Italian (primary), English, German, French, Spanish, Russian
- **Responsive Design**: Mobile-first approach with breakpoint optimization
- **Accessibility**: WCAG 2.2 AAA compliant with ARIA attributes
- **Performance**: Optimized assets with Vite and lazy loading
- **SEO Ready**: Structured meta tags, Open Graph, and Twitter Cards
- **Modern UI**: Glassmorphism, gradients, and smooth animations

## Architecture

### File Structure
```
Themes/Meetup/
├── resources/
│   ├── css/
│   │   └── app.css              # Main stylesheet with Tailwind
│   ├── js/
│   │   └── app.js               # JavaScript with Alpine.js
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php    # Main layout with header/footer
│   │   │   └── guest.blade.php  # Guest layout (login/register)
│   │   └── pages/
│   │       ├── auth/
│   │       │   ├── register.blade.php
│   │       │   └── login.blade.php
│   │       └── ...
├── public/                       # Compiled assets
├── docs/                         # Theme documentation
├── package.json                  # NPM dependencies
├── vite.config.js                # Vite configuration
└── composer.json                 # PHP dependencies
```

### Design System

#### Color Palette
- **Primary Dark**: `#0f2b46` (navy for navigation, footer, hero overlay)
- **Primary**: `#ef4444` (red-orange for CTAs, accents)
- **Secondary**: `#f97316` (orange for secondary CTAs)
- **Accent**: `#06b6d4` (cyan for tech elements, links)
- **Background**: `#f8fafc` (light gray sections)

#### Typography
- **Font Family**: Inter (Google Fonts)
- **Base Size**: 16px
- **Scale**: 1.25 (major third)
- **Weights**: 400, 500, 600, 700, 800

#### Spacing
- **Base Unit**: 0.25rem (4px)
- **Scale**: 1, 2, 3, 4, 5, 6, 8, 10, 12, 16, 20, 24

## Multi-Language Support

### Supported Languages
1. **Italian (it)** - Primary language
2. **English (en)** - Secondary language
3. **German (de)** - DACH region
4. **French (fr)** - France, Belgium, Switzerland
5. **Spanish (es)** - Spain, Latin America
6. **Russian (ru)** - Russia, CIS countries

### Translation Implementation
```php
// In Blade templates
{{ __('module::widget.key') }}

// Example
{{ __('gdpr::register.register.title') }}
{{ __('gdpr::register.clickbait.free_access') }}
```

### Translation Files Location
```
Modules/{ModuleName}/lang/{locale}/{widget}.php
```

## Components

### Layouts
- **app.blade.php**: Main layout with header, footer, navigation
- **guest.blade.php**: Simplified layout for authentication pages

### Pages
- **Home**: Landing page with hero, features, testimonials
- **Auth**: Login, register, password reset
- **Events**: Event listing and detail pages
- **Blog**: Blog posts and categories

### UI Components
- **Buttons**: Primary, secondary, outline, ghost variants
- **Forms**: Text inputs, selects, checkboxes, radios
- **Cards**: Feature cards, testimonial cards, event cards
- **Modals**: Dialogs, alerts, confirmations
- **Navigation**: Header, footer, breadcrumbs

## Development Workflow

### Prerequisites
- Node.js 18+
- PHP 8.2+
- Composer 2+

### Setup
```bash
cd laravel/Themes/Meetup
npm install
```

### Development
```bash
npm run dev    # Development server with hot reload
npm run build  # Production build
npm run copy   # Copy assets to public_html
```

### CSS/JS Workflow (CRITICAL)
1. Edit files in `resources/css/` or `resources/js/`
2. Run `npm run build` to compile assets
3. Run `npm run copy` to publish to `public_html/themes/Meetup/`
4. **IMPORTANT**: Without `npm run build` and `npm run copy`, changes are NOT visible!

### Database Testing Configuration (CRITICAL)

**NEVER invent environment variables in `.env.testing`!**

The `.env.testing` file must be a **COPY CARBON** of `.env` with **ONLY "_test"** added to database names.

❌ **WRONG**:
```bash
GDPR_DB_DATABASE=laravelpizza_gdpr_test  # Do NOT invent variables!
```

✅ **CORRECT**:
```bash
# If .env has:
DB_DATABASE=laravelpizza_data

# Then .env.testing has:
DB_DATABASE=laravelpizza_data_test  # Only add "_test"!
```

See [Database Testing Configuration](./database-testing-configuration.md) for complete details.

### Configuration
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: './public',
    },
});
```

## Accessibility (WCAG 2.2 AAA)

### Implementation
- **ARIA Attributes**: Proper labeling and descriptions
- **Focus States**: Visible focus indicators (3px thickness, 3:1 contrast)
- **Color Contrast**: 7:1 for normal text, 4.5:1 for large text
- **Screen Reader Support**: Hidden decorative elements, proper headings
- **Keyboard Navigation**: All interactive elements accessible via keyboard

### Validation
- **WAVE**: Accessibility evaluation tool
- **axe DevTools**: Automated accessibility testing
- **Lighthouse**: Accessibility score: 100

## SEO Optimization

### Meta Tags
```php
<x-slot name="title">Page Title - LaravelPizza Community</x-slot>
<x-slot name="description">Page description for search engines</x-slot>
<x-slot name="keywords">keyword1, keyword2, keyword3</x-slot>
```

### Open Graph
```html
<meta property="og:type" content="website">
<meta property="og:title" content="Page Title">
<meta property="og:description" content="Page description">
<meta property="og:image" content="URL to image">
```

### Twitter Cards
```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Page Title">
<meta name="twitter:description" content="Page description">
<meta name="twitter:image" content="URL to image">
```

## Performance Optimization

### CSS
- **Tailwind CSS 4.x**: Utility-first framework with JIT compilation
- **PurgeCSS**: Remove unused styles in production
- **Critical CSS**: Inline critical styles for faster FCP

### JavaScript
- **Alpine.js 3.x**: Lightweight reactive framework
- **Lazy Loading**: Defer non-critical JavaScript
- **Code Splitting**: Split bundles for optimal loading

### Assets
- **Vite**: Fast build tool with HMR
- **Compression**: Gzip/Brotli compression
- **CDN**: Serve assets via CDN for global distribution

## Marketing & Conversion

### Clickbait Techniques
- **Social Proof**: User counts, testimonials, reviews
- **Urgency**: Limited time offers, countdowns
- **Scarcity**: Limited spots, exclusive access
- **Value Proposition**: Clear benefits, specific numbers

### A/B Testing
- **Headlines**: Test different variations
- **CTAs**: Test button text and colors
- **Layouts**: Test different page structures
- **Copy**: Test different messaging

### Conversion Optimization
- **Form Optimization**: Reduce friction, improve UX
- **Exit Intent**: Capture leaving visitors
- **Social Login**: Reduce registration barriers
- **Email Capture**: Build email list

## Documentation

### Theme Documentation
- [Register Page Improvements](./register-page-improvements.md) - UI/UX overhaul with WCAG, SEO, and clickbait
- [Clickbait Marketing Best Practices](./clickbait-marketing-best-practices.md) - Ethical clickbait techniques

### Related Module Documentation
- [GDPR Module](../../modules/gdpr/docs/index.md) - GDPR compliance tools
- [User Module](../../modules/user/docs/index.md) - User authentication and management
- [Lang Module](../../modules/lang/docs/index.md) - Multi-language support
- [Xot Module](../../modules/xot/docs/index.md) - Core base classes

## Best Practices

### DO's ✅
- Use translation keys for all text
- Test in all supported languages
- Follow WCAG 2.2 AAA guidelines
- Optimize images and assets
- Write semantic HTML
- Use proper heading hierarchy
- Test on mobile devices
- Monitor performance metrics

### DON'Ts ❌
- Hardcode strings in Blade files
- Use English content in language files
- Ignore accessibility
- Skip mobile testing
- Create massive CSS files
- Use inline styles excessively
- Ignore SEO best practices
- Break responsive design

## Troubleshooting

### Assets Not Updating
**Problem**: Changes to CSS/JS not visible in browser

**Solution**:
```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```

### Translations Not Showing
**Problem**: Translated text not displaying

**Solution**:
1. Check translation key format: `module::widget.key`
2. Clear cache: `php artisan cache:clear`
3. Verify file exists in correct language directory

### Build Errors
**Problem**: Vite build fails

**Solution**:
1. Delete `node_modules` and `package-lock.json`
2. Run `npm install`
3. Check for syntax errors in CSS/JS files

## Future Enhancements

### Phase 1 (Short-term)
- [ ] Add dark mode toggle
- [ ] Implement page transitions
- [ ] Add micro-interactions
- [ ] Optimize bundle size

### Phase 2 (Medium-term)
- [ ] Add progressive web app (PWA) support
- [ ] Implement offline functionality
- [ ] Add voice search
- [ ] Improve performance scores

### Phase 3 (Long-term)
- [ ] Add AI-powered features
- [ ] Implement real-time collaboration
- [ ] Add AR/VR elements
- [ ] Explore 3D graphics

## Credits
- **Design System**: Tailwind CSS 4.x
- **JavaScript Framework**: Alpine.js 3.x
- **Build Tool**: Vite 7
- **Translation**: Laravel Localization (mcamara)
- **Icons**: Filament Icons + Heroicons
- **Fonts**: Inter (Google Fonts)

## License
This theme is part of the Laravel Pizza project and follows the same license.

## Support
For issues and questions:
- Check documentation first
- Search existing issues
- Create a new issue with details
- Provide reproduction steps

## Additional Documentation
- [Layout System](./layout-system.md) - Complete layout guidelines, grid system, and responsive patterns
- [Color Palette](./color-palette.md) - Color theory, accessibility, and brand consistency
- [Typography System](./typography.md) - Font selection, scaling, and readability guidelines
- [Animations](./animations.md) - Performance-optimized animations and micro-interactions
- [SEO Guidelines](./seo.md) - Search engine optimization best practices
- [WCAG Accessibility](./wcag-accessibility.md) - WCAG 2.2 AAA compliance guide

---

**Last Updated**: [DATE]
**Version**: 1.0.0
**Maintainer**: Laravel Pizza Team
