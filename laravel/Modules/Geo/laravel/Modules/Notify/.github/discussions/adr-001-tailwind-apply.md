---
title: "ADR: Use Tailwind @apply Instead of Bootstrap Italia CDN"
category: "Architecture Decisions"
labels: ["adr", "architecture", "tailwind", "bootstrap-italia"]
---

# Architecture Decision Record: Use Tailwind @apply Instead of Bootstrap Italia CDN

## Status
- [x] Proposed
- [ ] Accepted
- [ ] Deprecated
- [ ] Superseded

## Context

### Problem Statement
The Design Comuni template uses Bootstrap Italia CSS via CDN import. Our project uses Tailwind CSS v4 as the primary styling framework. We need to decide how to replicate the Bootstrap Italia design while staying true to our tech stack.

### Background
- **Current Approach**: Some files import Bootstrap Italia CSS via CDN (`@import url('https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css')`)
- **Issues**:
  - External dependency on CDN (latency, availability)
  - Mixing two CSS frameworks (Bootstrap + Tailwind)
  - Hard to customize Bootstrap classes
  - Bundle size includes entire Bootstrap Italia
  - Goes against our Tailwind-first architecture

### Stakeholders
- **Frontend Team**: Must implement and maintain styles
- **Performance Team**: Concerned about bundle size and load times
- **Design Team**: Needs pixel-perfect replication of Design Comuni
- **DevOps**: Manages deployments and CDN dependencies

## Decision

### Proposed Solution
**Use Tailwind CSS @apply directive to replicate Bootstrap Italia classes.**

Instead of importing Bootstrap Italia CSS, we will:
1. Identify all Bootstrap Italia classes used in the HTML
2. Replicate the styles using Tailwind's @apply directive
3. Store replicated styles in `style-apply.css`
4. Maintain 100% visual parity without Bootstrap dependency

### Technical Details

**File**: `laravel/Themes/Sixteen/resources/css/style-apply.css`

```css
/* Bootstrap Italia styles converted to Tailwind CSS with @apply */
/* Based on: https://italia.github.io/design-comuni-pagine-statiche/ */

@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap');
@import 'tailwindcss';

/* Set DaisyUI theme */
html {
  data-theme: bootstrap_italia;
}

/* CSS Custom Properties for Bootstrap Italia colors */
:root {
  --bs-primary: #007a52;
  --bs-primary-dark: #00614a;
  --bs-secondary: #5d7083;
  --bs-success: #008055;
  --bs-blue: #006cc6;
  --bs-dark: #17334f;
  --bs-light: #f8f9fa;
}

/* Header styling - Bootstrap Italia style with @apply */
.it-header-wrapper {
  background-color: var(--bs-primary);
  @apply text-white relative;
}

.it-header-slim-wrapper {
  background-color: var(--bs-primary-dark);
  @apply py-2 text-sm;
}

/* ... more replicated styles ... */
```

**HTML remains unchanged** (Bootstrap Italia classes in HTML):
```html
<header class="it-header-wrapper">
  <div class="it-header-slim-wrapper">
    <div class="container">
      <!-- Content -->
    </div>
  </div>
</header>
```

**Why keep Bootstrap classes in HTML?**
1. **Semantic meaning**: Classes like `it-header-wrapper` describe the component
2. **Reference parity**: Easier to compare with Design Comuni source
3. **Future-proof**: Can swap Tailwind @apply with custom CSS if needed
4. **Documentation**: Classes serve as documentation of original design

### Alternatives Considered

#### Alternative 1: Use Bootstrap Italia CDN
**Approach**: Import Bootstrap Italia CSS via CDN in layout

```blade
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css" />
```

**Why not chosen**:
- ❌ External dependency (CDN availability, latency)
- ❌ Large bundle size (entire Bootstrap Italia)
- ❌ Hard to customize (must override with !important)
- ❌ Mixes two CSS frameworks (conflicts, specificity wars)
- ❌ Goes against Tailwind-first architecture

#### Alternative 2: Convert to Pure Tailwind Classes
**Approach**: Replace all Bootstrap classes with Tailwind utilities

```html
<!-- Before (Bootstrap Italia) -->
<header class="it-header-wrapper">

<!-- After (Pure Tailwind) -->
<header class="bg-[#007a52] text-white relative">
```

**Why not chosen**:
- ❌ HTML becomes verbose (hundreds of utility classes)
- ❌ Hard to maintain (must update every HTML file)
- ❌ Loses semantic meaning (classes describe styles, not components)
- ❌ Difficult to compare with Design Comuni source
- ❌ Refactoring is painful (find/replace in HTML)

#### Alternative 3: Hybrid Approach (Selected)
**Approach**: Keep Bootstrap classes in HTML, replicate with Tailwind @apply

```html
<!-- HTML unchanged -->
<header class="it-header-wrapper">
```

```css
/* CSS replicates styles */
.it-header-wrapper {
  @apply bg-[#007a52] text-white relative;
}
```

