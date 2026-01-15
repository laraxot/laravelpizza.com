# Test Editor WYSIWYG Email - il progetto

## Test Unitari

### 1. EmailEditor Component

```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Filament\Forms\Components\EmailEditor;

class EmailEditorTest extends TestCase
{
    /** @test */
    public function it_sanitizes_html_input()
    {
        $editor = new EmailEditor('html_template');
        
        $dirtyHtml = '<script>alert("xss")</script><p>Test</p>';
        $cleanHtml = $editor->sanitizeHtml($dirtyHtml);
        
        $this->assertStringNotContainsString('<script>', $cleanHtml);
        $this->assertStringContainsString('<p>Test</p>', $cleanHtml);
    }

    /** @test */
    public function it_handles_state_hydration()
    {
        $editor = new EmailEditor('html_template');
        $state = '<p>Test</p>';
        
        $editor->state($state);
        
        $this->assertEquals($state, $editor->getState());
    }
}
```

### 2. Block Components

```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Filament\Forms\Components\Blocks\ButtonBlock;
use Modules\Notify\Filament\Forms\Components\Blocks\ImageBlock;

class BlockComponentsTest extends TestCase
{
    /** @test */
    public function button_block_validates_required_fields()
    {
        $block = ButtonBlock::make();
        
        $this->assertTrue($block->getSchema()->get('text')->isRequired());
        $this->assertTrue($block->getSchema()->get('url')->isRequired());
    }

    /** @test */
    public function image_block_validates_file_upload()
    {
        $block = ImageBlock::make();
        
        $this->assertTrue($block->getSchema()->get('image')->isRequired());
        $this->assertTrue($block->getSchema()->get('image')->isImage());
    }
}
```

## Test Feature

### 1. Editor Integration

```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\Notify\Filament\Resources\MailTemplateResource;

class EditorIntegrationTest extends TestCase
{
    /** @test */
    public function it_updates_preview_on_content_change()
    {
        Livewire::test(MailTemplateResource::class)
            ->set('html_template', '<p>Test</p>')
            ->assertSet('preview', function ($preview) {
                return str_contains($preview, '<p>Test</p>');
            });
    }

    /** @test */
    public function it_validates_template_structure()
    {
        Livewire::test(MailTemplateResource::class)
            ->set('html_template', '<invalid>')
            ->call('save')
            ->assertHasErrors(['html_template']);
    }
}
```

### 2. Component Actions

```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\Notify\Models\MailTemplate;

class ComponentActionsTest extends TestCase
{
    /** @test */
    public function it_sends_test_email()
    {
        $template = MailTemplate::factory()->create();
        
        Livewire::test(MailTemplateResource::class)
            ->call('test', [
                'email' => 'test@example.com',
                'template_id' => $template->id
            ])
            ->assertEmitted('test-email-sent');
    }

    /** @test */
    public function it_duplicates_template()
    {
        $template = MailTemplate::factory()->create();
        
        Livewire::test(MailTemplateResource::class)
            ->call('duplicate', $template->id)
            ->assertEmitted('template-duplicated');
            
        $this->assertDatabaseCount('mail_templates', 2);
    }
}
```

## Test Browser

### 1. Editor UI

```php
namespace Modules\Notify\Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class EditorUITest extends DuskTestCase
{
    /** @test */
    public function it_renders_editor_interface()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/mail-templates/create')
                ->assertSee('Editor')
                ->assertSee('Preview')
                ->assertSee('Components');
        });
    }

    /** @test */
    public function it_handles_drag_and_drop()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/mail-templates/create')
                ->drag('.component-button', '.editor-content')
                ->assertSee('Button Component');
        });
    }
}
```

### 2. Preview Functionality

```php
namespace Modules\Notify\Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class PreviewTest extends DuskTestCase
{
    /** @test */
    public function it_updates_preview_in_real_time()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/mail-templates/create')
                ->type('@editor', '<p>Test</p>')
                ->assertSeeIn('@preview', 'Test');
        });
    }

    /** @test */
    public function it_shows_mobile_preview()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/mail-templates/create')
                ->click('@mobile-preview')
                ->assertSee('Mobile Preview');
        });
    }
}
```

## Test Performance

### 1. Editor Performance

```php
namespace Modules\Notify\Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class EditorPerformanceTest extends TestCase
{
    /** @test */
    public function it_handles_large_templates()
    {
        $start = microtime(true);
        
        $editor = new EmailEditor('html_template');
        $editor->state($this->getLargeTemplate());
        
        $time = microtime(true) - $start;
        
        $this->assertLessThan(1.0, $time);
    }

    /** @test */
    public function it_optimizes_image_uploads()
    {
        $start = microtime(true);
        
        $manager = new EmailAssetManager();
        $manager->uploadImage($this->getLargeImage());
        
        $time = microtime(true) - $start;
        
        $this->assertLessThan(2.0, $time);
    }
}
```

### 2. Preview Performance

```php
namespace Modules\Notify\Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class PreviewPerformanceTest extends TestCase
{
    /** @test */
    public function it_caches_preview_rendering()
    {
        $start = microtime(true);
        
        $preview = new EmailPreview('preview');
        $preview->renderPreview($this->getTemplate());
        
        $time = microtime(true) - $start;
        
        $this->assertLessThan(0.5, $time);
        $this->assertTrue(Cache::has('preview_' . md5($this->getTemplate())));
    }
}
```

## Test Security

### 1. XSS Prevention

```php
namespace Modules\Notify\Tests\Security;

use Tests\TestCase;

class XSSPreventionTest extends TestCase
{
    /** @test */
    public function it_prevents_xss_attacks()
    {
        $editor = new EmailEditor('html_template');
        
        $maliciousInput = [
            '<script>alert("xss")</script>',
            '<img src="x" onerror="alert(\'xss\')">',
            '<a href="javascript:alert(\'xss\')">Click</a>'
        ];
        
        foreach ($maliciousInput as $input) {
            $clean = $editor->sanitizeHtml($input);
            $this->assertStringNotContainsString('script', $clean);
            $this->assertStringNotContainsString('javascript:', $clean);
        }
    }
}
```

### 2. File Upload Security

```php
namespace Modules\Notify\Tests\Security;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FileUploadSecurityTest extends TestCase
{
    /** @test */
    public function it_validates_uploaded_files()
    {
        $manager = new EmailAssetManager();
        
        $invalidFiles = [
            UploadedFile::fake()->create('test.exe', 100),
            UploadedFile::fake()->create('test.php', 100),
            UploadedFile::fake()->image('test.jpg')->size(10000)
        ];
        
        foreach ($invalidFiles as $file) {
            $this->expectException(\Exception::class);
            $manager->uploadImage($file);
        }
    }
}
```

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Testing Documentation](https://laravel.com/project_docs/testing)
- [Dusk Documentation](https://laravel.com/project_docs/dusk)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Dusk Documentation](https://laravel.com/docs/dusk)
- [PHPUnit Documentation](https://phpunit.de/documentation.html) 