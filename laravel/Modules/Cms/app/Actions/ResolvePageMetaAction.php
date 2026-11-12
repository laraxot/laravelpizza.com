<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;

/**
 * Titolo e descrizione della pagina CMS in corso di rendering, per <title> e meta description.
 *
 * Il componente <x-page> li calcola mentre rende il contenuto e li deposita negli attributi della
 * richiesta; il layout, che Blade rende dopo lo slot, li legge in <x-metatags>. Gli attributi della
 * richiesta (e non il singleton MetatagData) evitano che un titolo resti appiccicato alla richiesta
 * successiva nei test o con worker di lunga durata.
 *
 * Priorità: il modello mostrato dalla pagina (es. l'evento di /events/{slug}), poi il titolo del JSON
 * della pagina; la descrizione viene dal modello o dal primo blocco che ha `description` o `subtitle`.
 */
final class ResolvePageMetaAction
{
    public const string TITLE = 'cms.meta.title';

    public const string DESCRIPTION = 'cms.meta.description';

    /**
     * @param  iterable<BlockData>  $blocks
     * @param  array<string, mixed>  $data
     * @return array{title: ?string, description: ?string}
     */
    public function execute(string $slug, iterable $blocks, array $data = []): array
    {
        $title = null;
        $description = null;

        $item = $data['item'] ?? null;
        if ($item instanceof Model) {
            $title = $this->clean($item->getAttribute('title'));
            $description = $this->clean($item->getAttribute('description'));
        }

        if ($title === null && $slug !== '') {
            $page = PageModel::query()->where('slug', $slug)->first();
            $title = $page instanceof PageModel ? $this->clean($page->getAttribute('title')) : null;
        }

        if ($description === null) {
            foreach ($blocks as $block) {
                $description = $this->clean($block->data['description'] ?? null) ?? $this->clean($block->data['subtitle'] ?? null);
                if ($description !== null) {
                    break;
                }
            }
        }

        return ['title' => $title, 'description' => $description];
    }

    /**
     * Registra titolo e descrizione per <x-metatags>, senza sovrascrivere quelli già impostati.
     *
     * @param  iterable<BlockData>  $blocks
     * @param  array<string, mixed>  $data
     */
    public function remember(string $slug, iterable $blocks, array $data = []): void
    {
        $attributes = request()->attributes;
        if ($attributes->has(self::TITLE)) {
            return;
        }

        $meta = $this->execute($slug, $blocks, $data);
        $attributes->set(self::TITLE, $meta['title']);
        $attributes->set(self::DESCRIPTION, $meta['description']);
    }

    private function clean(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $text = Str::of(strip_tags($value))->squish()->toString();

        return $text === '' ? null : $text;
    }
}
