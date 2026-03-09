<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Filament\Support\Colors\Color;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Livewire\Wireable;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Actions\File\AssetPathAction;
use Modules\Xot\Datas\Transformers\AssetTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Throwable;

use function Safe\file_get_contents;

/**
 * Class MetatagData
 *
 * @property string $title
 * @property string $sitename
 * @property string $subtitle
 * @property string|null $generator
 * @property string $charset
 * @property string|null $author
 * @property string|null $description
 * @property string|null $keywords
 * @property string $nome_regione
 * @property string $nome_comune
 * @property string $site_title
 * @property string $logo
 * @property string $logo_square
 * @property string $logo_header
 * @property string $logo_header_dark
 * @property string $logo_height
 * @property string $logo_footer
 * @property string $logo_alt
 * @property string $hide_megamenu
 * @property string $hero_type
 * @property string $facebook_href
 * @property string $twitter_href
 * @property string $youtube_href
 * @property string $fastlink
 * @property string $color_primary
 * @property string $color_title
 * @property string $color_megamenu
 * @property string $color_hamburger
 * @property string $color_banner
 * @property string $favicon
 * @property array<string, array{key?: string, color: string, hex?: string}> $colors
 *
 * @method string getBrandLogoBase64() Get the brand logo as base64 data URI for inline embedding
 */
class MetatagData extends Data implements Wireable
{
    use WireableData;

    public string $title = '';

    public string $sitename = '';

    public string $subtitle = '';

    public ?string $generator = 'xot';

    public string $charset = 'UTF-8';

    public ?string $author = 'xot';

    public ?string $description = null;

    public ?string $keywords = null;

    public string $nome_regione = '';

    public string $nome_comune = '';

    public string $site_title = '';

    public string $logo = '';

    public string $logo_square = '';

    #[WithTransformer(AssetTransformer::class)]
    public string $logo_header = '';

    public string $logo_header_dark = '';

    public string $logo_height = '2em';

    public string $logo_footer = '';

    public string $logo_alt = '';

    public string $hide_megamenu = '';

    public string $hero_type = '';

    public string $facebook_href = '';

    public string $twitter_href = '';

    public string $youtube_href = '';

    public string $fastlink = '';

    public string $color_primary = '';

    public string $color_title = '';

    public string $color_megamenu = '';

    public string $color_hamburger = '';

    public string $color_banner = '';

    public string $favicon = '/favicon.ico';

    /**
     * @var array<string, array{key?: string, color: string, hex?: string}>
     */
    public array $colors = [];

    /**
     * Singleton instance.
     */
    private static ?self $instance = null;

