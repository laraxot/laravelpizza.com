<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;

use function Safe\json_encode;

use Tests\TestCase;

class PageManagementBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreatePageWithBasicInformation(): void
    {
        // Arrange
        $pageData = [
            'title' => 'Home Page',
            'slug' => 'home',
            'status' => 'published',
            'meta_title' => 'Home Page - '.config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di '.config('app.name', 'Our Platform'),
        ];

        // Act
        $page = Page::create($pageData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Home Page',
            'slug' => 'home',
            'status' => 'published',
            'meta_title' => 'Home Page - '.config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di '.config('app.name', 'Our Platform'),
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Home Page', $page->title);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('home', $page->slug);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('published', $page->status);
    }

    /** @test */
    public function itCanCreatePageWithContent(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $contentData = [
            'page_id' => $page->id,
            'content' => '<h1>Benvenuti su '.
                    config('app.name', 'Our Platform').
                    '</h1><p>La vostra salute è la nostra priorità.</p>',
            'locale' => 'it',
            'version' => 1,
        ];

        // Act
        $pageContent = PageContent::create($contentData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('page_contents', [
            'id' => $pageContent->id,
            'page_id' => $page->id,
            'locale' => 'it',
            'version' => 1,
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals($page->id, $pageContent->page_id);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('it', $pageContent->locale);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals(1, $pageContent->version);
    }

    /** @test */
    public function itCanCreatePageWithSections(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $sectionData = [
            'page_id' => $page->id,
            'title' => 'Hero Section',
            'content' => 'Contenuto della sezione hero',
            'order' => 1,
            'type' => 'hero',
        ];

        // Act
        $section = Section::create($sectionData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('sections', [
            'id' => $section->id,
            'page_id' => $page->id,
            'title' => 'Hero Section',
            'order' => 1,
            'type' => 'hero',
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals($page->id, $section->page_id);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Hero Section', $section->title);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals(1, $section->order);
    }

    /** @test */
    public function itCanUpdatePageStatus(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'draft']);

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update(['status' => 'published']);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'status' => 'published',
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('published', $page->fresh()->status);
    }

    /** @test */
    public function itCanUpdatePageSeoMetadata(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $seoData = [
            'meta_title' => 'Nuovo Meta Title',
            'meta_description' => 'Nuova meta description per SEO',
            'meta_keywords' => 'salute, dentista, milano',
            'canonical_url' => 'https://'.config('app.domain', 'example.com').'/pagina',
        ];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update($seoData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'meta_title' => 'Nuovo Meta Title',
            'meta_description' => 'Nuova meta description per SEO',
            'meta_keywords' => 'salute, dentista, milano',
            'canonical_url' => 'https://'.config('app.domain', 'example.com').'/pagina',
        ]);
    }

    /** @test */
    public function itCanManagePageVersions(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $contentV1 = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Versione 1 del contenuto',
            'locale' => 'it',
            'version' => 1,
        ]);

        $contentV2 = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Versione 2 del contenuto aggiornata',
            'locale' => 'it',
            'version' => 2,
        ]);

        // Act
        $versions = PageContent::where('page_id', $page->id)
            ->where('locale', 'it')
            ->orderBy('version', 'desc')
            ->get();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(2, $versions);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals(2, $versions->first()->version);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals(1, $versions->last()->version);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Versione 2 del contenuto aggiornata', $versions->first()->content);
    }

    /** @test */
    public function itCanManageMultilingualPageContent(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $italianContent = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Contenuto in italiano',
            'locale' => 'it',
            'version' => 1,
        ]);

        $englishContent = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Content in English',
            'locale' => 'en',
            'version' => 1,
        ]);

        // Act
        $italian = PageContent::where('page_id', $page->id)->where('locale', 'it')->first();

        $english = PageContent::where('page_id', $page->id)->where('locale', 'en')->first();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertNotNull($italian);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertNotNull($english);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Contenuto in italiano', $italian->content);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Content in English', $english->content);
    }

    /** @test */
    public function itCanManagePageSectionsOrder(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $section1 = Section::create([
            'page_id' => $page->id,
            'title' => 'Prima Sezione',
            'order' => 1,
            'type' => 'hero',
        ]);

        $section2 = Section::create([
            'page_id' => $page->id,
            'title' => 'Seconda Sezione',
            'order' => 2,
            'type' => 'content',
        ]);

        $section3 = Section::create([
            'page_id' => $page->id,
            'title' => 'Terza Sezione',
            'order' => 3,
            'type' => 'footer',
        ]);

        // Act
        $orderedSections = Section::where('page_id', $page->id)->orderBy('order', 'asc')->get();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(3, $orderedSections);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject, offsetAccess.nonOffsetAccessible */
        $this->assertEquals('Prima Sezione', $orderedSections[0]->title);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject, offsetAccess.nonOffsetAccessible */
        $this->assertEquals('Seconda Sezione', $orderedSections[1]->title);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject, offsetAccess.nonOffsetAccessible */
        $this->assertEquals('Terza Sezione', $orderedSections[2]->title);
    }

    /** @test */
    public function itCanReorderPageSections(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $section1 = Section::create([
            'page_id' => $page->id,
            'title' => 'Prima Sezione',
            'order' => 1,
            'type' => 'hero',
        ]);

        $section2 = Section::create([
            'page_id' => $page->id,
            'title' => 'Seconda Sezione',
            'order' => 2,
            'type' => 'content',
        ]);

        // Act - Swap order
        /* @phpstan-ignore-next-line method.nonObject */
        $section1->update(['order' => 2]);
        /* @phpstan-ignore-next-line method.nonObject */
        $section2->update(['order' => 1]);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('sections', [
            'id' => $section1->id,
            'order' => 2,
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('sections', [
            'id' => $section2->id,
            'order' => 1,
        ]);
    }

    /** @test */
    public function itCanValidatePageSlugUniqueness(): void
    {
        // Arrange
        Page/* @phpstan-ignore-line */ ::factory()->create(['slug' => 'unique-page']);

        // Act & Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->expectException(QueryException::class);

        Page::create([
            'title' => 'Another Page',
            'slug' => 'unique-page', // Same slug
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function itCanHandlePageSoftDelete(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->delete();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertSoftDeleted('pages', ['id' => $page->id]);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /** @test */
    public function itCanRestoreSoftDeletedPage(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        /* @phpstan-ignore-next-line method.nonObject */
        $page->delete();

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->restore();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertNotSoftDeleted('pages', ['id' => $page->id]);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /** @test */
    public function itCanForceDeletePageWithRelatedData(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $content = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Test content',
            'locale' => 'it',
            'version' => 1,
        ]);

        $section = Section::create([
            'page_id' => $page->id,
            'title' => 'Test Section',
            'order' => 1,
            'type' => 'content',
        ]);

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->forceDelete();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseMissing('page_contents', ['id' => $content->id]);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseMissing('sections', ['id' => $section->id]);
    }

    /** @test */
    public function itCanSearchPagesByTitle(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page1 = Page/* @phpstan-ignore-line */ ::factory()->create(['title' => 'Home Page']);
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page2 = Page/* @phpstan-ignore-line */ ::factory()->create(['title' => 'About Us']);
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page3 = Page/* @phpstan-ignore-line */ ::factory()->create(['title' => 'Contact Page']);

        // Act
        $results = Page::where('title', 'like', '%Page%')->get();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(2, $results);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($results->contains($page1));
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($results->contains($page3));
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertFalse($results->contains($page2));
    }

    /** @test */
    public function itCanSearchPagesByStatus(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $publishedPage = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'published']);
        /** @var \Illuminate\Database\Eloquent\Collection */
        $draftPage = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'draft']);
        /** @var \Illuminate\Database\Eloquent\Collection */
        $archivedPage = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'archived']);

        // Act
        $publishedPages = Page::where('status', 'published')->get();
        $draftPages = Page::where('status', 'draft')->get();

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(1, $publishedPages);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(1, $draftPages);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($publishedPages->contains($publishedPage));
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($draftPages->contains($draftPage));
    }

    /** @test */
    public function itCanGetPagesWithRelatedContent(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $content = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Test content',
            'locale' => 'it',
            'version' => 1,
        ]);

        // Act
        $pageWithContent = Page::with('contents')->find($page->id);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertNotNull($pageWithContent);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($pageWithContent->relationLoaded('contents'));
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(1, $pageWithContent->contents);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Test content', $pageWithContent->contents->first()->content);
    }

    /** @test */
    public function itCanGetPagesWithRelatedSections(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $section = Section::create([
            'page_id' => $page->id,
            'title' => 'Test Section',
            'order' => 1,
            'type' => 'content',
        ]);

        // Act
        $pageWithSections = Page::with('sections')->find($page->id);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertNotNull($pageWithSections);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($pageWithSections->relationLoaded('sections'));
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(1, $pageWithSections->sections);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('Test Section', $pageWithSections->sections->first()->title);
    }

    /** @test */
    public function itCanManagePageTemplates(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create(['template' => 'default']);

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update(['template' => 'landing']);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'template' => 'landing',
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertEquals('landing', $page->fresh()->template);
    }

    /** @test */
    public function itCanManagePagePermissions(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $permissions = [
            'view' => true,
            'edit' => false,
            'delete' => false,
        ];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update(['permissions' => $permissions]);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'permissions' => json_encode($permissions),
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertTrue($page->fresh()->permissions['view']);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertFalse($page->fresh()->permissions['edit']);
    }

    /** @test */
    public function itCanManagePageScheduling(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $publishDate = now()->addDays(7);
        $expiryDate = now()->addMonths(6);

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update([
            'publish_at' => $publishDate,
            'expire_at' => $expiryDate,
        ]);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'publish_at' => $publishDate,
            'expire_at' => $expiryDate,
        ]);
    }

    /** @test */
    public function itCanManagePageCategories(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $categories = ['informative', 'services', 'company'];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update(['categories' => $categories]);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'categories' => json_encode($categories),
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertContains('informative', $page->fresh()->categories);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertContains('services', $page->fresh()->categories);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertContains('company', $page->fresh()->categories);
    }

    /** @test */
    public function itCanManagePageTags(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $tags = ['salute', 'dentista', 'milano', 'benessere'];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update(['tags' => $tags]);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'tags' => json_encode($tags),
        ]);

        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertCount(4, $page->fresh()->tags);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertContains('salute', $page->fresh()->tags);
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertContains('dentista', $page->fresh()->tags);
    }

    /** @test */
    public function itCanManagePageRedirects(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $redirectData = [
            'redirect_type' => '301',
            'redirect_url' => 'https://'.config('app.domain', 'example.com').'/nuova-pagina',
            'redirect_reason' => 'Page moved permanently',
        ];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update($redirectData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'redirect_type' => '301',
            'redirect_url' => 'https://'.config('app.domain', 'example.com').'/nuova-pagina',
            'redirect_reason' => 'Page moved permanently',
        ]);
    }

    /** @test */
    public function itCanManagePageAnalytics(): void
    {
        // Arrange
        /** @var \Illuminate\Database\Eloquent\Collection */
        $page = Page/* @phpstan-ignore-line */ ::factory()->create();
        $analyticsData = [
            'page_views' => 1250,
            'unique_visitors' => 890,
            'bounce_rate' => 45.2,
            'avg_time_on_page' => 180,
        ];

        // Act
        /* @phpstan-ignore-next-line method.nonObject */
        $page->update($analyticsData);

        // Assert
        /* @phpstan-ignore-next-line property.notFound, method.nonObject */
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'page_views' => 1250,
            'unique_visitors' => 890,
            'bounce_rate' => 45.2,
            'avg_time_on_page' => 180,
        ]);
    }
}
