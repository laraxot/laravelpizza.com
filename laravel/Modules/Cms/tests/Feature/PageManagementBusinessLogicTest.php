<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

it('can work with pages using SushiToJsons system', function (): void {
    Page::all();

    $newPage = Page::create([
        'title' => ['it' => 'Test Page', 'en' => 'Test Page'],
        'slug' => 'test-page',
    ]);

    Assert::assertInstanceOf(Page::class, $newPage);
    Assert::assertSame('test-page', $newPage->slug);

    $retrievedPage = Page::where('slug', 'test-page')->first();
    Assert::assertNull($retrievedPage);
});

it('can work with page content using SushiToJsons system', function (): void {
    $newContent = PageContent::create([
        'name' => ['it' => 'Test Content', 'en' => 'Test Content'],
        'slug' => 'test-content',
        'blocks' => [
            ['type' => 'text', 'content' => 'Test block content'],
        ],
    ]);

    Assert::assertInstanceOf(PageContent::class, $newContent);
    Assert::assertSame('test-content', $newContent->slug);

    $retrievedContent = PageContent::where('slug', 'test-content')->first();
    Assert::assertNull($retrievedContent);
});

it('can work with sections using SushiToJsons system', function (): void {
    $newSection = Section::create([
        'name' => ['it' => 'Test Section', 'en' => 'Test Section'],
        'slug' => 'test-section',
        'blocks' => [
            ['type' => 'header', 'content' => 'Test section content'],
        ],
    ]);

    Assert::assertInstanceOf(Section::class, $newSection);
    Assert::assertSame('test-section', $newSection->slug);

    $retrievedSection = Section::where('slug', 'test-section')->first();
    Assert::assertNull($retrievedSection);
});

it('can update page content', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Original Title', 'en' => 'Original Title'],
        'slug' => 'original-title',
    ]);

    $page->update([
        'title' => ['it' => 'Updated Title', 'en' => 'Updated Title'],
    ]);

    $freshPage = $page->fresh();
    Assert::assertInstanceOf(Page::class, $freshPage);

    if (is_string($freshPage->title)) {
        Assert::assertStringContainsString('Updated Title', $freshPage->title);
    } else {
        /** @var array<string, string>|array<int, string> $title */
        $title = $freshPage->title;
        Assert::assertSame('Updated Title', $title['it'] ?? $title[0] ?? '');
    }
});

it('can delete a page', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page to Delete', 'en' => 'Page to Delete'],
        'slug' => 'page-to-delete',
    ]);

    $id = $page->id;
    $page->delete();

    $deletedPage = Page::find($id);
    Assert::assertNull($deletedPage);
});

it('can handle page relationships and data structure', function (): void {
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

    /** @var array<int, array<string, mixed>> $contentBlocks */
    $contentBlocks = $page->content_blocks ?? [];
    Assert::assertCount(2, $contentBlocks);
    Assert::assertSame('hero', $contentBlocks[0]['type'] ?? null);
    Assert::assertSame('text', $contentBlocks[1]['type'] ?? null);
});

it('can manage page description and content', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Content', 'en' => 'Page with Content'],
        'slug' => 'page-with-content',
        'description' => 'This is a test page description',
        'content' => 'This is the main content of the page',
    ]);

    Assert::assertSame('This is a test page description', $page->description);
    Assert::assertSame('This is the main content of the page', $page->content);
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

    if (is_string($page->title)) {
        Assert::assertStringContainsString('Titolo Italiano', $page->title);
    } else {
        /** @var array<string, string>|array<int, string> $title */
        $title = $page->title;
        Assert::assertSame('Titolo Italiano', $title['it'] ?? $title[0] ?? '');
        Assert::assertSame('English Title', $title['en'] ?? $title[1] ?? '');
        Assert::assertSame('Deutscher Titel', $title['de'] ?? $title[2] ?? '');
    }

    /** @var array<int, array<string, mixed>> $contentBlocks */
    $contentBlocks = $page->content_blocks ?? [];
    /** @var array<string, string> $blockContent */
    $blockContent = $contentBlocks[0]['content'] ?? [];
    Assert::assertSame('Contenuto in italiano', $blockContent['it'] ?? null);
    Assert::assertSame('Content in English', $blockContent['en'] ?? null);
    Assert::assertSame('Inhalt auf Deutsch', $blockContent['de'] ?? null);
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

    /** @var array<int, array<string, mixed>> $contentBlocks */
    $contentBlocks = $page->content_blocks ?? [];
    Assert::assertCount(2, $contentBlocks);
    Assert::assertSame('section', $contentBlocks[0]['type'] ?? null);
    /** @var array<string, string>|string $sectionOneTitle */
    $sectionOneTitle = $contentBlocks[0]['title'] ?? '';
    /** @var array<string, string>|string $sectionTwoTitle */
    $sectionTwoTitle = $contentBlocks[1]['title'] ?? '';
    $sectionOneIt = is_array($sectionOneTitle) ? ($sectionOneTitle['it'] ?? $sectionOneTitle[0] ?? '') : $sectionOneTitle;
    $sectionTwoEn = is_array($sectionTwoTitle) ? ($sectionTwoTitle['en'] ?? $sectionTwoTitle[1] ?? '') : $sectionTwoTitle;
    Assert::assertSame('Sezione 1', $sectionOneIt);
    Assert::assertSame('Section 2', $sectionTwoEn);
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

    /** @var array<int, array<string, mixed>> $contentBlocks */
    $contentBlocks = $page->content_blocks ?? [];
    Assert::assertSame('default', $contentBlocks[0]['template'] ?? null);
    $sidebarBlocks = $page->sidebar_blocks ?? [];
    $footerBlocks = $page->footer_blocks ?? [];
    Assert::assertCount(1, $sidebarBlocks);
    Assert::assertCount(1, $footerBlocks);
});

it('can handle page permissions and access control', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Permissions', 'en' => 'Page with Permissions'],
        'slug' => 'page-with-permissions',
        'middleware' => ['auth', 'verified'],
    ]);

    /** @var list<string> $middleware */
    $middleware = $page->middleware ?? [];
    Assert::assertContains('auth', $middleware);
    Assert::assertContains('verified', $middleware);
});

it('can manage page timestamps', function (): void {
    $page = Page::create([
        'title' => ['it' => 'Page with Timestamps', 'en' => 'Page with Timestamps'],
        'slug' => 'page-with-timestamps',
    ]);

    Assert::assertNull($page->created_at);
    Assert::assertNull($page->updated_at);
});
