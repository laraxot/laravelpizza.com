<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('can work with pages using SushiToJsons system', function (): void {
    // Get existing pages from JSON files
    $pages = Page::all();

    expect($pages)->toBeCollection();
    expect($pages->count())->toBeGreaterThanOrEqual(0); // There might be existing pages

    // Test creating a new page
    $newPage = Page::create([
        'title' => ['it' => 'Test Page', 'en' => 'Test Page'],
        'slug' => 'test-page',
    ]);

    expect($newPage)->toBeInstanceOf(Page::class);
    expect($newPage->slug)->toBe('test-page');

    // Verify the page was saved to JSON
    $retrievedPage = Page::where('slug', 'test-page')->first();
    expect($retrievedPage)->not->toBeNull();
    expect($retrievedPage->slug)->toBe('test-page');
});

it('can work with page content using SushiToJsons system', function (): void {
    // Create a page content
    $newContent = PageContent::create([
        'name' => ['it' => 'Test Content', 'en' => 'Test Content'],
        'slug' => 'test-content',
        'blocks' => [
            ['type' => 'text', 'content' => 'Test block content'],
        ],
    ]);

    expect($newContent)->toBeInstanceOf(PageContent::class);
    expect($newContent->slug)->toBe('test-content');

    // Verify the content was saved to JSON
    $retrievedContent = PageContent::where('slug', 'test-content')->first();
    expect($retrievedContent)->not->toBeNull();
    expect($retrievedContent->slug)->toBe('test-content');
});

it('can work with sections using SushiToJsons system', function (): void {
    // Create a section
    $newSection = Section::create([
        'name' => ['it' => 'Test Section', 'en' => 'Test Section'],
        'slug' => 'test-section',
        'blocks' => [
            ['type' => 'header', 'content' => 'Test section content'],
        ],
    ]);

    expect($newSection)->toBeInstanceOf(Section::class);
    expect($newSection->slug)->toBe('test-section');

    // Verify the section was saved to JSON
    $retrievedSection = Section::where('slug', 'test-section')->first();
    expect($retrievedSection)->not->toBeNull();
    expect($retrievedSection->slug)->toBe('test-section');
});

it('can update page content', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Original Title', 'en' => 'Original Title'],
        'slug' => 'original-title',
    ]);

    // Update the page
    $page->update([
        'title' => ['it' => 'Updated Title', 'en' => 'Updated Title'],
    ]);

    $freshPage = $page->fresh();

    // Check if title is a string (not array) or handle accordingly
    if (is_string($freshPage->title)) {
        expect($freshPage->title)->toContain('Updated Title');
    } else {
        // Handle multilingual title
        expect($freshPage->title['it'] ?? $freshPage->title[0] ?? $freshPage->title)->toBe('Updated Title');
    }
});

it('can delete a page', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page to Delete', 'en' => 'Page to Delete'],
        'slug' => 'page-to-delete',
    ]);

    $id = $page->id;

    // Delete the page
    $page->delete();

    // Verify the page is no longer accessible
    $deletedPage = Page::find($id);
    expect($deletedPage)->toBeNull();
});

it('can handle page relationships and data structure', function (): void {
    // Create a page with content blocks
    $page = Page::create([
        'title' => ['it' => 'Page with Blocks', 'en' => 'Page with Blocks'],
        'slug' => 'page-with-blocks',
        'content_blocks' => [
            [
                'id' => 'block-1',
                'type' => 'hero',
                'content' => ['it' => 'Hero content', 'en' => 'Hero content'],
            ],
            [
                'id' => 'block-2',
                'type' => 'text',
                'content' => ['it' => 'Text content', 'en' => 'Text content'],
            ],
        ],
    ]);

    expect($page->content_blocks)->toBeArray();
    expect($page->content_blocks)->toHaveCount(2);
    expect($page->content_blocks[0]['type'])->toBe('hero');
    expect($page->content_blocks[1]['type'])->toBe('text');
});

it('can manage page description and content', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Content', 'en' => 'Page with Content'],
        'slug' => 'page-with-content',
        'description' => 'This is a test page description',
        'content' => 'This is the main content of the page',
    ]);

    expect($page->description)->toBe('This is a test page description');
    expect($page->content)->toBe('This is the main content of the page');
});

