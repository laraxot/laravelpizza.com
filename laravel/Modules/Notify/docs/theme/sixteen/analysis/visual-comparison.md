---
title: "visual comparison"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "visual comparison"
issues: []
discussions: []
---

# Homepage Visual Comparison - CSS Fixes Required

## Screenshots Analysis

### Reference (Bootstrap Italia)
- Header with blue background (#0066CC)
- Hero with news card + image + search
- Argomenti section with blue background  
- Servizi cards with orange background
- Footer with yellow background

### Local (Tailwind + Alpine)
- Header without blue background
- Same hero structure
- Args section with white background
- Servizi with white cards
- Different footer

## Required CSS Fixes

### 1. Header - Blue Background
```css
.it-header-wrapper {
    background: #0066CC;
}
```

### 2. Argomenti Section - Blue Background
```css  
.evidence-section {
    background: #003D73;
}
```

### 3. Servizi Cards - Orange Background
```css
.servizi-grid {
    background: #F5A623;
}
```

### 4. Footer - Yellow Background
```css
.it-footer {
    background: #FFE500;
}
```

## Status: IN PROGRESS