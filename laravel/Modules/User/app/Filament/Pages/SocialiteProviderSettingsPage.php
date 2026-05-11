<?php

declare(strict_types=1);

// ⚠️ CRITICAL RULE: NEVER use ->label(), ->placeholder(), ->helperText()
// Translations are handled automatically by LangServiceProvider via 5-level keys:
// user::socialite.settings.form.{field}.{type}
// See: .windsurf/rules/no-filament-labels.mdc

namespace Modules\User\Filament\Pages;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Pages\XotBasePage;

use function Safe\chmod;

/**
 * Socialite OAuth Provider Settings Page.
 *
 * Allows administrators to configure OAuth providers (Google, GitHub, etc.)
 * via Filament backoffice UI without editing .env files.
 *
 * Configuration is stored in: storage/app/private/socialite-config.php
 * This file is loaded by SocialiteServiceProvider at boot time.
 *
 * @see https://developers.google.com/identity/protocols/oauth2/web-server
 * @see laravel/Modules/User/docs/wiki/concepts/socialite-admin-configuration.md
 */
class SocialiteProviderSettingsPage extends XotBasePage
{
    // Navigation properties are inherited from XotBasePage, no need to redeclare

    /**
     * Form data array for each provider.
     *
     * @var array<string, mixed>
     */
    public array $google = [];

    /**
     * @var array<string, mixed>
     */
    public array $github = [];

    /**
     * @var array<string, mixed>
     */
    public array $microsoft = [];

    /**
     * Mount the page and load current configuration.
     */
    public function mount(): void
    {
        $this->loadProviderConfigs();
    }

    /**
     * Define the form schema for provider configuration.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Google OAuth')
                    ->description('Configura il login con Google. Crea credenziali su Google Cloud Console.')
                    ->icon('ui-google')
                    ->collapsible()
                    ->schema([
                        Toggle::make('google.enabled'),

                        TextInput::make('google.client_id')
                            ->placeholder('xxx.apps.googleusercontent.com')
                            ->visible(fn (Get $get): bool => true === $get('google.enabled')),

                        TextInput::make('google.client_secret')
                            ->password()
                            ->revealable()
                            ->placeholder('GOCSPX-xxx')
                            ->dehydrateStateUsing(fn (mixed $state): string => $this->isMasked($state)
                                 ? $this->configString('services.google.client_secret')
                                 : $this->stringValue($state))
                            ->visible(fn (Get $get): bool => true === $get('google.enabled')),

                        TagsInput::make('google.scopes')
                            ->placeholder('openid, email, profile')
                            ->visible(fn (Get $get): bool => true === $get('google.enabled')),

                        TextInput::make('google.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'google'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn (Get $get): bool => true === $get('google.enabled')),
                    ]),

                Section::make('GitHub OAuth')
                    ->description('Configura il login con GitHub. Crea OAuth App su GitHub Settings.')
                    ->icon('fab-github')
                    ->collapsible()
                    ->schema([
                        Toggle::make('github.enabled'),

                        TextInput::make('github.client_id')
                            ->placeholder('Iv23lixxx')
                            ->visible(fn (Get $get): bool => true === $get('github.enabled')),

                        TextInput::make('github.client_secret')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn (mixed $state): string => $this->isMasked($state)
                                 ? $this->configString('services.github.client_secret')
                                 : $this->stringValue($state))
                            ->visible(fn (Get $get): bool => true === $get('github.enabled')),

                        TagsInput::make('github.scopes')
                            ->placeholder('read:user, user:email')
                            ->visible(fn (Get $get): bool => true === $get('github.enabled')),

                        TextInput::make('github.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'github'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn (Get $get): bool => true === $get('github.enabled')),
                    ]),

                Section::make('Microsoft OAuth')
                    ->description('Configura il login con Microsoft/Azure AD.')
                    ->icon('ui-brands.microsoft')
                    ->collapsible()
                    ->schema([
                        Toggle::make('microsoft.enabled'),

                        TextInput::make('microsoft.client_id')
                            ->placeholder('xxx-xxx-xxx-xxx')
                            ->visible(fn (Get $get): bool => true === $get('microsoft.enabled')),

                        TextInput::make('microsoft.client_secret')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn (mixed $state): string => $this->isMasked($state)
                                 ? $this->configString('services.microsoft.client_secret')
                                 : $this->stringValue($state))
                            ->visible(fn (Get $get): bool => true === $get('microsoft.enabled')),

                        TagsInput::make('microsoft.scopes')
                            ->placeholder('User.Read, openid, email')
                            ->visible(fn (Get $get): bool => true === $get('microsoft.enabled')),

                        TextInput::make('microsoft.redirect')
                            ->default(fn () => route('socialite.oauth.callback', 'microsoft'))
                            ->disabled()
                            ->copyable()
                            ->visible(fn (Get $get): bool => true === $get('microsoft.enabled')),
                    ]),
            ])
            ->statePath('data');
    }

    /**
     * Save the configuration to secure file.
     */
    public function save(): void
    {
        $data = $this->form->getState();

        // Build config array for each provider
        $config = [];

        if (isset($data['google']) && is_array($data['google'])) {
            $google = $this->providerData($data['google']);
            $config['google'] = [
                'enabled' => ($google['enabled'] ?? false) === true,
                'client_id' => $this->stringValue($google['client_id'] ?? ''),
                'client_secret' => $this->resolveSecret(
                    $google['client_secret'] ?? '',
                    config('services.google.client_secret'),
                ),
                'redirect' => route('socialite.oauth.callback', 'google'),
                'scopes' => $this->stringList($google['scopes'] ?? ['openid', 'email', 'profile']),
            ];
        }

        if (isset($data['github']) && is_array($data['github'])) {
            $github = $this->providerData($data['github']);
            $config['github'] = [
                'enabled' => ($github['enabled'] ?? false) === true,
                'client_id' => $this->stringValue($github['client_id'] ?? ''),
                'client_secret' => $this->resolveSecret(
                    $github['client_secret'] ?? '',
                    config('services.github.client_secret'),
                ),
                'redirect' => route('socialite.oauth.callback', 'github'),
                'scopes' => $this->stringList($github['scopes'] ?? ['read:user', 'user:email']),
            ];
        }

        if (isset($data['microsoft']) && is_array($data['microsoft'])) {
            $microsoft = $this->providerData($data['microsoft']);
            $config['microsoft'] = [
                'enabled' => ($microsoft['enabled'] ?? false) === true,
                'client_id' => $this->stringValue($microsoft['client_id'] ?? ''),
                'client_secret' => $this->resolveSecret(
                    $microsoft['client_secret'] ?? '',
                    config('services.microsoft.client_secret'),
                ),
                'redirect' => route('socialite.oauth.callback', 'microsoft'),
                'scopes' => $this->stringList($microsoft['scopes'] ?? ['User.Read', 'openid', 'email']),
            ];
        }

        // Write to secure config file
        $this->writeSocialiteConfig($config);

        // Clear config cache
        Artisan::call('config:clear');

        // Update SocialProvider Sushi model active states
        $this->updateSocialProviderActiveStates($config);

        // Show success notification
        Notification::make()
            ->title(__('user::socialite.messages.config_saved'))
            ->success()
            ->send();
    }

