<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget as FilamentWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Xot\Actions\View\GetViewByClassAction;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;

/**
 * Classe base astratta per tutti i widget Filament.
 * Fornisce funzionalità comuni e standardizzate per la gestione dei widget.
 *
 * @property bool                      $shouldRender Indica se il widget deve essere renderizzato
 * @property string                    $title        Titolo del widget
 * @property string                    $icon         Icona del widget
 * @property array<string, mixed>|null $data         Dati del form
 * @property Schema                    $form
 */
abstract class XotBaseWidget extends FilamentWidget implements HasActions, /* HasForms, */ HasSchemas
{
    use InteractsWithActions;

    // use InteractsWithForms;
    use InteractsWithSchemas;
    use TransTrait;

    public string $title = '';

    public string $icon = '';

    /**
     * Lista degli eventi ascoltati dal widget.
     *
     * @var array<string, string>
     */
    public array $listener = [];

    /**
     * Dati del form.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];

    /**
     * Vista predefinita per widget che estendono XotBaseWidget.
     * Deve essere sovrascritta nelle classi figlie.
     */
    protected string $view = 'xot::filament.widgets.base';

    protected int|string|array $columnSpan = 'full';

    public function __construct()
    {
        $this->resolveView();
    }

    /**
     * Ottiene lo schema del form.
     * Deve essere implementato nelle classi figlie.
     *
     * @return array<int|string, Component>
     */
    abstract public function getFormSchema(): array;

    /**
     * Configura il form del widget.
     *
     * @param Schema $schema Il form da configurare
     *
     * @return Schema Il form configurato
     */
    public function form(Schema $schema): Schema
    {
        $schema = $schema->components($this->getFormSchema());
        $schema->statePath('data');

        $model = $this->getFormModel();
        if (null !== $model) {
            // Ensure model is compatible with Schema::model()
            if (\is_string($model)) {
                if (class_exists($model) && is_subclass_of($model, Model::class)) {
                    /* @var class-string<Model> $model */
                    $schema->model($model);
                }
            } else {
                // $model is an instance of Model
                $schema->model($model);
            }
        }

        return $schema;
    }

    public function getFormFill(): array
    {
        $model = $this->getFormModel();
        if (null === $model) {
            return [];
        }
        if (\is_string($model)) {
            Assert::isInstanceOf($model = app($model), Model::class);
        }

        // Se il modello ha un ID, significa che è stato trovato nel database
        if ($model->exists) {
            try {
                $res = $model->toArray();

                if (method_exists($model, 'getDataDefaults')) {
                    /** @var array<string, mixed> $defaults */
                    $defaults = $model->getDataDefaults();
                    $merge1 = array_merge($defaults, $res);
                    $merge1 = Arr::map($merge1, static function ($value, string|int $key) use ($defaults) {
                        if (null === $value) {
                            $value = Arr::get($defaults, $key, null);
                        }

                        return $value;
                    });
                    $res = $merge1;
                }

                return $res;
            } catch (\Exception $e) {
                // Se toArray() fallisce (problemi con enum), usa getAttributes()
                return $model->getAttributes();
            }
        }

        // Se è un nuovo modello, restituisci solo i campi fillable con valori null
        $fillable = $model->getFillable();
        $appends = $model->getAppends();
        $attributes = $model->attributesToArray();

        $fields = array_merge($fillable, $appends);
        $fields = array_values(array_filter(
            $fields,
            static fn (mixed $field): bool => is_string($field) || is_int($field),
        ));
        $fields = array_fill_keys($fields, null);
        $fields = array_merge($fields, $attributes);
        if (method_exists($model, 'getDataDefaults')) {
            /** @var array<string, mixed> $defaults */
            $defaults = $model->getDataDefaults();
            $fields = array_merge($fields, $defaults);
        }

        return $fields;
    }

    /**
     * Salva i dati del form.
     * Override nelle classi figlie se necessario.
     */
    public function save(): void
    {
        // Implementare nelle classi figlie
    }

    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Azioni form opzionali per viste che chiamano `$this->getFormActions()` (es. layout custom, footer azioni).
     * I widget che non le usano restano con array vuoto.
     *
     * @return array<int|string, Action>
     */
    protected function getFormActions(): array
    {
        return [];
    }

    /**
     * Ottiene il modello per il form.
     * Può essere sovrascritto nelle classi figlie per fornire un modello specifico.
     */
    protected function getFormModel(): Model|string|null
    {
        return null;
    }

    private function resolveView(): void
    {
        $defaultView = 'xot::filament.widgets.base';
        $hadCustomViewRequested = $this->view !== $defaultView;

        if ($hadCustomViewRequested && view()->exists($this->view)) {
            return;
        }

        try {
            $view = app(GetViewByClassAction::class)->execute(static::class);
            if (view()->exists($view)) {
                $this->view = $view;
            }
        } catch (\Exception $e) {
            if (! $hadCustomViewRequested) {
                throw $e;
            }
        }
    }
}
