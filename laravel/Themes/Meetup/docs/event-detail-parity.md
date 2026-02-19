# Event Detail Visual Parity Roadmap

**Objective**: Ensure `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1` is an exact visual and functional clone of `https://laravelpizza.com/events/1`.

## 📸 Reference Screenshots
*   **Production**: `docs/screenshots/production_event_detail.png` (Pending Capture)
*   **Local**: `docs/screenshots/local_event_detail.png` (Pending Capture)

## 📊 Discrepancy Analysis (High Fidelity)

### 1. Header & Typography
- **Reference**: Large white bold title "Laravel 11 Release Pizza Party" on a dark/slate gradient background.
- **Local**: Currently uses a more complex 2-column layout with a sidebar.
- **Action**: Flatten the header and ensure the title is the focal point with proper alignment.

### 2. Information Blocks (Date/Time/Location)
- **Reference**: Three distinct blocks with rounded icons (light backgrounds) for Date, Time, and Location, arranged horizontally.
- **Local**: Uses a sidebar sidebar for RSVP.
- **Action**: Refactor the information display to match the horizontal block pattern with SVG icons.

### 3. Navigation & Badges
- **Reference**: "< Torna agli eventi" breadcrumb and a vivid green "Upcoming" pill badge.
- **Local**: Uses a custom breadcrumb with multiple levels.
- **Action**: Simplify breadcrumbs and update badge styling to match the reference.

### 4. Background & Accents
- **Reference**: Very dark slate background with subtle glow/gradient effects.
- **Local**: Uses Glassmorphism with orange/blue blurs.
- **Action**: Keep the premium blurs but ensure the primary background is deep enough to match the production theme.

## 🗺 Roadmap to 100% Parity

### Phase 1: Visual Audit [/]
- [ ] Capture Full Page Screenshot of Production.
- [ ] Capture Full Page Screenshot of Local.
- [ ] Annotate screenshots with red-lines for padding, margin, and font discrepancies.

### Phase 2: CSS Refinement [ ]
- [ ] Update `detail.blade.php` with exact class parity.
- [ ] Synchronize Tailwind configuration if production uses custom tokens.

### Phase 3: Functional Parity [ ]
- [ ] Align RSVP logic with production workflow.
- [ ] Ensure Schema.org metadata is identical.

---
*This document serves as the coordination point for all AI agents involved in this parity task.*
