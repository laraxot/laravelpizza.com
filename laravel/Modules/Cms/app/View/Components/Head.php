<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Support\Str;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\Component;
use Laravel\Head\Facades\Head as HeadManager;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Actions\BuildPageSchemaAction;
use Modules\Cms\Actions\Head\BuildHeadSchemaAction;
use Modules\Cms\Actions\Head\CollapsePathSegmentsAction;
use Modules\Cms\Actions\Head\ComposeDocumentTitleAction;
use Modules\Cms\Actions\Head\ResolveCmsPageAction;
use Modules\Cms\Actions\Head\ResolveHreflangAlternatesAction;
use Modules\Cms\Actions\Head\ResolvePageDescriptionAction;
use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Cms\Actions\Head\ResolveWrittenLocalesAction;
use Modules\Cms\Models\Page;
use Modules\Xot\Datas\MetatagData;

use function Safe\parse_url;
use function Safe\preg_replace;

/**
 * Il `<head>` del front office: la vista emette `<head>…</head>`, i layout non lo avvolgono.
 *
 * I valori si scrivono a runtime sullo strato più alto di `laravel/head` (senza `flush()`) e vincono su defaults,
 * gruppo di rotte e rotta. Il layout rende questo componente dopo la pagina: per cambiare titolo, descrizione o colore
 * di una pagina si usano le props del componente, non `Head::…()` dalla pagina (verrebbe sovrascritto).
 * Testi e immagini del sito arrivano dal tema (`pub_theme::seo.*`, `pub_theme::header.*`) e dal testo della pagina CMS;
 * un tag senza dato reale viene omesso, mai riempito con segnaposto o chiavi grezze.
 */
final class Head extends Component
{
    private const string SOCIAL_IMAGE = 'images/social-share.jpg';

    private const int SOCIAL_IMAGE_WIDTH = 1200;

    private const int SOCIAL_IMAGE_HEIGHT = 630;

