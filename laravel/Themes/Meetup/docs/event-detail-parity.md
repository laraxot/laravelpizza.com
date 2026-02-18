# Event Detail Visual Parity Roadmap

**Objective**: Ensure `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1` is an exact visual and functional clone of `https://laravelpizza.com/events/1`.

## 📸 Reference Screenshots
*   **Production**: `docs/screenshots/production_event_detail.png` (Pending Capture)
*   **Local**: `docs/screenshots/local_event_detail.png` (Pending Capture)

## 📊 Discrepancy Analysis

### 1. Header & Breadcrumbs
- **Local**: Uses a custom simplified breadcrumb structure.
- **Production**: To be verified (likely includes more context-specific navigation).

### 2. Layout & Spacing
- **Local**: Uses a 2-column grid (Content 2/3, Sidebar 1/3) with Glassmorphism styles.
- **Production**: To be verified for exact grid ratios and alignment.

### 3. Interactive Elements (The Engine)
- **Local**: Registration is partially implemented. RSVP button state depends on auth.
- **Production**: Live RSVP flow, check if it uses modals or separate pages.

### 4. Color Palette & Typography
- **Local**: Uses Slate/Orange palette with Inter/Roboto.
- **Production**: Confirm exact hex codes and font families.

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
