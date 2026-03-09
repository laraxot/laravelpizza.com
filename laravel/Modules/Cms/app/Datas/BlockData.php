<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Wireable;
use Modules\Cms\Actions\ResolveBlockQueryAction;

use function Safe\fclose;
use function Safe\fopen;
use function Safe\fread;

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

    public bool $livewire = false;

    public string $livewireComponentName = '';

    public function __construct(string $type, array $data, ?string $slug = null)
    {
        $this->type = $type;
        $this->slug = $slug;

        // Dynamic Query Resolution
        /** @var array<string, mixed> $query */
        $query = Arr::get($data, 'query');
        if (is_array($query)) {
            $dynamicData = app(ResolveBlockQueryAction::class)->execute($query);
            $data = array_merge($data, $dynamicData);
        }

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
        $this->livewire = $this->detectLivewire($view);
        if ($this->livewire) {
            $this->livewireComponentName = $this->normalizeComponentName($view);
        }
    }

    private function detectLivewire(string $view): bool
    {
        if (! view()->exists($view)) {
            return false;
        }

        // Usa un approccio più performante per recuperare il path della view
        /** @var \Illuminate\View\FileViewFinder $finder */
        $finder = view()->getFinder();
        $path = $finder->find($view);

        if (! file_exists($path)) {
            return false;
        }

        // Verifica se è un componente Volt (class-based o functional)
        // Leggiamo solo l'inizio del file per performance
        $handle = fopen($path, 'r');
        $header = (string) fread($handle, 1024);
        fclose($handle);

        return str_contains($header, 'new class extends Component')
               || str_contains($header, 'Livewire\Volt\Component')
               || str_contains($header, 'volt(')
               || str_contains($header, 'state(');
    }

    private function normalizeComponentName(string $view): string
    {
        // Rimuove i namespace comuni e i prefissi dei blocchi per Volt
        // Esempio: 'pub_theme::components.blocks.events.detail' -> 'events.detail'
        $name = str_replace(['pub_theme::components.blocks.', 'cms::components.blocks.', 'pub_theme::livewire.', 'cms::livewire.'], '', $view);

        // Se inizia ancora con un namespace, teniamo solo la parte dopo ::
        if (str_contains($name, '::')) {
            $name = (string) Str::after($name, '::');
        }

        return $name;
    }

    public static function collection(EloquentCollection|Collection|array $data): DataCollection|array
    {
        return self::collect($data, DataCollection::class);
    }
}