    /**
     * Load current configuration for all providers.
     */
    private function loadProviderConfigs(): void
    {
        $this->google = [
            'enabled' => $this->configBool('services.google.enabled'),
            'client_id' => $this->configString('services.google.client_id'),
            'client_secret' => $this->maskSecret(config('services.google.client_secret')),
            'scopes' => $this->configStringList('services.google.scopes', ['openid', 'email', 'profile']),
        ];

        $this->github = [
            'enabled' => $this->configBool('services.github.enabled'),
            'client_id' => $this->configString('services.github.client_id'),
            'client_secret' => $this->maskSecret(config('services.github.client_secret')),
            'scopes' => $this->configStringList('services.github.scopes', ['read:user', 'user:email']),
        ];

        $this->microsoft = [
            'enabled' => $this->configBool('services.microsoft.enabled'),
            'client_id' => $this->configString('services.microsoft.client_id'),
            'client_secret' => $this->maskSecret(config('services.microsoft.client_secret')),
            'scopes' => $this->configStringList('services.microsoft.scopes', ['User.Read', 'openid', 'email']),
        ];
    }

    /**
     * Write configuration to secure PHP file.
     *
     * @param array<string, mixed> $config
     */
    private function writeSocialiteConfig(array $config): void
    {
        $path = storage_path('app/private/socialite-config.php');

        // Ensure directory exists with secure permissions
        $dir = dirname($path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0750, true);
        }

        // Generate PHP file content
        $content = "<?php\n\ndeclare(strict_types=1);\n\nreturn ".var_export($config, true).";\n";

        // Write file
        File::put($path, $content);

        // Set secure permissions (owner read/write, group read, others none)
        chmod($path, 0640);
    }

    /**
     * Update SocialProvider model active states.
     *
     * @param array<string, array<string, mixed>> $config
     */
    private function updateSocialProviderActiveStates(array $config): void
    {
        foreach ($config as $provider => $settings) {
            $active = $settings['enabled'] ?? false;

            // Update or create SocialProvider record
            SocialProvider::query()
                ->updateOrInsert(
                    ['name' => $provider],
                    ['active' => $active]
                );
        }
    }

    /**
     * Mask secret for display (show only last 4 chars).
     */
    private function maskSecret(mixed $secret): string
    {
        if (! is_string($secret)) {
            return '';
        }

        if (empty($secret)) {
            return '';
        }

        $length = strlen($secret);
        if ($length <= 4) {
            return str_repeat('•', $length);
        }

        return str_repeat('•', $length - 4).substr($secret, -4);
    }

    /**
     * Check if value contains masked characters.
     */
    private function isMasked(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        return str_contains($value, '•') || str_contains($value, '*');
    }

    /**
     * Resolve secret value - use new value or keep existing if masked.
     */
    private function resolveSecret(mixed $newValue, mixed $existingValue): string
    {
        $newSecret = $this->stringValue($newValue);
        $existingSecret = $this->stringValue($existingValue);

        if ($this->isMasked($newSecret) && '' !== $existingSecret) {
            return $existingSecret;
        }

        return $newSecret;
    }

    private function configBool(string $key): bool
    {
        return true === config($key, false);
    }

    private function configString(string $key): string
    {
        return $this->stringValue(config($key, ''));
    }

    /**
     * @param array<int, string> $default
     *
     * @return array<int, string>
     */
    private function configStringList(string $key, array $default): array
    {
        $value = config($key, $default);

        return $this->stringList([] === $value ? $default : $value);
    }

    private function stringValue(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_numeric($value) || is_bool($value)) {
            return (string) $value;
        }

        return '';
    }

    /**
     * @return array<string, mixed>
     */
    private function providerData(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $data = [];
        foreach ($value as $key => $item) {
            if (is_string($key)) {
                $data[$key] = $item;
            }
        }

        return $data;
    }

    /**
     * @return array<int, string>
     */
    private function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter(
            $value,
            static fn (mixed $item): bool => is_string($item) && '' !== $item,
        ));
    }
}