it('can handle multilingual content', function (): void {
    $page = Page::create([
        'title' => [
            'it' => 'Titolo Italiano',
            'en' => 'English Title',
            'de' => 'Deutscher Titel',
        ],
        'slug' => 'multilingual-page',
        'content_blocks' => [
            [
                'id' => 'content-block',
                'type' => 'text',
                'content' => [
                    'it' => 'Contenuto in italiano',
                    'en' => 'Content in English',
                    'de' => 'Inhalt auf Deutsch',
                ],
            ],
        ],
    ]);

    // Check if title is a string or array
    if (is_string($page->title)) {
        expect($page->title)->toContain('Titolo Italiano');
    } else {
        expect($page->title['it'] ?? $page->title[0] ?? $page->title)->toBe('Titolo Italiano');
        expect($page->title['en'] ?? $page->title[1] ?? $page->title)->toBe('English Title');
        expect($page->title['de'] ?? $page->title[2] ?? $page->title)->toBe('Deutscher Titel');
    }

    expect($page->content_blocks[0]['content']['it'])->toBe('Contenuto in italiano');
    expect($page->content_blocks[0]['content']['en'])->toBe('Content in English');
    expect($page->content_blocks[0]['content']['de'])->toBe('Inhalt auf Deutsch');
});

it('can manage page sections', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Sections', 'en' => 'Page with Sections'],
        'slug' => 'page-with-sections',
        'content_blocks' => [
            [
                'id' => 'section-1',
                'type' => 'section',
                'title' => ['it' => 'Sezione 1', 'en' => 'Section 1'],
                'content' => ['it' => 'Contenuto sezione 1', 'en' => 'Section 1 content'],
            ],
            [
                'id' => 'section-2',
                'type' => 'section',
                'title' => ['it' => 'Sezione 2', 'en' => 'Section 2'],
                'content' => ['it' => 'Contenuto sezione 2', 'en' => 'Section 2 content'],
            ],
        ],
    ]);

    expect($page->content_blocks)->toBeArray();
    expect($page->content_blocks)->toHaveCount(2);
    expect($page->content_blocks[0]['type'])->toBe('section');
    expect($page->content_blocks[0]['title']['it'] ?? $page->content_blocks[0]['title'][0] ?? $page->content_blocks[0]['title'])->toBe('Sezione 1');
    expect($page->content_blocks[1]['title']['en'] ?? $page->content_blocks[1]['title'][1] ?? $page->content_blocks[1]['title'])->toBe('Section 2');
});

it('can handle page templates and layouts', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Template', 'en' => 'Page with Template'],
        'slug' => 'page-with-template',
        'content_blocks' => [
            [
                'id' => 'layout-block',
                'type' => 'layout',
                'template' => 'default',
                'content' => ['it' => 'Layout content', 'en' => 'Layout content'],
            ],
        ],
        'sidebar_blocks' => [
            [
                'id' => 'sidebar-block',
                'type' => 'widget',
                'content' => ['it' => 'Sidebar widget', 'en' => 'Sidebar widget'],
            ],
        ],
        'footer_blocks' => [
            [
                'id' => 'footer-block',
                'type' => 'footer',
                'content' => ['it' => 'Footer content', 'en' => 'Footer content'],
            ],
        ],
    ]);

    expect($page->content_blocks[0]['template'])->toBe('default');
    expect($page->sidebar_blocks)->toBeArray();
    expect($page->footer_blocks)->toBeArray();
    expect($page->sidebar_blocks)->toHaveCount(1);
    expect($page->footer_blocks)->toHaveCount(1);
});

it('can handle page permissions and access control', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Permissions', 'en' => 'Page with Permissions'],
        'slug' => 'page-with-permissions',
        'middleware' => ['auth', 'verified'],
    ]);

    expect($page->middleware)->toBeArray();
    expect($page->middleware)->toContain('auth');
    expect($page->middleware)->toContain('verified');
});

it('can manage page timestamps', function (): void {
    $now = now();

    $page = Page::create([
        'title' => ['it' => 'Page with Timestamps', 'en' => 'Page with Timestamps'],
        'slug' => 'page-with-timestamps',
    ]);

    expect($page->created_at)->not->toBeNull();
    expect($page->updated_at)->not->toBeNull();

    // Check that timestamps are close to now
    expect($page->created_at->timestamp)->toBeGreaterThanOrEqual($now->subMinute()->timestamp);
    expect($page->created_at->timestamp)->toBeLessThanOrEqual($now->addMinute()->timestamp);
});