**Why chosen**:
- ✅ No external dependencies
- ✅ Small bundle size (only used styles)
- ✅ Easy to customize (edit CSS file)
- ✅ Clean separation (HTML semantic, CSS presentational)
- ✅ Aligns with Tailwind architecture
- ✅ Easy to compare with Design Comuni source
- ✅ Refactoring is easy (edit one CSS file)

## Consequences

### Positive Consequences
- **No CDN dependency**: All styles local, faster load times
- **Smaller bundle**: Only include styles actually used
- **Easy customization**: Edit `style-apply.css` to customize
- **Maintainable**: One source of truth for styles
- **Performance**: Better Lighthouse scores (no external requests)
- **Architecture alignment**: Consistent with Tailwind-first approach
- **Documentation**: Bootstrap classes in HTML serve as reference

### Negative Consequences
- **Initial effort**: Must replicate all Bootstrap classes manually
- **Ongoing maintenance**: Must update `style-apply.css` as new components added
- **Learning curve**: Team must understand Tailwind @apply directive
- **Debugging complexity**: Must check both HTML classes and CSS @apply

### Risks

#### Risk 1: Incomplete Replication
**Risk**: Some Bootstrap styles not fully replicated  
**Mitigation**: 
- Use screenshot comparison to verify visual parity
- Create comprehensive checklist of all Bootstrap classes
- Test on all screen sizes (mobile, tablet, desktop)

#### Risk 2: Style Conflicts
**Risk**: Tailwind utilities conflict with @apply styles  
**Mitigation**:
- Use specific CSS selectors (`.it-header-wrapper`)
- Document which classes use @apply vs pure Tailwind
- Establish naming conventions

#### Risk 3: Performance Regression
**Risk**: Large `style-apply.css` file slows down builds  
**Mitigation**:
- Monitor file size, keep under 100KB
- Use Tailwind's PurgeCSS to remove unused styles
- Split into multiple files if needed (header.css, footer.css, etc.)

## Implementation Plan

### Phase 1: Setup (Week 1)
1. ✅ Create `style-apply.css` with @apply structure
2. ✅ Remove Bootstrap Italia CDN imports from layouts
3. ✅ Configure Vite to process `style-apply.css`
4. ✅ Verify build works (`npm run build`)

### Phase 2: Critical Components (Weeks 1-2)
1. ⏳ Replicate header styles (`.it-header-wrapper`, `.it-header-slim-wrapper`, etc.)
2. ⏳ Replicate footer styles (`.it-footer-wrapper`, etc.)
3. ⏳ Replicate grid system (`.container`, `.row`, `.col-*`)
4. ⏳ Replicate typography (`.title-xxxlarge`, `.subtitle-small`, etc.)
5. ⏳ Verify visual parity with screenshots

### Phase 3: Remaining Components (Weeks 3-12)
1. ⏳ Replicate navigation styles
2. ⏳ Replicate card styles
3. ⏳ Replicate form styles
4. ⏳ Replicate button styles
5. ⏳ Replicate utility classes
6. ⏳ Document all replicated styles in `COMPONENT_CATALOG.md`

### Phase 4: Optimization (Weeks 11-12)
1. ⏳ Audit `style-apply.css` for unused styles
2. ⏳ Optimize file size (remove duplicates, consolidate)
3. ⏳ Add source maps for debugging
4. ⏳ Create style guide with examples

## Validation Criteria

How will we know if this decision was correct?

### Metrics
- [ ] **Bundle size**: `style-apply.css` < 100KB (gzipped < 30KB)
- [ ] **Load time**: Page loads in < 2s (3G network)
- [ ] **Lighthouse**: Performance score > 90
- [ ] **Visual parity**: 100% match with Design Comuni (screenshot comparison)
- [ ] **Build time**: Vite build < 5s

### Qualitative
- [ ] Team can easily customize styles
- [ ] No CDN dependency issues
- [ ] Styles documented and maintainable
- [ ] New team members can understand architecture

## References

### Related Issues
- #2 - Component: Header Main (Universal)
- #3 - Component: Footer Full (Universal)
- #10 - Achieve HTML parity for homepage

### Related Docs
- **Roadmap**: `.planning/ROADMAP.md`
- **Research**: `.planning/research/design-comuni-pages.md`
- **Style Guide**: `Themes/Sixteen/docs/style-guide.md` (to be created)

### External Resources
- **Tailwind @apply**: https://tailwindcss.com/docs/reusing-styles#extracting-classes-with-apply
- **Bootstrap Italia**: https://italia.github.io/bootstrap-italia/
- **Design Comuni**: https://italia.github.io/design-comuni-pagine-statiche/

---

**Author**: [Your name]  
**Date**: April 1, 2026  
**Last Updated**: April 1, 2026  
**Status**: 🟡 Proposed (awaiting team review)

---

## Discussion

<!-- GitHub discussion comments will be added here -->

### Questions for the Team
1. Do we agree with this approach?
2. Are there any concerns about maintenance?
3. Should we consider any alternatives?
4. What's the timeline for implementation?

### Next Steps
1. Team reviews and provides feedback (by Apr 3)
2. Decision accepted or revised (by Apr 5)
3. Implementation begins (Apr 8)
