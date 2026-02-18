<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

/**
 * ---
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use HasXotTable;
    use InteractsWithForms;
    use NavigationLabelTrait;
    // protected static string $resource;
    protected static string $recordTitleAttribute = 'name';

    /**
     * Restituisce il gruppo di navigazione (override opzionale).
     */
    public static function getNavigationGroup(): string
    {
        return '';
    }

    /**
     * Restituisce il titolo della pagina.
     */
    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__).' - '.$this->getRecordTitle();
    }

    public function getRecordTitle(): string
    {
        $value = $this->record->{static::$recordTitleAttribute};
        return (string) $value;
    }

    

    /**
     * Restituisce lo schema del form per i record correlati.
     *
     * @return array<\Filament\Schemas\Components\Component>
     */
    // abstract public static function getFormSchema(): array;

    /**
     * Configura lo schema per i record correlati.
     */
    public function schema(Schema $schema): Schema
    {
        // getFormSchema() sempre ritorna array per definizione
        $formSchema = $this->getFormSchema();

        return $schema->components($formSchema);
    }

    /**
     * Restituisce lo schema del form per i record correlati.
     *
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Definisce le colonne della tabella per la visualizzazione dei record correlati.
     * Questo metodo può essere sovrascritto nelle classi figlie.
     *
     * @return array<string, TextColumn>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->label('ID')->sortable(),
            'name' => TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }

    /**
     * Definisce le azioni dell'intestazione della tabella.
     * Questo metodo può essere sovrascritto nelle classi figlie.
     *
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->label('Crea Nuovo')->disableCreateAnother(),
        ];
    }

    /**
     * Definisce le azioni per ogni riga della tabella.
     * Questo metodo può essere sovrascritto nelle classi figlie.
     *
     * @return array<string, Action>
     */
    public function getTableActions(): array
    {
        // Preferisci la risorsa correlata per i record nested; altrimenti usa la risorsa della pagina.
        $resource = static::$relatedResource ?? static::getResource();
        // Mostra "view" solo se la risorsa correlata espone quella pagina.
        $hasView = $resource::hasPage('view');

        return [
            'view' => Action::make('view')
                ->label('Visualizza')
                ->icon('heroicon-o-eye')
                ->visible(static fn (): bool => (bool) $hasView)
                ->url(function (Model $record) use ($resource): string {
                    // Prova il guessing degli URL nested di Filament (funziona con nesting multi-livello in richieste normali).
                    $url = $resource::getUrl('view', ['record' => $record], shouldGuessMissingParameters: true);
                    // Fallback per contesti senza dati di request (es. test Livewire).
                    if ($url === '') {
                        $url = $resource::getUrl('view', ['record' => $record], shouldGuessMissingParameters: false);
                    }

                    return is_string($url) ? $url : (string) $url;
                }),
            'edit' => Action::make('edit')
                ->label('Modifica')
                ->icon('heroicon-o-pencil')
                ->url(function (Model $record) use ($resource): string {
                    // Prova il guessing degli URL nested di Filament (funziona con nesting multi-livello in richieste normali).
                    $url = $resource::getUrl('edit', ['record' => $record], shouldGuessMissingParameters: true);
                    // Fallback per contesti senza dati di request (es. test Livewire).
                    if ($url === '') {
                        $url = $resource::getUrl('edit', ['record' => $record], shouldGuessMissingParameters: false);
                    }

                    return is_string($url) ? $url : (string) $url;
                }),
            // 'view' => Action::make('view')
            //     ->label('Visualizza')
            //     ->icon('heroicon-o-eye')
            //     ->url(fn (Model $record): string => static::getResource()::getUrl('view', ['record' => $record])),
        ];
    }

   
    
}
