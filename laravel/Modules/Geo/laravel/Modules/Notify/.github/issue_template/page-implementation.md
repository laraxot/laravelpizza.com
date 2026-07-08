---
name: Page Implementation
about: Implement a Design Comuni page replication
title: 'Page: [Page Name] - /it/tests/[slug]'
labels: ['page', 'design-comuni', 'frontend']
assignees: ''
---

## Page: [Page Name]

**URL**: `/it/tests/[slug]`  
**Source**: https://italia.github.io/design-comuni-pagine-statiche/sito/[page].html  
**Epic**: #[Epic number]  
**Priority**: [P1 / P2 / P3]  
**Status**: 🟡 Proposed / 🟡 In Progress / ✅ Complete

---

## Requirements

### Source Page
**Design Comuni**: https://italia.github.io/design-comuni-pagine-statiche/sito/[page].html  
**View Source**: `view-source:https://italia.github.io/design-comuni-pagine-statiche/sito/[page].html`

### Target Page
**FixCity**: http://fixcity.local/it/tests/[slug]  
**View Source**: `view-source:http://fixcity.local/it/tests/[slug]`

### Screenshots
<!-- Add side-by-side screenshots -->

**Desktop**: ![Desktop comparison](comparison-desktop.png)  
**Mobile**: ![Mobile comparison](comparison-mobile.png)

---

## Implementation Plan

### 1. Create JSON Content File
**File**: `laravel/config/local/fixcity/database/content/pages/tests.[slug].json`

```json
{
  "slug": "tests.[slug]",
  "title": "[Page Title] - Comune di FixCity",
  "meta_description": "[Meta description]",
  "blocks": [
    {
      "type": "header",
      "view": "pub_theme::components.blocks.header.main",
      "data": {
        "institution_name": "Comune di FixCity",
        "tagline": "Un comune da vivere"
      }
    },
    {
      "type": "[block_type]",
      "view": "pub_theme::components.blocks.[type].[variant]",
      "data": {
        "title": "[Block title]",
        "content": "[Block content]"
      }
    },
    {
      "type": "footer",
      "view": "pub_theme::components.blocks.footer.full",
      "data": {
        "address": "Via Roma 1, FixCity",
        "phone": "+39 0123 456789",
        "email": "info@comune.fixcity.it"
      }
    }
  ]
}
```

### 2. Verify Route Exists
**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

This file should NOT exist. All pages use the dynamic route:
**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```php
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = [
            'slug' => $slug
        ];
    }
};
?>

<x-layouts.app>
 @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### 3. Ensure All Components Exist
Link to component issues:
- [ ] Header: #2
- [ ] [Component 1]: #[issue]
- [ ] [Component 2]: #[issue]
- [ ] Footer: #3

### 4. Verify HTML Parity
Compare HTML inside `<body>` tag (excluding scripts):

**Checklist**:
- [ ] Header structure matches
- [ ] Navigation structure matches
- [ ] Main content structure matches
- [ ] Footer structure matches
- [ ] All Bootstrap Italia classes replicated with Tailwind @apply
- [ ] All ARIA labels present
- [ ] All semantic HTML tags used correctly

### 5. Verify Visual Parity
Create screenshot comparison:

**Checklist**:
- [ ] Colors match exactly (use color picker)
- [ ] Typography matches (font, size, weight, line-height)
- [ ] Spacing matches (margins, paddings)
- [ ] Layout matches (grid, flexbox)
- [ ] Images match (size, aspect ratio)
- [ ] Icons match (size, color)

### 6. Create Screenshot Analysis
**File**: `Themes/Sixteen/docs/screenshots/[slug]-comparison.md`

```markdown
# Screenshot Analysis: [Page Name]

## Header Comparison
![Header comparison](header-comparison.png)

**Differences Found**:
1. [Difference 1]
2. [Difference 2]

**Fixes Applied**:
1. [Fix 1]
2. [Fix 2]

## Footer Comparison
![Footer comparison](footer-comparison.png)

**Differences Found**:
1. [Difference 1]

**Fixes Applied**:
1. [Fix 1]

## Main Content Comparison
![Content comparison](content-comparison.png)

**Differences Found**:
1. [Difference 1]

**Fixes Applied**:
1. [Fix 1]

## Final Status
- ✅ HTML parity: 100%
- ✅ Visual parity: 100%
```

---

## Acceptance Criteria

### Code Quality
- [ ] JSON file created with valid structure
- [ ] All blocks use universal components (NOT page-specific)
- [ ] JSON follows schema (see JSON_STRUCTURE.md)
- [ ] No hardcoded HTML in Blade templates
- [ ] PHPStan Level 10 compliance
- [ ] Pint code style (PSR-12)

### Design Quality
- [ ] HTML inside `<body>` is 100% identical to source (excluding scripts)
- [ ] Visual appearance matches 100% (colors, spacing, typography)
- [ ] Responsive design works (mobile, tablet, desktop)
- [ ] WCAG 2.1 AA accessibility compliance
- [ ] Lighthouse scores >90 (all categories)

### Documentation
- [ ] Screenshot comparison created
- [ ] Analysis document created
- [ ] Differences documented
- [ ] Fixes documented
- [ ] Bidirectional links in docs

---

## Testing

### Visual Regression Tests
```php
// tests/Browser/Pages/[Slug]Test.php
it('matches Design Comuni [page] screenshot', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/[slug]')
                ->waitFor('@header')
                ->waitFor('@footer')
                ->assertScreenshot('[page]-desktop');
    });
});

it('is responsive on mobile', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/[slug]')
                ->resize(375, 812)
                ->assertScreenshot('[page]-mobile');
    });
});
```

### Accessibility Tests
```php
it('passes WCAG 2.1 AA audit', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/[slug]')
                ->assertAccessibility('wcag2aa');
    });
});
```

### Performance Tests
```php
it('loads in under 2 seconds', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/[slug]')
                ->assertLoadTimeLessThan(2000);
    });
});

it('achieves Lighthouse score >90', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/[slug]')
                ->assertLighthouseScore(90);
    });
});
```

---

## Definition of Done

- [ ] JSON content file created
- [ ] All components exist and work
- [ ] HTML parity verified (side-by-side comparison)
- [ ] Visual parity verified (screenshot analysis)
- [ ] Accessibility audit passed (WCAG 2.1 AA)
- [ ] Performance audit passed (Lighthouse >90)
- [ ] All tests passing (Pest + Browser)
- [ ] Screenshot comparison documented
- [ ] Code reviewed and approved
- [ ] Deployed to staging

---

## Related Issues
- **Epic**: #[Epic number]
- **Depends on** (components): #[issue numbers]
- **Blocks**: #[issue numbers]
- **Related to**: #[issue numbers]

---

## Comments

<!-- GitHub comments will be added here -->
