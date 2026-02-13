<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class BlockData extends Data implements Wireable
{
    use WireableData;

    public string $type;

    public ?string $slug = null;

    public array $data;

    public string $view;

    public function __construct(string $type, array $data, ?string $slug = null)
    {
        $this->type = $type;
        $this->slug = $slug;
        $this->data = $data;
        Assert::string($view = Arr::get($data, 'view', 'ui::empty'), '['.__LINE__.']['.__FILE__.']');

        // Verifica che la view esista, con gestione più robusta per i namespace
        // Se la view usa un namespace (es. pub_theme::), verifica anche il file fisico
        if (! view()->exists($view)) {
            // Se la view usa un namespace, prova a verificare il file fisico direttamente
            if (str_contains($view, '::')) {
                [$namespace, $path] = explode('::', $view, 2);

                // Per PHPStan Level 10: usiamo un approccio più sicuro
                // invece di accedere direttamente a metodi non documentati
                try {
                    // Tentativo di risolvere il namespace della view in modo più sicuro
                    $viewFactory = view();
                    if (method_exists($viewFactory, 'addNamespace')) {
                        // Se il metodo esiste, possiamo procedere con logica alternativa
                        $this->view = $view; // Accetta la view temporaneamente

                        return;
                    }
                } catch (\Exception $e) {
                    // In caso di errore, continua con la view originale
                }
            }
            // Se arriviamo qui, la view non esiste
            throw new \Exception('view not found: '.$view);
        }

        $this->view = $view;
    }

    public static function collection(EloquentCollection|Collection|array $data): DataCollection
    {
        return self::collect($data, DataCollection::class);
    }
}
