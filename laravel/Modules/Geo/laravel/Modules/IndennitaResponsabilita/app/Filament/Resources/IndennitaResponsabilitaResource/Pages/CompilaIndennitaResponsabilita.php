<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use LogicException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Collection;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Validation\ValidationException;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Uses the "Super Mucca" methodology:
 * - Study first, then implement with confidence
 * - Follow Laraxot patterns (XotBase*, DRY+KISS+SOLID)
 * - Always document decisions in docs/
 *
 * @property IndennitaResponsabilita $record
 * @property array<string, mixed> $data
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    use InteractsWithRecord;

    /**
     * Minimum number of criteria that must have a score > 0.
     */
    private const MIN_POSITIVE_RATINGS = 2;

    protected static string $resource = IndennitaResponsabilitaResource::class;

    public static ?string $model = IndennitaResponsabilita::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public ?string $previousUrl = null;

    /**
     * Mount page - resolves {record} from URL, authorizes, fills form.
     */
    public function mount(int|string $record): void
    {
        
        /** @var IndennitaResponsabilita $resolvedRecord */
        $resolvedRecord = $this->resolveRecord($record);
        $resolvedRecord->syncRatingsWhere(['anno' => $resolvedRecord->anno]);
        $this->record = $resolvedRecord;
        

        if (! $this->record instanceof IndennitaResponsabilita) {
            abort(404);
        }

        $this->authorizeAccess();

        $this->previousUrl = (string) url()->previous();

        $this->fillFormWithInitialData();
    }

    /**
     * Type-safe record getter.
     * Use explicit type narrowing for PHPStan Level 10.
     */
    public function getSpecificRecord(): IndennitaResponsabilita
    {
        $record = $this->getRecord();
        if (! $record instanceof IndennitaResponsabilita) {
            throw new LogicException('Record must be an instance of IndennitaResponsabilita.');
        }

        return $record;
    }

    /**
     * Fill form with initial data from record.
     * Solo campi editabili, le informazioni generali sono in Infolist.
     */
    protected function fillFormWithInitialData(): void
    {
        $record = $this->getSpecificRecord();
        /** @var array<string, mixed> $data */
        $data = $record->load('ratings')->attributesToArray();
        $data['ratings'] = [];
        $dal = $data['dal'] ?? null;
        if (Carbon::parse(is_scalar($dal) ? (string) $dal : null)->year !== $record->anno) {
            $data['dal'] = Carbon::parse($record->anno.'-01-01');
        }
        $al = $data['al'] ?? null;
        if (Carbon::parse(is_scalar($al) ? (string) $al : null)->year !== $record->anno) {
            $data['al'] = Carbon::parse($record->anno.'-12-31');
        }
        /** @var array<int|string, mixed> $ratings */
        $ratings = $record->ratings->pluck('pivot.value', 'id')->toArray();
        foreach ($ratings as $id => $value) {
            $data['ratings'][(string) $id]['pivot']['value'] = $value;
        }
        $this->data = $data;
        // Solo campi editabili, le informazioni generali sono visualizzate via Infolist
        $this->form->fill($data);
        
    }

    /**
     * Authorize access to this page.
     */
    protected function authorizeAccess(): void
    {
        Gate::authorize('compila', $this->getSpecificRecord());
    }

    /**
     * Infolist per visualizzare le Informazioni Generali in sola lettura.
     * Separazione di responsabilità: Infolist per view, Form per input editabili.
     * In Filament v5, infolist uses Schema but entries are from Infolists.
     */
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->getSpecificRecord())
            ->components([
                Section::make('Informazioni Generali')
                    ->label('')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('matr')
                            ->label('Matricola'),
                        TextEntry::make('cognome')
                            ->label('Cognome'),
                        TextEntry::make('nome')
                            ->label('Nome'),
                        TextEntry::make('perc_p_time_year')
                            ->label('P.Time %')
                            ->formatStateUsing(fn (?float $state): string => number_format(($state ?? 0) * 100, 2).' %'),
                    ]),
            ])->statePath('data');
    }

    /**
     * Build form schema SOLO per campi editabili.
     * Le Informazioni Generali e il Riepilogo sono gestiti dall'Infolist.
     */
    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    protected function getFormSchema(): array
    {
        return array_merge(
            [
                DatePicker::make('dal'),
                DatePicker::make('al'),
                Textarea::make('note')->columnSpanFull(),
            ],
            $this->getRatingsSchema()
        );
    }

    /**
     * Get the form schema for ratings section.
     *
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    protected function getRatingsSchema(): array
    {
        $ratings = $this->getSpecificRecord()->ratings;
        /** @var Collection<int, Rating> $readonlyFields */
        $readonlyFields = $ratings->where('is_readonly', true);

        $schema = [];

        /** @var Rating $rating */
        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';
            $label = strip_tags((string) ($rating->txt ?? $rating->title));
            $readOnly = (bool) ($rating->is_readonly ?? false);

            if (! $readOnly) {
                $item = TextInput::make($fieldname)
                    ->label($label)
                    ->numeric()
                    ->nullable()
                    ->columns(2)
                    ->inlineLabel()
                    ->live(onBlur: true)
                    ->helperText('')
                    ->rules((string) ($rating->rule->value ?? ''))
                    ->afterStateUpdated(function (Set $set, Get $get) use ($readonlyFields): void {
                        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
                    });
            } else {
                
                // Using TextEntry inside a form schema to display readonly values from pivot
                $item = TextEntry::make($fieldname)
                    ->label($label)
                    ->inlineLabel()
                    ->default(Arr::get($this->data,$fieldname,0));
                if(Str::contains($label, 'Importo')){
                    $item->money('EUR');
                }
            }

            $schema[] = $item;
        }

        return $schema;
    }

    /**
     * Get ratings for the current year using schemaless attributes.
     *
     * @return Collection<int, Rating>
     */
    protected function getRatingsForYear(): Collection
    {
        $record = $this->getSpecificRecord();
        /** @var Collection<int, Rating> $ratings */
        $ratings = $record->ratings()
            ->where('extra_attributes->anno', $record->anno)
            ->get();

        return $ratings;
    }

    /**
     * Get the form model.
     */
    public function getModel(): string
    {
        return static::$model ?? IndennitaResponsabilita::class;
    }

    /**
     * @param  Collection<int, Rating>  $readonlyFields
     */
    protected function recalculateReadonlyFields(Set $set, Get $get, Collection $readonlyFields): void
    {
        foreach ($readonlyFields as $rf) {
            $method = 'get'.Str::studly((string) $rf->title);
            $fieldname = 'ratings.'.$rf->id.'.pivot.value';
            if (method_exists($this, $method)) {
                $res=$this->$method($get, $readonlyFields);
                $set($fieldname, $res);
            }
        }
    }

    /**
     * @param  Collection<int, Rating>  $readonlyFields
     */
    public function getTot(Get $get, Collection $readonlyFields): int
    {
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratings */
        $ratings = (array) ($get('ratings') ?? []);
        $tot = 0;
        $ratings_rows = $this->getSpecificRecord()->ratings;
        /** @var Collection<int, Rating> $readonlyFields */
        $valueFields = $ratings_rows->where('is_readonly', false);
        foreach ($valueFields as $valueField) {
            $fieldname = 'ratings.'.$valueField->id.'.pivot.value';
            $value = $get($fieldname) ?? 0;
            $tot += is_numeric($value) ? (int) $value : 0;
        }
        /*
        $tot = 0;
        foreach ($ratings as $rating) {
            $value = $rating['pivot']['value'] ?? 0;
            $tot += is_numeric($value) ? (int) $value : 0;
        }
        */

        return $tot;
    }

    /**
     * @param  Collection<int, Rating>  $readonlyFields
     */
    public function getImportoMensileCalcolato(Get $get, Collection $readonlyFields): float
    {
        return (float) $this->getTot($get, $readonlyFields) * 10.0;
    }

    /**
     * @param  Collection<int, Rating>  $readonlyFields
     */
    public function getImportoMensileAttribuito(Get $get, Collection $readonlyFields): float
    {
        $record = $this->getSpecificRecord();
        $perc = (float) ($record->perc_p_time_year ?? 1.0);

        return $this->getImportoMensileCalcolato($get, $readonlyFields) * $perc;
    }

    /**
     * @param  Collection<int, Rating>  $readonlyFields
     */
    public function getImportoAnnualeAttribuito(Get $get, Collection $readonlyFields): float
    {
        return $this->getImportoMensileAttribuito($get, $readonlyFields) * 12.0;
    }

    /**
     * @return array<string, Action|\Filament\Actions\ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'back' => Action::make('back')
                ->label('Back')
                ->color('gray')
                ->url(function (): string {
                    /** @var string $url */
                    $url = static::$resource::getUrl('index');

                    return $url;
                }),
        ];
    }

    public function back(): \Illuminate\Http\RedirectResponse
    {
        /** @var string $url */
        $url = static::$resource::getUrl('index');

        return redirect()->to($url);
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $this->form->validate();

        /** @var array<string, mixed> $state */
        $state = $this->form->getState();

        // Custom validation: At least 2 editable rating fields must have a value > 0
        $this->ensureMinimumPositiveRatings($state);

        $record = $this->getSpecificRecord();

        // Update record standard fields
        /** @var array<string, mixed> $dataToUpdate */
        $dataToUpdate = collect($this->data)->only(['dal', 'al', 'note'])->toArray();
        $record->update($dataToUpdate);


        // Update pivot ratings
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
        //$ratingsData = (array) ($state['ratings'] ?? []);
        $ratingsData = (array) ($this->data['ratings'] ?? []);
        
        
        foreach ($ratingsData as $id => $rating) {
            $value = $rating['pivot']['value'];
            $record->ratings()->updateExistingPivot($id, [
                'value' => is_numeric($value) ? $value : 0,
            ]);
        }

        if ($shouldSendSavedNotification) {
            Notification::make()->title('Saved successfully')->success()->send();
        }
    }

    /**
     * Ensure that at least MIN_POSITIVE_RATINGS editable ratings have a value > 0.
     *
     * @param  array<string, mixed>  $state
     *
     * @throws ValidationException
     */
    protected function ensureMinimumPositiveRatings(array $state): void
    {
        /** @var Collection<int, Rating> $editableRatings */
        $editableRatings = $this->getRatingsForYear()->where('is_readonly', false);
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = (array) ($state['ratings'] ?? []);

        $positiveCount = 0;
        foreach ($editableRatings as $rating) {
            $ratingId = (string) $rating->id;
            $value = $ratingsData[$ratingId]['pivot']['value'] ?? 0;
            if (is_numeric($value) && (float) $value > 0) {
                $positiveCount++;
            }
        }

        if ($positiveCount < self::MIN_POSITIVE_RATINGS) {
            Notification::make()
                ->title('Errore di Validazione')
                ->body('Attenzione: come indicato nella legenda, è necessario compilare almeno '.self::MIN_POSITIVE_RATINGS.' criteri con punteggio superiore a 0.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'ratings' => 'Almeno '.self::MIN_POSITIVE_RATINGS.' criteri devono avere un punteggio superiore a 0.',
            ]);
        }
    }
}
