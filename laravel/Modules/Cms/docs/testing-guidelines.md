# Cms Module - Testing Guidelines

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration:
```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=<nome progetto>_data_test
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. Page Model Tests

#### Core Functionality Tests
```php
<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;

describe('Page Business Logic', function () {
    it('creates page with required fields', function () {
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'content' => 'Test content',
        ]);

        expect($page)
            ->toBeInstanceOf(Page::class)
            ->and($page->title)->toBe('Test Page')
            ->and($page->slug)->toBe('test-page')
            ->and($page->content)->toBe('Test content');
    });

    it('generates slug automatically from title', function () {
        $page = Page::factory()->create([
            'title' => 'My Amazing Page Title',
        ]);

        expect($page->slug)->toBe('my-amazing-page-title');
    });

    it('validates slug uniqueness per locale', function () {
        Page::factory()->create([
            'slug' => 'duplicate-slug',
            'locale' => 'en',
        ]);

        expect(function () {
            Page::factory()->create([
                'slug' => 'duplicate-slug',
                'locale' => 'en',
            ]);
        })->toThrow(Exception::class);
    });

    it('allows same slug for different locales', function () {
        $pageEn = Page::factory()->create([
            'slug' => 'same-slug',
            'locale' => 'en',
        ]);

        $pageIt = Page::factory()->create([
            'slug' => 'same-slug',
            'locale' => 'it',
        ]);

        expect($pageEn->slug)->toBe($pageIt->slug)
            ->and($pageEn->locale)->not->toBe($pageIt->locale);
    });
});
```

### 2. Section Management Tests

#### Block-Based Content Tests
```php
describe('Section Business Logic', function () {
    it('creates sections with block content', function () {
        $section = Section::factory()->create([
            'type' => 'text_block',
            'content' => [
                'title' => 'Section Title',
                'body' => 'Section content body',
            ],
        ]);

        expect($section->type)->toBe('text_block')
            ->and($section->content)->toBeArray()
            ->and($section->content['title'])->toBe('Section Title');
    });

    it('orders sections correctly', function () {
        $page = Page::factory()->create();
        
        $section1 = Section::factory()->create([
            'page_id' => $page->id,
            'order' => 1,
        ]);
        
        $section2 = Section::factory()->create([
            'page_id' => $page->id,
            'order' => 2,
        ]);

        $orderedSections = $page->sections()->orderBy('order')->get();
        
        expect($orderedSections->first()->id)->toBe($section1->id)
            ->and($orderedSections->last()->id)->toBe($section2->id);
    });

    it('renders section content correctly', function () {
        $section = Section::factory()->create([
            'type' => 'image_block',
            'content' => [
                'src' => '/images/test.jpg',
                'alt' => 'Test image',
                'caption' => 'Test caption',
            ],
        ]);

        $rendered = $section->render();
        
        expect($rendered)->toContain('/images/test.jpg')
            ->and($rendered)->toContain('Test image')
            ->and($rendered)->toContain('Test caption');
    });
});
```

### 3. Menu System Tests

```php
describe('Menu Business Logic', function () {
    it('creates hierarchical menu structure', function () {
        $parentMenu = Menu::factory()->create([
            'title' => 'Parent Menu',
            'parent_id' => null,
        ]);

        $childMenu = Menu::factory()->create([
            'title' => 'Child Menu',
            'parent_id' => $parentMenu->id,
        ]);

        expect($childMenu->parent->id)->toBe($parentMenu->id)
            ->and($parentMenu->children)->toHaveCount(1)
            ->and($parentMenu->children->first()->id)->toBe($childMenu->id);
    });

    it('generates navigation tree correctly', function () {
        $menu1 = Menu::factory()->create(['order' => 1]);
        $menu2 = Menu::factory()->create(['order' => 2]);
        $menu3 = Menu::factory()->create(['order' => 3]);

        $navigation = Menu::getNavigationTree();
        
        expect($navigation)->toHaveCount(3)
            ->and($navigation->first()->id)->toBe($menu1->id)
            ->and($navigation->last()->id)->toBe($menu3->id);
    });

    it('filters menu by user role', function () {
        $publicMenu = Menu::factory()->create([
            'visibility' => 'public',
        ]);

        $adminMenu = Menu::factory()->create([
            'visibility' => 'admin',
        ]);

        $publicNavigation = Menu::getNavigationForRole('guest');
        $adminNavigation = Menu::getNavigationForRole('admin');
        
        expect($publicNavigation)->toHaveCount(1)
            ->and($adminNavigation)->toHaveCount(2);
    });
});
```

### 4. Configuration Management Tests

```php
describe('Configuration Business Logic', function () {
    it('stores and retrieves configuration values', function () {
        Conf::set('site.title', 'My Website');
        Conf::set('site.description', 'Website description');

        expect(Conf::get('site.title'))->toBe('My Website')
            ->and(Conf::get('site.description'))->toBe('Website description');
    });

    it('handles nested configuration keys', function () {
        Conf::set('mail.smtp.host', 'smtp.example.com');
        Conf::set('mail.smtp.port', 587);

        expect(Conf::get('mail.smtp.host'))->toBe('smtp.example.com')
            ->and(Conf::get('mail.smtp.port'))->toBe(587);
    });

    it('provides default values for missing config', function () {
        $value = Conf::get('nonexistent.key', 'default_value');
        
        expect($value)->toBe('default_value');
    });
});
```

### 5. Multi-Language Tests

```php
describe('Multi-Language Business Logic', function () {
    it('creates content in multiple languages', function () {
        $pageEn = Page::factory()->create([
            'title' => 'English Title',
            'locale' => 'en',
        ]);

        $pageIt = Page::factory()->create([
            'title' => 'Titolo Italiano',
            'locale' => 'it',
            'translation_key' => $pageEn->translation_key,
        ]);

        expect($pageEn->getTranslation('it'))->not->toBeNull()
            ->and($pageIt->getTranslation('en'))->not->toBeNull();
    });

    it('falls back to default language', function () {
        $defaultPage = Page::factory()->create([
            'title' => 'Default Title',
            'locale' => 'en',
        ]);

        app()->setLocale('fr'); // Non-existing translation
        
        $page = Page::getBySlug($defaultPage->slug);
        
        expect($page->title)->toBe('Default Title');
    });
});
```

## Integration Tests

### Frontend Rendering Tests
```php
describe('Frontend Integration', function () {
    it('renders page correctly in frontend', function () {
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'status' => 'published',
        ]);

        $response = $this->get('/test-page');
        
        $response->assertStatus(200)
            ->assertSee('Test Page');
    });

    it('handles 404 for non-existent pages', function () {
        $response = $this->get('/non-existent-page');
        
        $response->assertStatus(404);
    });

    it('redirects unpublished pages for guests', function () {
        $page = Page::factory()->create([
            'slug' => 'draft-page',
            'status' => 'draft',
        ]);

        $response = $this->get('/draft-page');
        
        $response->assertStatus(404);
    });
});
```

### Admin Interface Tests
```php
describe('Admin Interface Integration', function () {
    it('allows admin to create pages', function () {
        $admin = User::factory()->admin()->create();
        
        $this->actingAs($admin)
            ->post('/admin/pages', [
                'title' => 'New Page',
                'content' => 'Page content',
                'status' => 'published',
            ])
            ->assertRedirect();

        expect(Page::where('title', 'New Page')->exists())->toBeTrue();
    });

    it('prevents guests from accessing admin', function () {
        $response = $this->get('/admin/pages');
        
        $response->assertRedirect('/login');
    });
});
```

## Performance Tests

### Caching Tests
```php
describe('Performance and Caching', function () {
    it('caches page content efficiently', function () {
        $page = Page::factory()->create();
        
        // First load - should cache
        $startTime = microtime(true);
        $content1 = $page->getCachedContent();
        $firstLoadTime = microtime(true) - $startTime;
        
        // Second load - should use cache
        $startTime = microtime(true);
        $content2 = $page->getCachedContent();
        $secondLoadTime = microtime(true) - $startTime;
        
        expect($content1)->toBe($content2)
            ->and($secondLoadTime)->toBeLessThan($firstLoadTime);
    });

    it('handles large content efficiently', function () {
        $largeContent = str_repeat('Large content block. ', 1000);
        
        $page = Page::factory()->create([
            'content' => $largeContent,
        ]);

        $startTime = microtime(true);
        $rendered = $page->render();
        $renderTime = microtime(true) - $startTime;
        
        expect($renderTime)->toBeLessThan(1.0) // 1 second max
            ->and($rendered)->toContain('Large content block.');
    });
});
```

## Quality Standards

### Test Requirements
- All tests use `declare(strict_types=1);`
- Descriptive test names explaining business scenarios
- Complete setup and teardown
- Meaningful assertions
- Error scenario coverage

### Business Logic Focus
- Content creation and management workflows
- Multi-language functionality
- SEO optimization features
- Performance characteristics
- Security and access control

---

**Last Updated**: 2025-08-28
**Testing Framework**: Pest
**Environment**: .env.testing