    private const string DEFAULT_THEME_COLOR = '#0f2b46';

    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?bool $homepage = null,
        public readonly ?string $themeColor = null,
    ) {}

    public function render(): ViewContract
    {
        $meta = MetatagData::make();
        $brand = $this->resolveBrand($meta);
        $localeCodes = array_keys(LaravelLocalization::getSupportedLocales());
        $path = request()->decodedPath();
        $isHome = $this->isHomepage();
        $page = $this->resolvePage($path, $localeCodes);
        $titles = app(ComposeDocumentTitleAction::class);
        $pageTitle = $titles->withoutBrand($this->resolvePageTitle($page), $brand);
        $title = $titles->execute($pageTitle, $brand);
        $description = $this->resolveDescription($meta, $page, $isHome);
        $canonical = $this->canonicalUrl();
        $writtenLocales = $page instanceof Page ? app(ResolveWrittenLocalesAction::class)->execute($page) : null;
        $translated = $writtenLocales === null || in_array(app()->getLocale(), $writtenLocales, true);
        $policy = app(ResolveRobotsPolicyAction::class);
        $indexable = $policy->isIndexable($path, $localeCodes, $translated)
            && (! $page instanceof Page || $policy->isPageIndexable($this->stringAttribute($page, 'slug'), $page->getAttribute('middleware')));
        $image = $this->themeAssetUrl($meta, self::SOCIAL_IMAGE);

        HeadManager::title($title, exact: true)
            ->viewport('width=device-width, initial-scale=1.0')
            ->applicationName($brand)
            ->robots($policy->directive($indexable))
            ->og(type: $meta->getType(), title: $title, description: $description, url: $canonical, siteName: $brand, locale: $this->openGraphLocale())
            ->twitter(card: $image !== null ? 'summary_large_image' : 'summary', title: $title, description: $description);

        if ($description !== null) {
            HeadManager::description($description);
        }

        HeadManager::themeColor($this->themeColor ?? self::DEFAULT_THEME_COLOR);

        if ($image !== null) {
            HeadManager::ogImage($image, alt: $brand, width: self::SOCIAL_IMAGE_WIDTH, height: self::SOCIAL_IMAGE_HEIGHT)->twitterImage($image, alt: $brand);
        }

        $this->applyIcons($meta);

        // Una pagina `noindex` non dichiara un canonical (segnale contraddittorio) né alternative linguistiche né dati strutturati.
        // Le alternative linguistiche si derivano dall'URL richiesto: su una variante non canonica (`/it/./faq`, `/index.php/it/faq`)
        // le dichiara solo la forma pulita a cui punta il canonical.
        if ($indexable) {
            HeadManager::canonical($canonical, forceHttps: false);
            if ($this->isCanonicalForm()) {
                HeadManager::alternates(app(ResolveHreflangAlternatesAction::class)->execute($writtenLocales));
            }

            $this->applySchema($meta, $brand, $pageTitle, $description, $canonical, $isHome, $isHome ? $writtenLocales : null);
        }

        return view('cms::components.head', [
            'pubTheme' => $meta->getPubTheme(),
        ]);
    }

    private function resolveBrand(MetatagData $meta): string
    {
        $key = 'pub_theme::header.brand.name';
        $brand = Lang::has($key) ? trim((string) __($key)) : '';

        if ($brand === '') {
            $brand = trim($meta->getBrandName());
        }

        if ($brand === '') {
            $applicationName = config('app.name');
            $brand = is_string($applicationName) ? trim($applicationName) : '';
        }

        if ($brand !== '') {
            return $brand;
        }

        $host = parse_url(url('/'), PHP_URL_HOST);

        return is_string($host) && trim($host) !== '' ? trim($host) : 'website';
    }

    /**
     * Prop del componente, poi testo della pagina CMS (non per la home, che ha la descrizione curata del sito), poi descrizione del sito.
     */
    private function resolveDescription(MetatagData $meta, ?Page $page, bool $isHome): ?string
    {
        if ($this->description !== null && trim($this->description) !== '') {
            return trim($this->description);
        }

        $key = 'pub_theme::seo.site.description';
        $siteDescription = Lang::has($key) ? trim((string) __($key)) : '';

        if (! $isHome && $page instanceof Page) {
            $derived = app(ResolvePageDescriptionAction::class)->execute($page, app()->getLocale());
            if ($derived !== null) {
                return $derived;
            }
        }

        if ($siteDescription !== '') {
            return $siteDescription;
        }

        $fallback = trim($meta->getDescription(limit: 160));

        return $fallback !== '' ? $fallback : null;
    }

    private function openGraphLocale(): ?string
    {
        $regional = LaravelLocalization::getCurrentLocaleRegional();

        return is_string($regional) && $regional !== '' ? $regional : null;
    }

    /**
     * URL pulito della richiesta (senza `index.php`, segmenti-punto, barre doppie e query), https in produzione:
     * la stessa stringa per canonical, `og:url` e dati strutturati.
     */
    private function canonicalUrl(): string
    {
        $path = app(CollapsePathSegmentsAction::class)->execute(request()->path());
        $url = $path === '' ? $this->siteRoot() : $this->siteRoot().'/'.$path;

        // `?page=N` e' contenuto diverso: canonical e og:url lo dichiarano, altrimenti ogni pagina
        // della serie punta canonical alla prima (stesso criterio degli hreflang).
        $page = request()->query('page');
        if (is_numeric($page) && (int) $page >= 2) {
            $url .= '?page='.(int) $page;
        }

        return $url;
    }

    /**
     * Radice del sito senza il file di ingresso (come fa `asset()`: `/index.php/it` non deve finire negli URL dichiarati),
     * https in produzione. Canonical, `@id` e URL dello schema partono tutti da qui, così non possono divergere.
     */
    private function siteRoot(): string
    {
        $root = rtrim(str_replace('/index.php', '', url('/')), '/');

        return app()->environment('production') ? Str::of($root)->replaceMatches('/^http:\/\//', 'https://')->toString() : $root;
    }

    /** `true` se la richiesta è già nella forma del canonical: nessun `index.php` nell'URL e nessun segmento vuoto o punto. */
    private function isCanonicalForm(): bool
    {
        $request = request();

        return $request->getBaseUrl() === $request->getBasePath()
            && trim($request->path(), '/') === app(CollapsePathSegmentsAction::class)->execute($request->path());
    }

    private function resolvePageTitle(?Page $page): string
    {
        $pageTitle = trim((string) $this->title);
        if ($pageTitle !== '' || $page === null) {
            return $pageTitle;
        }

        return trim($this->stringAttribute($page, 'title'));
    }

    private function stringAttribute(Page $page, string $attribute): string
    {
        $value = $page->getAttribute($attribute);

        return is_string($value) ? $value : '';
    }

    /**
     * @param  list<string>  $localeCodes
     */
    private function resolvePage(string $path, array $localeCodes): ?Page
    {
        $route = request()->route();
        $routeName = is_object($route) ? $route->getName() : null;

        return app(ResolveCmsPageAction::class)->execute($path, $localeCodes, is_string($routeName) ? $routeName : null);
    }

    private function applyIcons(MetatagData $meta): void
    {
        // Il favicon applicativo vive nel public root; il manifest invece può essere
        // generato dal build del tema con il nome standard Vite `manifest.json`.
        $favicon = $this->themeAssetUrl($meta, 'favicon.ico') ?? $this->publicAssetUrl('favicon.ico');
        $appleTouchIcon = $this->themeAssetUrl($meta, 'apple-touch-icon.png');
        // Vite's manifest.json is a build index, not a Web App Manifest.
        // Never expose it through rel=manifest: browsers expect name/icons/start_url.
        $manifest = $this->themeAssetUrl($meta, 'site.webmanifest');

        if ($favicon !== null) {
            HeadManager::favicon($favicon);
        }

        if ($appleTouchIcon !== null) {
            HeadManager::appleTouchIcon($appleTouchIcon, '180x180');
        }

        if ($manifest !== null) {
            HeadManager::manifest($manifest);
        }
    }

    /** URL dell'asset del tema, solo se il file esiste davvero in `public/`. */
    private function themeAssetUrl(MetatagData $meta, string $file): ?string
    {
        $url = $meta->getPubThemeAsset($file);
        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && is_file(public_path(ltrim($path, '/'))) ? $url : null;
    }

    private function publicAssetUrl(string $file): ?string
    {
        $url = asset($file);

        return is_file(public_path($file)) ? $url : null;
    }

    /**
     * @param  list<string>|null  $siteLocales  lingue in cui il sito è scritto (dalla home CMS); `null` = solo la lingua corrente
     */
    private function applySchema(MetatagData $meta, string $brand, string $pageTitle, ?string $description, string $canonical, bool $isHome, ?array $siteLocales): void
    {
        $logo = $meta->getBrandLogo();
        $homeLabelKey = 'pub_theme::navigation.home';
        $name = $pageTitle !== '' ? $pageTitle : $brand;

        try {
            $schemas = app(BuildHeadSchemaAction::class)->execute(
                isHome: $isHome,
                brand: $brand,
                homeUrl: $this->siteRoot().'/'.app()->getLocale(),
                pageTitle: $name,
                pageUrl: $canonical,
                locale: app()->getLocale(),
                logoUrl: $logo !== '' ? asset($logo) : null,
                page: $isHome ? [] : $this->resolvePageEntity($meta, $name, $description, $canonical),
                rootUrl: $this->siteRoot(),
                homeLabel: Lang::has($homeLabelKey) ? trim((string) __($homeLabelKey)) : '',
                languages: $siteLocales,
            );

            foreach ($schemas as $schema) {
                HeadManager::schema($schema);
            }
        } catch (\Throwable $exception) {
            // I dati strutturati sono un di più: un valore non valido (il validatore di laravel/head lancia fuori produzione) non deve togliere la pagina.
            report($exception);
        }
    }

    /**
     * Il JSON-LD è markup pubblico (può finire in una cache condivisa): non riceve mai l'utente della sessione.
     *
     * @return array<string, mixed>
     */
    private function resolvePageEntity(MetatagData $meta, string $name, ?string $description, string $canonical): array
    {
        $route = request()->route();
        $routeParameters = [];
        if (is_object($route)) {
            foreach ($route->parameters() as $key => $value) {
                if (is_string($key)) {
                    $routeParameters[$key] = $value;
                }
            }
        }

        return app(BuildPageSchemaAction::class)->execute(
            meta: $meta,
            routeName: is_object($route) ? $route->getName() : null,
            path: request()->path(),
            routeParameters: $routeParameters,
            name: $name,
            description: $description ?? '',
            canonical: $canonical,
        );
    }

    private function isHomepage(): bool
    {
        if ($this->homepage !== null) {
            return $this->homepage;
        }

        $route = request()->route();
        $path = trim(request()->path(), '/');
        $locale = (string) app()->getLocale();

        return (is_object($route) && $route->getName() === 'home') || $path === '' || $path === $locale;
    }
}