    /**
     * Creates or returns the singleton instance.
     */
    public static function make(): self
    {
        if (! self::$instance) {
            /** @var array<string, mixed> $data */
            $data = TenantService::getConfig('metatag');
            $data['description'] = TenantService::trans('metatag.description');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Get the brand name.
     * This method reflects the semantic purpose of getting the brand name,
     * which is the title of the page.
     */
    public function getBrandName(): string
    {
        return $this->title;
    }

    /**
     * Get the brand logo.
     * This method reflects the semantic purpose of getting the brand logo,
     * rather than exposing implementation details about where the logo is used.
     */
    public function getBrandLogo(): string
    {
        try {
            /** @var string $path */
            $path = app(AssetAction::class)->execute($this->logo_header);

            return asset($path);
        } catch (Throwable $e) {
            return asset($this->logo_header);
        }
    }

    public function getBrandLogoPath(): string
    {
        return app(AssetPathAction::class)->execute($this->logo_header);
    }

    /**
     * Get the dark mode brand logo.
     * This method reflects the semantic purpose of getting the dark mode brand logo.
     */
    public function getDarkModeBrandLogo(): string
    {
        try {
            /** @var string $path */
            $path = app(AssetAction::class)->execute($this->logo_header_dark);

            return asset($path);
        } catch (Throwable $e) {
            return asset($this->logo_header_dark);
        }
    }

    /**
     * Get the brand logo height.
     * This method reflects the semantic purpose of getting the brand logo height.
     */
    public function getBrandLogoHeight(): string
    {
        return $this->logo_height;
    }

    /**
     * Get the brand logo as base64 data URI for inline embedding.
     * This method reflects the semantic purpose of getting the brand logo
     * as a base64 data URI that can be embedded directly in HTML img tags.
     *
     * @return string The base64 data URI (e.g., "data:image/png;base64,iVBORw0KGgoAAAA...")
     */
    public function getBrandLogoBase64(): string
    {
        try {
            // Get the asset path using AssetAction (same as getBrandLogo)
            /** @var string $assetPath */
            $assetPath = app(AssetAction::class)->execute($this->logo_header);

            // Get the physical file path
            $physicalPath = public_path($assetPath);

            // Check if file exists
            if (! File::exists($physicalPath)) {
                return '';
            }

            // Read file content
            $fileContent = File::get($physicalPath);

            // Get MIME type
            $mimeType = $this->getMimeTypeFromPath($physicalPath);

            // Convert to base64
            $base64Content = base64_encode($fileContent);

            // Return as data URI
            return "data:{$mimeType};base64,{$base64Content}";
        } catch (Throwable $e) {
            // Fallback: try with the raw logo_header path
            try {
                $fallbackPath = public_path($this->logo_header);
                if (File::exists($fallbackPath)) {
                    $fileContent = File::get($fallbackPath);
                    $mimeType = $this->getMimeTypeFromPath($fallbackPath);
                    $base64Content = base64_encode($fileContent);

                    return "data:{$mimeType};base64,{$base64Content}";
                }
            } catch (Throwable $fallbackException) {
                // Log the error but don't break the application
                Log::warning('Could not generate base64 logo', [
                    'original_error' => $e->getMessage(),
                    'fallback_error' => $fallbackException->getMessage(),
                    'logo_header' => $this->logo_header,
                ]);
            }

            return '';
        }
    }

    /**
     * Get the theme colors.
     * This method reflects the semantic purpose of getting theme colors,
     * rather than exposing the raw color data structure.
     *
     * @return array<string, string>
     */
    public function getThemeColors(): array
    {
        $filamentColors = $this->getFilamentColors();
        $defaults = [];

        // Convert Filament color arrays to simple string format
        foreach ($filamentColors as $key => $colorArray) {
            if (is_array($colorArray) && ! empty($colorArray)) {
                // Use the first color in the array as the default
                $defaults[$key] = (string) $colorArray[0];
            }
        }

        $custom = [];
        foreach ($this->colors as $key => $value) {
            if (Arr::has($value, 'color')) {
                $custom[$key] = (string) $value['color'];
            }
        }

        return array_merge($defaults, $custom);
    }

    /**
     * Get the theme settings.
     * This method reflects the semantic purpose of getting theme settings.
     *
     * @return array<string, string>
     */
    public function getThemeSettings(): array
    {
        return [
            'color_primary' => $this->color_primary,
            'color_title' => $this->color_title,
            'color_megamenu' => $this->color_megamenu,
            'color_hamburger' => $this->color_hamburger,
            'color_banner' => $this->color_banner,
        ];
    }

    /**
     * Get the brand description.
     * This method reflects the semantic purpose of getting the brand description.
     */
    public function getBrandDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the brand social links.
     * This method reflects the semantic purpose of getting social media links.
     *
     * @return array<string, string>
     */
    public function getBrandSocialLinks(): array
    {
        return [
            'facebook' => $this->facebook_href,
            'twitter' => $this->twitter_href,
            'youtube' => $this->youtube_href,
        ];
    }

    /**
     * Get the brand dimensions.
     * This method reflects the semantic purpose of getting brand-related dimensions.
     *
     * @return array<string, string>
     */
    public function getBrandDimensions(): array
    {
        return [
            'logo_height' => $this->logo_height,
        ];
    }

    /**
     * Get the brand settings.
     * This method reflects the semantic purpose of getting brand-related settings.
     *
     * @return array<string, string>
     */
    public function getBrandSettings(): array
    {
        return [
            'fastlink' => $this->fastlink,
            'hide_megamenu' => $this->hide_megamenu,
            'hero_type' => $this->hero_type,
        ];
    }

    /**
     * Get the favicon URL.
     */
    public function getFavicon(): string
    {
        try {
            return app(AssetAction::class)->execute($this->favicon);
        } catch (Throwable $e) {
            return asset($this->favicon);
        }
    }

    public function getFaviconBySize(string $size, string $format): string
    {
        $xot = XotData::make();
        // return app(AssetAction::class)->execute($this->favicon, $size, $format);
        $file = 'favicon-'.$size.'.'.$format;

        return $xot->getPubThemePublicAsset($file);
    }

    /**
     * @deprecated Use getThemeColors() instead as it better reflects the semantic purpose
     */
    public function getColors(): array
    {
        return $this->colors;

        // return $this->getThemeColors();
    }

    /**
     * Get the default Filament colors configuration.
     *
     * @return array<string, array<int, string>>
     */
    public function getFilamentColors(): array
    {
        return [
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ];
    }

    /**
     * Get all colors with proper type handling.
     * Converts custom colors to Filament color format for compatibility.
     *
     * @return array<string, array<int, string>>
     */
    public function getAllColors(): array
    {
        $filamentColors = $this->getFilamentColors();
        $customColors = [];

        // Convert custom color format to Filament color format
        foreach ($this->colors as $key => $value) {
            if (is_array($value) && Arr::has($value, 'color')) {
                // Convert single color value to array format for Filament compatibility
                $colorValue = (string) $value['color'];
                $customColors[$key] = [$colorValue];
            }
        }

        return array_merge($filamentColors, $customColors);
    }

    /**
     * Get the icons array.
     *
     * @return array<string, string>
     */
    public function getIcons(): array
    {
        return [
            'logo' => $this->logo,
            'logo_square' => $this->logo_square,
            'logo_header' => $this->logo_header,
            'logo_header_dark' => $this->logo_header_dark,
            'logo_footer' => $this->logo_footer,
            'favicon' => $this->favicon,
        ];
    }

    /**
     * Get the alignment array.
     *
     * @return array<string, string>
     */
    public function getAlignment(): array
    {
        return [
            'hide_megamenu' => $this->hide_megamenu,
            'hero_type' => $this->hero_type,
        ];
    }

    /**
     * Get the settings array.
     *
     * @return array<string, string>
     */
    public function getSettings(): array
    {
        return $this->getBrandSettings();
    }

    /**
     * Get the meta values array.
     *
     * @return array<string, string|null>
     */
    public function getMetaValues(): array
    {
        return [
            'title' => $this->title,
            'sitename' => $this->sitename,
            'subtitle' => $this->subtitle,
            'generator' => $this->generator,
            'charset' => $this->charset,
            'author' => $this->author,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'nome_regione' => $this->nome_regione,
            'nome_comune' => $this->nome_comune,
            'site_title' => $this->site_title,
        ];
    }

    /**
     * Get the social cards array.
     *
     * @return array<string, string>
     */
    public function getSocialCards(): array
    {
        return $this->getBrandSocialLinks();
    }

    /**
     * Get the OpenGraph array.
     *
     * @return array<string, string|null>
     */
    public function getOpenGraph(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'type' => 'website',
            'url' => url()->current(),
            'site_name' => $this->sitename,
        ];
    }

    /**
     * Get the Twitter Cards array.
     *
     * @return array<string, string|null>
     */
    public function getTwitterCards(): array
    {
        return [
            'card' => 'summary_large_image',
            'title' => $this->title,
            'description' => $this->description,
            'site' => $this->twitter_href,
        ];
    }

    /**
     * @deprecated Use getBrandName() instead as it better reflects the semantic purpose
     */
    public function getTitle(): string
    {
        // return $this->getBrandName();
        return $this->title;
    }

    /**
     * @deprecated Use getBrandLogo() instead as it better reflects the semantic purpose
     */
    public function getLogoHeader(): string
    {
        return $this->getBrandLogo();
    }

    /**
     * @deprecated Use getDarkModeBrandLogo() instead as it better reflects the semantic purpose
     */
    public function getLogoHeaderDark(): string
    {
        return $this->getDarkModeBrandLogo();
    }

    /**
     * @deprecated Use getBrandLogoHeight() instead as it better reflects the semantic purpose
     */
    public function getLogoHeight(): string
    {
        return $this->getBrandLogoHeight();
    }

    public function getBrandLogoSvg(): string
    {
        $xot = XotData::make();
        $path = base_path('Modules/'.$xot->main_module.'/resources/svg/logo.svg');

        return file_get_contents($path);
    }

    public function getDescription(int $limit = 160): string
    {
        return $this->description ?? '';
    }

    public function getKeywords(): string
    {
        return TenantService::trans('metatag.keywords');
    }

    public function getAuthor(): string
    {
        return TenantService::trans('metatag.author');
    }

    public function getSitename(): string
    {
        return TenantService::trans('metatag.sitename');
    }

    public function getRobots(): string
    {
        return 'index, follow';
    }

    public function getType(): string
    {
        return 'website';
    }

    public function getCanonical(): string
    {
        return url()->current();
    }

    public function getImage(): string
    {
        return asset('images/logo.png');
    }

    public function getLocale(): string
    {
        return app()->getLocale();
    }

    public function getCurrentUrl(): string
    {
        return url()->current();
    }

    public function getSiteWebmanifest(): string
    {
        $xot = XotData::make();

        $file = 'site.webmanifest';

        return $xot->getPubThemePublicAsset($file);
    }

    public function getPubThemeAsset(string $file): string
    {
        $xot = XotData::make();

        return $xot->getPubThemePublicAsset($file);
    }

    public function getPubTheme(): string
    {
        $xot = XotData::make();

        return $xot->pub_theme;
    }

    /**
     * Concatenate a title to the existing title.
     * This method allows adding page-specific titles to the base site title.
     *
     * @param  string|null  $title  The title to concatenate
     */
    public function concatTitle(?string $title): self
    {
        // Skip concatenation if title is null or empty
        if (empty($title)) {
            return $this;
        }

        if (empty($this->title)) {
            $this->title = $title;
        } else {
            $this->title = $title.' - '.$this->title;
        }

        return $this;
    }

    /**
     * Concatenate a description to the existing description.
     * This method allows adding page-specific descriptions to the base site description.
     *
     * @param  string|null  $description  The description to concatenate
     */
    public function concatDescription(?string $description): self
    {
        // Skip concatenation if description is null or empty
        if (empty($description)) {
            return $this;
        }

        if (empty($this->description)) {
            $this->description = $description;
        } else {
            $this->description = $description.' '.$this->description;
        }

        return $this;
    }

    /**
     * Get MIME type from file path extension.
     * Helper method for getBrandLogoBase64().
     */
    private function getMimeTypeFromPath(string $filePath): string
    {
        $extension = \strtolower(\pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp',
            'ico' => 'image/x-icon',
            default => 'image/png', // Fallback default
        };
    }
}
