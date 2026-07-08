# Project Visual Comparison - Homepage Parity

**Date**: 2026-04-02

---

## Objective

Make local homepage (http://127.0.0.1:8000/it/tests/homepage) visually identical to reference (https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html)

---

## Screenshots Summary

### Header - Sixteen Theme
![Header Comparison](./screenshots/header-comparison.png)
*Local vs Reference - Header section*

### Footer - Sixteen Theme
![Footer Comparison](./screenshots/footer-comparison.png)
*Local vs Reference - Footer section*

---

## Progress

| Component | Status | Notes |
|-----------|--------|-------|
| Header | ✅ Complete | Colors match Bootstrap Italia |
| Search Modal | ✅ Complete | Functional |
| Footer | ✅ Complete | Colors aligned |
| Hero Section | 🔄 In Progress | Comparing structure |
| Card Sections | 🔄 In Progress | Checking spacing |

---

## Theme Documentation

- [Sixteen Theme Visual Comparison](../laravel/Themes/Sixteen/docs/visual-comparison/README.md)
- [Design Comuni Analysis - Sixteen Theme](../laravel/Themes/Sixteen/docs/design-comuni-analysis.md)

---

## Technical Notes

- Framework: Tailwind CSS 4.x + Alpine.js
- Reference: Bootstrap Italia 2.x
- Colors aligned with CSS variables in style-apply.css

---

## Back to Project Docs

- [Project Documentation](./README.md)
- [Modules Index](./modules.md)