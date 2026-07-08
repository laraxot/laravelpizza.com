# Design Comuni Theme Audit & Improvement Roadmap

**Date**: 2026-04-08  
**Target**: Themes/Sixteen Compliance with `italia/design-comuni-pagine-statiche`

## 1. Current State Analysis

### 1.1 Technical Stack
- **Base**: Laravel 12 + Tailwind CSS 4.x
- **Strategy**: Hybrid (BI Classes + Tailwind @apply)
- **Status**: Partially compliant, high technical debt in CSS layer.

### 1.2 Identified Inconsistencies
| Category | Reference (Official) | Local Implementation | Issue |
| :--- | :--- | :--- | :--- |
| **Primary Color** | Blue `#0066CC` | Mixed (Blue & Green) | Config conflict in `tailwind.config.js` |
| **Header** | BI DOM Structure | Modified BI DOM | Needs CSS "Hacks" to look correct |
| **CSS Flow** | Component SCSS | `app.css` Overrides | Over-reliance on `!important` |
| **Layout** | 12-col BI Grid | Tailwind Grid/Flex | `home.blade.php` ignores BI classes |

## 2. Reasoning for Improvement

The current "hotfix-driven" development is creating a brittle theme. To reach the objective of 100% fidelity:
1. **HTML must be the source of truth for structure**: We must copy the reference HTML exactly.
2. **Tailwind must be the source of truth for style**: Avoid raw CSS hex codes; use the theme palette.
3. **Eliminate specificity wars**: If a component needs `!important` in `app.css`, its base `@apply` rule is either missing or wrong.

## 3. Implementation Roadmap

### Phase 1: Token Standardization (P0)
- [ ] Align `tailwind.config.js` `primary` palette with `#007A52` (Verde PA).
- [ ] Sync `design-comuni-tokens.css` with the chosen palette.
- [ ] Replace hardcoded hex values in `app.css` with Tailwind class references or CSS variables.

### Phase 2: Component Refactoring (P1)
- [ ] **Header**: Fix logo implementation (remove SVG/Image mix, use standard `img`).
- [ ] **Header**: Implement the correct Slim Header / Center / Navbar hierarchy without pseudo-element hacks.
- [ ] **Breadcrumbs**: Standardize structural classes.
- [ ] **Footer**: Align with the 3-section institutional footer (Main, Brand, Secondary).

### Phase 3: CSS Cleanup (P2)
- [ ] Move `app.css` "Parity Fixes" into `style-apply.css` using proper `@apply` rules.
- [ ] Remove `!important` from at least 90% of the theme files.
- [ ] Ensure `Titillium Web` is the only font-family applied to BI components.

### Phase 4: Validation (P1)
- [ ] Visual regression check against the [official static pages](https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html).
- [ ] Verify accessibility (ARIA labels, focus states).

## 4. Mantras for the Team
- *"Fix the Blade, not the CSS."*
- *"Use variables, not hex codes."*
- *"Stay institutional: follow the IA pillars."*
