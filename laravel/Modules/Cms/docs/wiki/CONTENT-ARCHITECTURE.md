---
title: "CMS Module - Content Architecture"
type: "architecture"
tags: ["cms", "content", "pages", "blocks"]
date: "2026-06-13"
qmd: "cms-content-architecture"
github_issue: ""
github_discussion: ""
---

# CMS Module - Content Architecture

## Overview

Sistema di gestione contenuti modulare basato su Pages, Blocks e Templates.
Stato: 🔄 In sviluppo - 50% completato

## Modello Dati

### ContentPage
```php
ContentPage
├── id: bigint
├── slug: string (unique)
├── title: json (traduzioni)
├── content: json (block editor)
├── template: string (blade template)
├── meta: json (seo, og, etc)
├── status: enum(draft,published,archived)
├── published_at: datetime
└── author_id: fk(users)
```

### ContentBlock
```php
ContentBlock
├── id: bigint
├── type: string (text,image,cta,embed,etc)
├── data: json (content specific)
├── order: int
└── page_id: fk(content_pages)
```

## Block Types

### Implementati ✅
- `text` - Editor WYSIWYG
- `image` - Con alt e caption
- `heading` - H1-H6 con anchor

### Da Implementare 📝
- `cta` - Call to action button
- `embed` - YouTube, maps, etc
- `gallery` - Grid/carousel
- `accordion` - FAQ style
- `tabs` - Tabbed content
- `form` - Contact forms

## Template System

### Regola: Template in Theme
```
Themes/{Theme}/resources/views/cms/
├── templates/
│   ├── default.blade.php
│   ├── landing.blade.php
│   └── blog-post.blade.php
└── blocks/
    ├── text.blade.php
    ├── image.blade.php
    └── heading.blade.php
```

### Registrazione Template
```php
// CmsServiceProvider
public function boot(): void
{
    CmsTemplate::register('landing', [
        'label' => 'Landing Page',
        'blocks' => ['heading', 'text', 'cta', 'image'],
    ]);
}
```

## Filament Resources

### ContentPageResource
- Form: Tabs per lingua
- Blocks: Repeater con select type
- Preview: Live preview iframe
- SEO: Meta tags, OpenGraph

### ContentBlockResource
- Gestione standalone
- Reorder drag & drop
- Copy between pages

## API (Folio + Actions)

### Pages
```
GET /api/cms/pages/{slug}
→ GetPageBySlugAction → ContentPageData

GET /api/cms/pages
→ ListPagesAction → Collection<ContentPageData>

POST /api/cms/pages
→ CreatePageAction → ContentPage
```

## TODO

### Backend
- [ ] Block repeater con livewire
- [ ] Media library integration
- [ ] Versioning system
- [ ] Preview in nuova tab

### Frontend
- [ ] Render blocks dynamic
- [ ] Cache strategico
- [ ] Eager loading relations

### API
- [ ] Rate limiting
- [ ] Cache headers
- [ ] Webhooks su change

## Collegamenti

- [Project Roadmap](../../Activity/docs/wiki/PROJECT-ROADMAP.md)
- [Fixcity Module Status](../../Fixcity/docs/wiki/MODULE-STATUS.md)
