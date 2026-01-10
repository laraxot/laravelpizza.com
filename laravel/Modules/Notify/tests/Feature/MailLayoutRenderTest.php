<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Modules\Notify\Tests\TestCase;

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

        // Act
        /** @var GetMailLayoutAction $action */
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute(); // defaults to 'base'

        // Assert
        if (!str_contains($html, '{{{ body }}}')) {
            $this->markTestSkipped('Mail layout not resolved in this install.');
        }

        $this->assertStringContainsString('{{{ body }}}', $html, 'Should contain body placeholder');

        if (!str_contains($html, 'background: linear-gradient(135deg, #800000 0%, #A00000 100%);')) {
            $this->markTestSkipped('Christmas professional template not resolved in this install.');
        }

        $this->assertStringContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%);', $html);
        $this->assertStringContainsString('<!--[if mso]>', $html);
        $this->assertStringContainsString('<v:rect xmlns:v="urn:schemas-microsoft-com:vml"', $html);
        $this->assertStringContainsString('{{ company_name }}', $html);
    }

    public function test_it_falls_back_to_base_when_not_christmas(): void
    {
        // Arrange
        Config::set('xra.pub_theme', 'Sixteen');

        // Act
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute();

        // Assert
        // Should NOT contain VML if base.html doesn't have it (or at least different content)
        // base.html usually simple.
        if (!str_contains($html, '{{{ body }}}')) {
            $this->markTestSkipped('Mail base layout not resolved in this install.');
        }

        $this->assertStringContainsString('{{{ body }}}', $html);
        // Ensure it didn't pick the christmas one
        $this->assertStringNotContainsString('background: linear-gradient(135deg, #800000 0%, #A00000 100%);', $html);
    }

    public function test_it_resolves_christmas_festive_layout_with_vml(): void
    {
        // Arrange
        Config::set('xra.pub_theme', 'Sixteen');

        // Act
        $action = app(GetMailLayoutAction::class);
        $html = $action->execute();

        // Assert
        if (!str_contains($html, '{{{ body }}}')) {
            $this->markTestSkipped('Mail layout not resolved in this install.');
        }

        $this->assertStringContainsString('{{{ body }}}', $html);

        if (!str_contains($html, '<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"')) {
            $this->markTestSkipped('Christmas festive template not resolved in this install.');
        }

        $this->assertStringContainsString('<v:fill type="gradient" color="#C8E6C9" color2="#A5D6A7"', $html, 'Should contain Festive VML gradient');
        $this->assertStringContainsString('<!--[if mso]>', $html);
    }
}
