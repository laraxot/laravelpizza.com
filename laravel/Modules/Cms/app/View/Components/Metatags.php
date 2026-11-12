<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Modules\Cms\Actions\BuildPageSchemaAction;
use Modules\Cms\Actions\ResolvePageMetaAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Datas\MetatagData;

class Metatags extends Component
{
    /**
     * @param  string|null  $title  titolo esplicito della pagina (es. login, errori); vince su quello del CMS
     * @param  string|null  $description  descrizione esplicita della pagina
     */
    public function __construct(
        private ?string $title = null,
        private ?string $description = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $metatag = MetatagData::make();
        $view = app(GetViewAction::class)->execute();
        $route = request()->route();
        $routeName = $route ? $route->getName() : null;
        /** @var array<string, mixed> $routeParameters */
        $routeParameters = [];
        if (is_object($route)) {
            /** @var array<string, mixed> $tmpRouteParameters */
            $tmpRouteParameters = $route->parameters();
            $routeParameters = $tmpRouteParameters;
        }
        $path = request()->path();

        $authUser = auth()->user();
        $user = $authUser instanceof Authenticatable ? $authUser : null;
        $siteTitle = $metatag->getBrandName();
        $pageTitle = $this->pageValue($this->title, ResolvePageMetaAction::TITLE);
        $pageDescription = $this->pageValue($this->description, ResolvePageMetaAction::DESCRIPTION);

        // "Pagina - Sito"; se il titolo della pagina contiene già il nome del sito resta com'è.
        $fullTitle = match (true) {
            $pageTitle === null => $siteTitle,
            $siteTitle === '' || str_contains($pageTitle, $siteTitle) => $pageTitle,
            default => $pageTitle.' - '.$siteTitle,
        };
        $fullDescription = Str::limit($pageDescription ?? $this->siteDescription($metatag), 160);

        $view_params = [
            'meta' => $metatag,
            'title' => $fullTitle,
            'description' => $fullDescription,
            'pageSchema' => app(BuildPageSchemaAction::class)->execute(
                meta: $metatag,
                routeName: $routeName,
                path: $path,
                routeParameters: $routeParameters,
                user: $user,
                name: $pageTitle,
                description: $fullDescription,
            ),
        ];
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }

    /**
     * Descrizione del sito nella lingua corrente. MetatagData è un singleton creato spesso prima che il
     * middleware imposti la lingua, quindi la sua descrizione può essere nella lingua sbagliata.
     */
    private function siteDescription(MetatagData $metatag): string
    {
        $translated = app(TranslateTenantKeyAction::class)->execute('metatag.description');

        return $translated !== 'metatag.description' ? $translated : $metatag->getDescription(limit: 160);
    }

    private function pageValue(?string $explicit, string $attribute): ?string
    {
        $value = $explicit ?? request()->attributes->get($attribute);
        if (! is_string($value)) {
            return null;
        }
        $value = Str::of(strip_tags($value))->squish()->toString();

        return $value === '' ? null : $value;
    }
}
