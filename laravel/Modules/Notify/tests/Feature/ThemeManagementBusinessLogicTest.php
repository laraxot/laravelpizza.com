<?php

declare(strict_types=1);

use Modules\Notify\Models\Theme;
use Modules\Notify\Helpers\ConfigHelper;

describe('Theme Management Business Logic', function () {
    it('can create theme with basic information', function () {
        $testData = ConfigHelper::getTestData();
        
        $themeData = [
            'name' => $testData['theme_name'] ?? (config('app.name', 'Our Platform') . ' Professional'),
            'description' => $testData['theme_description'] ?? ('Tema professionale per ' . config('app.name', 'Our Platform')),
            'version' => '1.0.0',
            'is_active' => true,
        ];

        $theme = Theme::create($themeData);

        expect($theme)->toBeInstanceOf(Theme::class)
            ->and($theme->name)->toBe($themeData['name'])
            ->and($theme->description)->toBe($themeData['description'])
            ->and($theme->version)->toBe('1.0.0')
            ->and($theme->is_active)->toBeTrue();

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'name' => $themeData['name'],
            'description' => $themeData['description'],
            'version' => '1.0.0',
            'is_active' => true,
        ]);
    });

    it('can manage theme colors', function () {
        $theme = Theme::factory()->create();
        $colors = [
            'primary' => '#001F3F',
            'secondary' => '#3B82F6',
            'accent' => '#F59E0B',
            'success' => '#10B981',
            'warning' => '#F59E0B',
            'error' => '#EF4444',
            'background' => '#FFFFFF',
            'text' => '#1F2937',
            'border' => '#E5E7EB',
        ];

        $theme->update(['colors' => $colors]);

        expect($theme->fresh()->colors['primary'])->toBe('#001F3F')
            ->and($theme->fresh()->colors['secondary'])->toBe('#3B82F6')
            ->and($theme->fresh()->colors['accent'])->toBe('#F59E0B')
            ->and($theme->fresh()->colors['success'])->toBe('#10B981')
            ->and($theme->fresh()->colors['error'])->toBe('#EF4444')
            ->and($theme->fresh()->colors['background'])->toBe('#FFFFFF')
            ->and($theme->fresh()->colors['text'])->toBe('#1F2937');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'colors' => json_encode($colors),
        ]);
    });

    it('can manage theme fonts', function () {
        $theme = Theme::factory()->create();
        $fonts = [
            'heading' => 'Segoe UI, Arial, sans-serif',
            'body' => 'Georgia, serif',
            'monospace' => 'Consolas, Monaco, monospace',
            'fallback' => 'Arial, sans-serif',
            'sizes' => [
                'xs' => '0.75rem',
                'sm' => '0.875rem',
                'base' => '1rem',
                'lg' => '1.125rem',
                'xl' => '1.25rem',
                '2xl' => '1.5rem',
                '3xl' => '1.875rem',
            ],
        ];

        $theme->update(['fonts' => $fonts]);

        expect($theme->fresh()->fonts['heading'])->toBe('Segoe UI, Arial, sans-serif')
            ->and($theme->fresh()->fonts['body'])->toBe('Georgia, serif')
            ->and($theme->fresh()->fonts['monospace'])->toBe('Consolas, Monaco, monospace')
            ->and($theme->fresh()->fonts['sizes']['base'])->toBe('1rem')
            ->and($theme->fresh()->fonts['sizes']['2xl'])->toBe('1.5rem');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'fonts' => json_encode($fonts),
        ]);
    });

    it('can manage theme spacing', function () {
        $theme = Theme::factory()->create();
        $spacing = [
            'xs' => '0.25rem',
            'sm' => '0.5rem',
            'md' => '1rem',
            'lg' => '1.5rem',
            'xl' => '2rem',
            '2xl' => '3rem',
            '3xl' => '4rem',
            'auto' => 'auto',
        ];

        $theme->update(['spacing' => $spacing]);

        expect($theme->fresh()->spacing['xs'])->toBe('0.25rem')
            ->and($theme->fresh()->spacing['md'])->toBe('1rem')
            ->and($theme->fresh()->spacing['xl'])->toBe('2rem')
            ->and($theme->fresh()->spacing['3xl'])->toBe('4rem');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'spacing' => json_encode($spacing),
        ]);
    });

    it('can manage theme border radius', function () {
        $theme = Theme::factory()->create();
        $borderRadius = [
            'none' => '0',
            'sm' => '0.125rem',
            'base' => '0.25rem',
            'md' => '0.375rem',
            'lg' => '0.5rem',
            'xl' => '0.75rem',
            '2xl' => '1rem',
            'full' => '9999px',
        ];

        $theme->update(['border_radius' => $borderRadius]);

        expect($theme->fresh()->border_radius['none'])->toBe('0')
            ->and($theme->fresh()->border_radius['base'])->toBe('0.25rem')
            ->and($theme->fresh()->border_radius['lg'])->toBe('0.5rem')
            ->and($theme->fresh()->border_radius['full'])->toBe('9999px');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'border_radius' => json_encode($borderRadius),
        ]);
    });

    it('can manage theme shadows', function () {
        $theme = Theme::factory()->create();
        $shadows = [
            'none' => 'none',
            'sm' => '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
            'base' => '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
            'md' => '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            'lg' => '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            'xl' => '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        ];

        $theme->update(['shadows' => $shadows]);

        expect($theme->fresh()->shadows['none'])->toBe('none')
            ->and($theme->fresh()->shadows['sm'])->toBe('0 1px 2px 0 rgba(0, 0, 0, 0.05)')
            ->and($theme->fresh()->shadows['xl'])->toBe('0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'shadows' => json_encode($shadows),
        ]);
    });

    it('can manage theme breakpoints', function () {
        $theme = Theme::factory()->create();
        $breakpoints = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
            'xl' => '1280px',
            '2xl' => '1536px',
        ];

        $theme->update(['breakpoints' => $breakpoints]);

        expect($theme->fresh()->breakpoints['sm'])->toBe('640px')
            ->and($theme->fresh()->breakpoints['md'])->toBe('768px')
            ->and($theme->fresh()->breakpoints['lg'])->toBe('1024px')
            ->and($theme->fresh()->breakpoints['xl'])->toBe('1280px')
            ->and($theme->fresh()->breakpoints['2xl'])->toBe('1536px');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'breakpoints' => json_encode($breakpoints),
        ]);
    });

    it('can manage theme animations', function () {
        $theme = Theme::factory()->create();
        $animations = [
            'fade_in' => 'fadeIn 0.3s ease-in-out',
            'slide_up' => 'slideUp 0.3s ease-out',
            'slide_down' => 'slideDown 0.3s ease-out',
            'scale_in' => 'scaleIn 0.2s ease-out',
            'bounce' => 'bounce 1s infinite',
            'pulse' => 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        ];

        $theme->update(['animations' => $animations]);

        expect($theme->fresh()->animations['fade_in'])->toBe('fadeIn 0.3s ease-in-out')
            ->and($theme->fresh()->animations['slide_up'])->toBe('slideUp 0.3s ease-out')
            ->and($theme->fresh()->animations['bounce'])->toBe('bounce 1s infinite')
            ->and($theme->fresh()->animations['pulse'])->toBe('pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'animations' => json_encode($animations),
        ]);
    });

    it('can manage theme transitions', function () {
        $theme = Theme::factory()->create();
        $transitions = [
            'default' => 'all 0.3s ease',
            'fast' => 'all 0.15s ease',
            'slow' => 'all 0.5s ease',
            'colors' => 'color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease',
            'opacity' => 'opacity 0.3s ease',
            'transform' => 'transform 0.3s ease',
        ];

        $theme->update(['transitions' => $transitions]);

        expect($theme->fresh()->transitions['default'])->toBe('all 0.3s ease')
            ->and($theme->fresh()->transitions['fast'])->toBe('all 0.15s ease')
            ->and($theme->fresh()->transitions['slow'])->toBe('all 0.5s ease')
            ->and($theme->fresh()->transitions['colors'])->toBe('color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'transitions' => json_encode($transitions),
        ]);
    });

    it('can manage theme components', function () {
        $theme = Theme::factory()->create();
        $components = [
            'button' => [
                'primary' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded',
                'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded',
                'outline' => 'border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded',
            ],
            'card' => [
                'base' => 'bg-white rounded-lg shadow-md p-6',
                'elevated' => 'bg-white rounded-lg shadow-xl p-6',
                'bordered' => 'bg-white rounded-lg border border-gray-200 p-6',
            ],
            'input' => [
                'base' => 'border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                'error' => 'border border-red-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500',
                'success' => 'border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500',
            ],
        ];

        $theme->update(['components' => $components]);

        expect($theme->fresh()->components['button']['primary'])->toBe('bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded')
            ->and($theme->fresh()->components['card']['base'])->toBe('bg-white rounded-lg shadow-md p-6')
            ->and($theme->fresh()->components['input']['base'])->toBe('border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'components' => json_encode($components),
        ]);
    });

    it('can manage theme utilities', function () {
        $theme = Theme::factory()->create();
        $utilities = [
            'text_align' => [
                'left' => 'text-left',
                'center' => 'text-center',
                'right' => 'text-right',
                'justify' => 'text-justify',
            ],
            'display' => [
                'block' => 'block',
                'inline' => 'inline',
                'inline_block' => 'inline-block',
                'flex' => 'flex',
                'grid' => 'grid',
                'hidden' => 'hidden',
            ],
            'position' => [
                'static' => 'static',
                'relative' => 'relative',
                'absolute' => 'absolute',
                'fixed' => 'fixed',
                'sticky' => 'sticky',
            ],
        ];

        $theme->update(['utilities' => $utilities]);

        expect($theme->fresh()->utilities['text_align']['left'])->toBe('text-left')
            ->and($theme->fresh()->utilities['text_align']['center'])->toBe('text-center')
            ->and($theme->fresh()->utilities['display']['flex'])->toBe('flex')
            ->and($theme->fresh()->utilities['position']['relative'])->toBe('relative');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'utilities' => json_encode($utilities),
        ]);
    });

    it('can manage theme metadata', function () {
        $testData = ConfigHelper::getTestData();
        $theme = Theme::factory()->create();
        $metadata = [
            'author' => $testData['team_name'] ?? ('Team ' . config('app.name', 'Our Platform')),
            'created_date' => '2024-01-15',
            'last_modified' => '2024-12-01',
            'tags' => ['professional', 'healthcare', 'modern'],
            'category' => 'business',
            'compatibility' => ['Laravel 10', 'PHP 8.2+'],
            'license' => 'MIT',
            'repository' => $testData['repository_url'] ?? ('https://github.com/' . strtolower(config('app.name', 'ourplatform')) . '/themes'),
        ];

        $theme->update(['metadata' => $metadata]);

        expect($theme->fresh()->metadata['author'])->toBe($metadata['author'])
            ->and($theme->fresh()->metadata['created_date'])->toBe('2024-01-15')
            ->and($theme->fresh()->metadata['category'])->toBe('business')
            ->and($theme->fresh()->metadata['license'])->toBe('MIT')
            ->and($theme->fresh()->metadata['compatibility'])->toContain('Laravel 10')
            ->and($theme->fresh()->metadata['tags'])->toContain('professional');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'metadata' => json_encode($metadata),
        ]);
    });

    it('can manage theme settings', function () {
        $theme = Theme::factory()->create();
        $settings = [
            'dark_mode' => true,
            'rtl_support' => false,
            'accessibility' => true,
            'performance_optimization' => true,
            'cache_enabled' => true,
            'minify_css' => true,
            'minify_js' => true,
            'image_optimization' => true,
        ];

        $theme->update(['settings' => $settings]);

        expect($theme->fresh()->settings['dark_mode'])->toBeTrue()
            ->and($theme->fresh()->settings['rtl_support'])->toBeFalse()
            ->and($theme->fresh()->settings['accessibility'])->toBeTrue()
            ->and($theme->fresh()->settings['performance_optimization'])->toBeTrue()
            ->and($theme->fresh()->settings['cache_enabled'])->toBeTrue()
            ->and($theme->fresh()->settings['minify_css'])->toBeTrue();

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'settings' => json_encode($settings),
        ]);
    });

    it('can activate and deactivate theme', function () {
        $theme = Theme::factory()->create(['is_active' => true]);

        // Deactivate
        $theme->update(['is_active' => false]);

        expect($theme->fresh()->is_active)->toBeFalse();

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'is_active' => false,
        ]);

        // Activate
        $theme->update(['is_active' => true]);

        expect($theme->fresh()->is_active)->toBeTrue();
    });

    it('can manage theme versions', function () {
        $theme = Theme::factory()->create(['version' => '1.0.0']);
        $versionData = [
            'version' => '1.1.0',
            'changelog' => [
                'Added dark mode support',
                'Improved accessibility features',
                'Fixed responsive design issues',
                'Updated color palette',
            ],
            'is_current' => true,
        ];

        $theme->update($versionData);

        expect($theme->fresh()->version)->toBe('1.1.0')
            ->and($theme->fresh()->is_current)->toBeTrue()
            ->and($theme->fresh()->changelog)->toHaveCount(4)
            ->and($theme->fresh()->changelog[0])->toBe('Added dark mode support')
            ->and($theme->fresh()->changelog[3])->toBe('Updated color palette');

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'version' => '1.1.0',
            'is_current' => true,
        ]);
    });

    it('can search themes by category', function () {
        $businessTheme = Theme::factory()->create([
            'metadata' => ['category' => 'business']
        ]);
        $healthcareTheme = Theme::factory()->create([
            'metadata' => ['category' => 'healthcare']
        ]);
        $modernTheme = Theme::factory()->create([
            'metadata' => ['category' => 'modern']
        ]);

        $businessThemes = Theme::whereJsonContains('metadata->category', 'business')->get();
        $healthcareThemes = Theme::whereJsonContains('metadata->category', 'healthcare')->get();

        expect($businessThemes)->toHaveCount(1)
            ->and($healthcareThemes)->toHaveCount(1)
            ->and($businessThemes->contains($businessTheme))->toBeTrue()
            ->and($healthcareThemes->contains($healthcareTheme))->toBeTrue();
    });

    it('can search themes by tags', function () {
        $professionalTheme = Theme::factory()->create([
            'metadata' => ['tags' => ['professional', 'business']]
        ]);
        $modernTheme = Theme::factory()->create([
            'metadata' => ['tags' => ['modern', 'clean']]
        ]);

        $professionalThemes = Theme::whereJsonContains('metadata->tags', 'professional')->get();
        $modernThemes = Theme::whereJsonContains('metadata->tags', 'modern')->get();

        expect($professionalThemes)->toHaveCount(1)
            ->and($modernThemes)->toHaveCount(1)
            ->and($professionalThemes->contains($professionalTheme))->toBeTrue()
            ->and($modernThemes->contains($modernTheme))->toBeTrue();
    });

    it('can search themes by status', function () {
        $activeTheme = Theme::factory()->create(['is_active' => true]);
        $inactiveTheme = Theme::factory()->create(['is_active' => false]);

        $activeThemes = Theme::where('is_active', true)->get();
        $inactiveThemes = Theme::where('is_active', false)->get();

        expect($activeThemes)->toHaveCount(1)
            ->and($inactiveThemes)->toHaveCount(1)
            ->and($activeThemes->contains($activeTheme))->toBeTrue()
            ->and($inactiveThemes->contains($inactiveTheme))->toBeTrue();
    });

    it('can manage theme duplication', function () {
        $originalTheme = Theme::factory()->create([
            'name' => 'Original Theme',
            'version' => '1.0.0',
        ]);

        $duplicateTheme = $originalTheme->replicate();
        $duplicateTheme->name = 'Duplicate Theme';
        $duplicateTheme->version = '1.0.1';
        $duplicateTheme->save();

        expect($duplicateTheme->id)->not->toBe($originalTheme->id)
            ->and($duplicateTheme->name)->toBe('Duplicate Theme')
            ->and($duplicateTheme->version)->toBe('1.0.1');

        $this->assertDatabaseHas('themes', [
            'id' => $duplicateTheme->id,
            'name' => 'Duplicate Theme',
            'version' => '1.0.1',
        ]);
    });

    it('can manage theme archiving', function () {
        $theme = Theme::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo tema',
            'replacement_theme_id' => 25,
        ];

        $theme->update($archiveData);

        expect($theme->fresh()->is_active)->toBeFalse()
            ->and($theme->fresh()->archived_at)->not->toBeNull()
            ->and($theme->fresh()->archive_reason)->toBe('Sostituito da nuovo tema')
            ->and($theme->fresh()->replacement_theme_id)->toBe(25);

        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'is_active' => false,
            'archived_at' => $theme->archived_at,
            'archive_reason' => 'Sostituito da nuovo tema',
            'replacement_theme_id' => 25,
        ]);
    });
});
