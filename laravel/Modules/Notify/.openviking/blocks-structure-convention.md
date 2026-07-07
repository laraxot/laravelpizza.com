# OpenViking Update: Blocks Structure Convention

**URI**: `viking://themes/sixteen/blocks-structure-convention`  
**Timestamp**: 2026-03-30  
**Status**: ✅ COMPLETE

---

## 🎯 Block Structure Convention

**Pattern**: `components/blocks/<tipo>/<blade>.blade.php`

### Esempi

```blade
✅ CORRETTO:
components/blocks/confirmation/simple.blade.php
components/blocks/confirmation/with-details.blade.php
components/blocks/hero/homepage.blade.php
components/blocks/card/featured.blade.php

❌ SBAGLIATO:
components/blocks/tests/appuntamento-conferma/details.blade.php
components/blocks/fixcity/ticket-form.blade.php
```

---

## 📚 Block Types (Generic, Reusable)

### Primary Types

| Type | Purpose | Example Blades |
|------|---------|---------------|
| `hero` | Hero sections | `basic`, `with-image`, `centered`, `video` |
| `card` | Content cards | `basic`, `featured`, `product`, `event`, `article` |
| `features` | Feature lists | `grid`, `list`, `alternating`, `with-icons` |
| `cta` | Call-to-action | `simple`, `with-form`, `centered`, `banner` |
| `content` | Text content | `single-column`, `two-column`, `with-sidebar` |
| `gallery` | Image galleries | `grid`, `carousel`, `masonry`, `lightbox` |
| `form` | Forms | `contact`, `newsletter`, `search`, `booking` |
| `confirmation` | Confirmations | `simple`, `with-details`, `with-steps`, `success-card` |
| `steps` | Progress indicators | `horizontal`, `vertical`, `with-icons` |
| `timeline` | Timelines | `simple`, `with-icons`, `alternating` |
| `stats` | Statistics | `grid`, `horizontal`, `with-icons` |
| `testimonial` | Testimonials | `single`, `grid`, `carousel`, `with-rating` |
| `pricing` | Pricing tables | `single`, `comparison`, `with-features` |
| `faq` | FAQs | `accordion`, `list`, `with-search` |
| `team` | Team members | `grid`, `list`, `with-social` |
| `contact` | Contact info | `with-map`, `with-form`, `cards` |
| `footer` | Footers | `simple`, `multi-column`, `with-social` |
| `header` | Headers | `basic`, `with-nav`, `mega-menu` |
| `nav` | Navigation | `horizontal`, `vertical`, `breadcrumb` |

---

## 🎨 Inspiration Sources

### 1. Flowbite Blocks
**URL**: https://flowbite.com/blocks/

**Categories**:
- Hero, Features, Content, CTA
- Card, Form, Footer, Header
- Section, Testimonial, Pricing, Stats

### 2. Tailwind Plus UI Blocks
**URL**: https://tailwindcss.com/plus/ui-blocks

**Categories**:
- Marketing (Hero, Features, CTA, Stats)
- E-commerce (Product cards, Grids)
- Content (Article, Blog, FAQ)
- Application (Dashboard, Stats, Tables)
- Overlay (Modal, Banner, Alert)

### 3. DaisyUI Components
**URL**: https://daisyui.com/components/

**Components**:
- Alert, Card, Steps, Timeline
- Toast, Modal, Accordion, Stats

### 4. Bootstrap Italia
**URL**: https://italia.github.io/bootstrap-italia/docs/componenti/

**Componenti**:
- Alert, Steppers, Callout, Notifications
- Card, Badge, Breadcrumb, Pagination

---

## 📁 Confirmation Block (Example)

### Files Created

```
components/blocks/confirmation/
├── simple.blade.php           ✅ Created
├── with-details.blade.php     ✅ Created
├── with-steps.blade.php       🟡 To create
├── with-actions.blade.php     🟡 To create
└── success-card.blade.php     🟡 To create
```

### Usage Example

```blade
{{-- Simple Confirmation --}}
<x-blocks.confirmation.simple
    title="Appuntamento Confermato"
    message="Il tuo appuntamento è stato confermato."
    icon="check"
/>

{{-- With Details --}}
<x-blocks.confirmation.with-details
    title="Appuntamento Confermato"
    message="Riceverai una email di conferma."
    :details="[
        'Data' => '30 Marzo 2026',
        'Ora' => '10:00',
        'Luogo' => 'Ufficio Anagrafe, Via Roma 1',
        'Operatore' => 'Dott. Rossi'
    ]"
    icon="check"
/>
```

---

## 🎨 Tailwind → Bootstrap Italia Mapping

### Alert Success

```blade
{{-- Bootstrap Italia --}}
<div class="alert alert-success" role="alert">
    <svg class="icon icon-success">
        <use href="#it-check-circle"></use>
    </svg>
    <div class="alert-text">
        <div class="title">Operazione completata</div>
    </div>
</div>

{{-- Tailwind Equivalent --}}
<div class="bg-green-50 border-l-4 border-green-500 p-4">
    <div class="flex">
        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <div class="ml-3">
            <p class="text-sm text-green-800">Operazione completata</p>
        </div>
    </div>
</div>
```

### Stepper

```blade
{{-- Bootstrap Italia --}}
<div class="stepper stepper-vertical">
    <div class="stepper-item completed">
        <span class="stepper-number">1</span>
        <span class="stepper-title">Richiesta</span>
    </div>
    <div class="stepper-item active">
        <span class="stepper-number">2</span>
        <span class="stepper-title">Conferma</span>
    </div>
</div>

{{-- Tailwind Equivalent --}}
<ul class="steps steps-vertical">
    <li class="step step-primary">Richiesta</li>
    <li class="step step-primary">Conferma</li>
    <li class="step">Completamento</li>
</ul>
```

---

## ✅ Naming Rules

### DO ✅

```blade
components/blocks/confirmation/with-details.blade.php
components/blocks/hero/centered.blade.php
components/blocks/card/featured.blade.php
```

### DON'T ❌

```blade
components/blocks/tests/appuntamento-conferma/details.blade.php  (troppo specifico)
components/blocks/fixcity/appuntamento-conferma.blade.php  (project-specific)
components/blocks/appuntamento_conferma_details.blade.php  (snake_case nel nome)
components/blocks/confirmation-details.blade.php  (ibrido tipo-blade)
```

---

## 📋 Implementation Checklist

- [x] Structure convention documented
- [x] Confirmation block types defined
- [x] simple.blade.php created
- [x] with-details.blade.php created
- [ ] with-steps.blade.php created
- [ ] with-actions.blade.php created
- [ ] success-card.blade.php created
- [ ] All types documented
- [ ] Examples for each type

**Status**: 40% Complete ✅

---

## 🔗 References

### Documentation
- `viking://themes/sixteen/docs/blocks-structure-convention` - This document
- `viking://themes/sixteen/docs/blocks/confirmation` - Confirmation blocks
- `viking://themes/sixteen/bootstrap-italia-tailwind-conversion` - Conversion guide

### External
- [Flowbite Blocks](https://flowbite.com/blocks/)
- [Tailwind Plus UI Blocks](https://tailwindcss.com/plus/ui-blocks)
- [DaisyUI Components](https://daisyui.com/components/)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/docs/componenti/)

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Next Review**: After all block types are implemented
