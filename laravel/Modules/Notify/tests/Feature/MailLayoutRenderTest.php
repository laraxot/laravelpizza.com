<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Actions\Theme\GetThemeContextAction;
use Modules\Xot\Datas\XotData;

require_once __DIR__ . '/../TestCase.php';

class MailLayoutRenderTest extends TestCase
{
    public function test_it_resolves_christmas_professional_layout_when_context_is_christmas(): void
    {
        // Arrange
        Config::set('xra.main_module', 'Notify');

        // Mock XotData to return 'Sixteen' as pub_theme if needed
        // Assuming the test environment sets up XotData correctly or uses config
        // But XotData::make() usually reads from config or DB.
        // Let's force config 'xra.pub_theme' or mock XotData if possible.
        // Config 'xra.pub_theme' usually key.
        Config::set('xra.pub_theme', 'Sixteen');

        // Mock GetThemeContextAction to return 'christmas'
        $this->mock(GetThemeContextAction::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn('christmas');

        // Act
        /** @var GetMailLayoutAction $action */
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute(); // defaults to 'base'

        // Assert
        // Should contain specific strings from christmas-professional.html
        $this->assertStringContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%);', $html, 'Should use the professional red gradient');

        // Check for VML fallback which signals the new template update
        $this->assertStringContainsString('<!--[if mso]>', $html, 'Should contain VML comments for Outlook');
        $this->assertStringContainsString('<v:rect xmlns:v="urn:schemas-microsoft-com:vml"', $html, 'Should contain VML rect tag');

        // Check for Mustache variables
        $this->assertStringContainsString('{{{ body }}}', $html, 'Should contain body placeholder');
        $this->assertStringContainsString('{{ company_name }}', $html, 'Should contain company_name placeholder');
    }

    public function test_it_falls_back_to_base_when_not_christmas(): void
    {
        // Arrange
        Config::set('xra.pub_theme', 'Sixteen');

        $this->mock(GetThemeContextAction::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn('default');

        // Act
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute();

        // Assert
        // Should NOT contain VML if base.html doesn't have it (or at least different content)
        // base.html usually simple.
        $this->assertStringContainsString('{{{ body }}}', $html);
        // Ensure it didn't pick the christmas one
        $this->assertStringNotContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%);', $html);
    }

    public function test_it_resolves_christmas_festive_layout_with_vml(): void
    {
        // Arrange
        Config::set('xra.pub_theme', 'Sixteen');

        // For this test, we want to force the 'festive' context if possible,
        // OR we can explicitly ask for the festive layout by name if the Action supported it directly.
        // But the Action logic is: candidates = [baseName_context, context, base].
        // So if we set context='christmas-festive' it might look for 'christmas-festive.html'.
        // Let's assume GetThemeContextAction returns 'christmas-festive'.
        $this->mock(GetThemeContextAction::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn('christmas-festive');

        // Act
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute();

        // Assert
        // The festive layout has green gradient in VML
        $this->assertStringContainsString('<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"', $html, 'Should contain Festive VML gradient');
        $this->assertStringContainsString('<!--[if mso]>', $html);
    }
}
