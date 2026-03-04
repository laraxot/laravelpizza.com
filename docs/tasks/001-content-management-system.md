# Task 001: Implement Complete Content Management System

## Description
Build a comprehensive content management system with page management, content blocks, version control, multilingual support, and SEO optimization using Laravel Folio and Livewire Volt.

## Context
The Cms module needs a robust CMS for managing pages, blog posts, and dynamic content with support for multi-language, SEO, and flexible content structures.

## Requirements

### Functional Requirements
- Page management (create, edit, delete, publish)
- Content blocks system
- Rich text editor
- Media library integration
- Version control and history
- Multi-language support
- SEO optimization (meta tags, sitemaps)
- Page templates
- Content scheduling
- Menu management

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Laravel Folio for routing
- Livewire Volt for components
- Filament for admin
- DatabaseTransactions for tests

## Implementation Steps

### 1. Database Schema
- [ ] Create `cms_pages` table
  - id (uuid/ulid)
  - tenant_id
  - title (string)
  - slug (string, unique)
  - content (longtext)
  - excerpt (text, nullable)
  - status (enum: 'draft', 'published', 'scheduled', 'archived')
  - template (string, nullable)
  - published_at (nullable)
  - scheduled_at (nullable)
  - featured_image_id (nullable)
  - author_id
  - metadata (json, nullable)
  - deleted_at (nullable)
  - timestamps

- [ ] Create `cms_page_translations` table
  - id, page_id, locale, title, slug, content, excerpt, metadata
  - Unique (page_id, locale)

- [ ] Create `cms_content_blocks` table
  - id, page_id, block_type, position, content, settings (json)

- [ ] Create `cms_menus` table
  - id, tenant_id, name, slug, is_active, depth
  - parent_id (nullable)

- [ ] Create `cms_menu_items` table
  - id, menu_id, parent_id (nullable), title, url, type, order, is_active

- [ ] Create `cms_seo` table
  - id, page_id, meta_title, meta_description, meta_keywords, og_title, og_description, og_image, canonical_url, robots

### 2. Models
- [ ] Create `CmsPage` model
  - Extends base model
  - HasMany CmsPageTranslation
  - HasMany CmsContentBlock
  - HasOne CmsSeo
  - BelongsTo User (author)
  - Strict typing

- [ ] Create `CmsPageTranslation` model
- [ ] Create `CmsContentBlock` model
- [ ] Create `CmsMenu` model
- [ ] Create `CmsMenuItem` model
- [ ] Create `CmsSeo` model

### 3. Page Management Service
- [ ] Create `CmsPageService`
  - `createPage(array $data): CmsPage`
  - `updatePage(string $pageId, array $data): CmsPage`
  - `deletePage(string $pageId): bool`
  - `publishPage(string $pageId): bool`
  - `unpublishPage(string $pageId): bool`
  - `duplicatePage(string $pageId): CmsPage`
  - `getPageBySlug(string $slug): CmsPage`
  - `searchPages(string $query): Collection`

### 4. Content Block System
- [ ] Create `ContentBlockManager` service
  - `registerBlockType(string $type, array $config): void`
  - `renderBlock(CmsContentBlock $block): string`
  - `getAvailableBlocks(): array`

- [ ] Implement block types
  - Text block
  - Image block
  - Video block
  - Gallery block
  - Form block
  - Quote block
  - Divider block
  - Custom block

### 5. Rich Text Editor
- [ ] Integrate rich text editor
  - TinyMCE or Quill
  - Image upload
  - Link management
  - Source code view
  - Custom styles

### 6. Version Control
- [ ] Create `CmsPageVersion` model
  - id, page_id, version_number, content, created_by, created_at

- [ ] Implement versioning
  - `createVersion(string $pageId): CmsPageVersion`
  - `restoreVersion(string $pageId, int $version): bool`
  - `compareVersions(string $pageId, int $v1, int $v2): array`
  - `listVersions(string $pageId): Collection`

### 7. Multi-language Support
- [ ] Create `TranslationService`
  - `translatePage(string $pageId, string $locale): CmsPageTranslation`
  - `getTranslation(string $pageId, string $locale): CmsPageTranslation`
  - `syncTranslations(array $data): void`

### 8. SEO Optimization
- [ ] Create `SeoService`
  - `generateMetaTags(CmsPage $page): array`
  - `generateSitemap(): string`
  - `validateSeo(CmsPage $page): array`
  - `getSeoScore(CmsPage $page): int`

- [ ] Implement SEO features
  - Meta tag management
  - Open Graph tags
  - Twitter Card tags
  - Canonical URLs
  - Robots.txt integration
  - Sitemap generation

### 9. Menu Management
- [ ] Create `MenuService`
  - `createMenu(array $data): CmsMenu`
  - `addMenuItem(string $menuId, array $item): CmsMenuItem`
  - `removeMenuItem(string $itemId): bool`
  - `reorderItems(string $menuId, array $order): bool`
  - `renderMenu(string $menuSlug): string`

### 10. Filament Resources
- [ ] Create `CmsPageResource`
  - Page list with filters
  - Create/Edit forms
  - Rich text editor
  - Content blocks builder
  - Version history
  - SEO settings

- [ ] Create `CmsMenuResource`
  - Menu management
  - Drag-and-drop item ordering
  - Menu preview

- [ ] Create `CmsBlockTemplateResource`
  - Block template management
  - Custom block creation

### 11. Frontend Integration (Folio/Volt)
- [ ] Create page routes with Folio
- [ ] Create page components with Volt
- [ ] Implement dynamic page rendering
- [ ] Add menu components

### 12. Actions
- [ ] Create `PublishPageAction`
- [ ] Create `DuplicatePageAction`
- [ ] Create `RestoreVersionAction`
- [ ] Create `GenerateSitemapAction`

### 13. Tests
- [ ] Create `CmsPageTest`
- [ ] Create `ContentBlockTest`
- [ ] Create `VersionControlTest`
- [ ] Create `TranslationTest`
- [ ] Create `SeoTest`

### 14. Documentation
- [ ] Create CMS user guide
- [ ] Document content blocks
- [ ] Create SEO guide
- [ ] Add translation guide

## Acceptance Criteria
- [ ] Pages can be created and managed
- [ ] Content blocks work correctly
- [ ] Version control is functional
- [ ] Multi-language support works
- [ ] SEO features are complete
- [ ] Menus can be managed
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Lang module (translations)
- Media module (media library)
- Filament 5.x (admin UI)
- Laravel Folio (routing)
- Livewire Volt (components)

## Estimated Time
- Database schema: 4 hours
- Models: 4 hours
- Page service: 5 hours
- Content blocks: 6 hours
- Rich text editor: 3 hours
- Version control: 4 hours
- Multi-language: 4 hours
- SEO: 5 hours
- Menu management: 4 hours
- Filament integration: 6 hours
- Frontend integration: 4 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 62 hours (8 days)**

## Priority
**High** - Core CMS functionality

## Related Tasks
- Task 002: Advanced Content Features
- Task 003: Content Analytics

## Notes
- Use draft/published workflow
- Implement autosave for editors
- Cache published pages
- Use CDN for assets
- Implement preview mode
- Support custom page templates

---

**Status**: Pending
**Assignee**: TBD