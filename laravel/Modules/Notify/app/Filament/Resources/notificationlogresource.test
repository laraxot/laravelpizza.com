<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Filament\Forms;
use Filament\Infolists;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Resources\NotificationLogResource\Pages;
use Modules\Notify\Models\NotificationLog;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource per la gestione dei logs delle notifiche.
 * 
 * @property NotificationLog $record Istanza del record
 */
class NotificationLogResource extends XotBaseResource
{
    protected static ?string $model = NotificationLog::class;
    
    protected static ?string $recordTitleAttribute = 'title';
    
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    
    protected static ?string $navigationGroup = 'Notifiche';
    
    protected static ?int $navigationSort = 100;
    
    /**
     * {@inheritdoc}
     */
    public static function getNavigationLabel(): string
    {
        return 'Logs Notifiche';
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getModelLabel(): string
    {
        return 'Log Notifica';
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getPluralModelLabel(): string
    {
        return 'Logs Notifiche';
    }
    
    /**
     * {@inheritdoc}
     */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dettagli Notifica')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titolo')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                            
                        Forms\Components\Textarea::make('content')
                            ->label('Contenuto')
                            ->required()
                            ->columnSpan(2),
                            
                        Forms\Components\TagsInput::make('channels')
                            ->label('Canali')
                            ->required()
                            ->columnSpan(1),
                            
                        Forms\Components\Select::make('status')
                            ->label('Stato')
                            ->options([
                                'sent' => 'Inviata',
                                'failed' => 'Fallita',
                                'pending' => 'In attesa',
                            ])
                            ->required()
                            ->searchable()
                            ->columnSpan(1),
                            
                        Forms\Components\Textarea::make('error')
                            ->label('Errore')
                            ->columnSpan(2)
                            ->visible(fn (Forms\Get $get): bool => $get('status') === 'failed'),
                            
                        Forms\Components\KeyValue::make('data')
                            ->label('Dati')
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('notifiable_type')
                    ->label('Tipo Destinatario')
                    ->formatStateUsing(fn (string $state): string => class_basename($state)),
                    
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Data Invio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TagsColumn::make('channels')
                    ->label('Canali')
                    ->separator(','),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('sent_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'sent' => 'Inviata',
                        'failed' => 'Fallita',
                        'pending' => 'In attesa',
                    ]),
                    
                SelectFilter::make('channels')
                    ->label('Canale')
                    ->multiple()
                    ->options([
                        'mail' => 'Email',
                        'database' => 'Notifica App',
                        'sms' => 'SMS',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Dettagli Notifica')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Titolo'),
                            
                        Infolists\Components\TextEntry::make('sent_at')
                            ->label('Data Invio')
                            ->dateTime('d/m/Y H:i'),
                            
                        Infolists\Components\TextEntry::make('notifiable_type')
                            ->label('Tipo Destinatario')
                            ->formatStateUsing(fn (string $state): string => class_basename($state)),
                            
                        Infolists\Components\TextEntry::make('notifiable_id')
                            ->label('ID Destinatario'),
                            
                        Infolists\Components\TagsEntry::make('channels')
                            ->label('Canali'),
                            
                        Infolists\Components\TextEntry::make('status')
                            ->label('Stato')
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'sent' => 'success',
                                'failed' => 'danger',
                                'pending' => 'warning',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),
                    
                Infolists\Components\Section::make('Contenuto')
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->label('Contenuto')
                            ->markdown()
                            ->columnSpan(2),
                    ]),
                    
                Infolists\Components\Section::make('Dati Aggiuntivi')
                    ->schema([
                        Infolists\Components\KeyValueEntry::make('data')
                            ->label('Dati della notifica'),
                    ])
                    ->visible(fn (Model $record): bool => !empty($record->data)),
                    
                Infolists\Components\Section::make('Errore')
                    ->schema([
                        Infolists\Components\TextEntry::make('error')
                            ->label('Dettagli Errore')
                            ->color('danger'),
                    ])
                    ->visible(fn (Model $record): bool => $record->status === 'failed' && !empty($record->error)),
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getRelations(): array
    {
        return [];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotificationLogs::route('/'),
            'create' => Pages\CreateNotificationLog::route('/create'),
            'edit' => Pages\EditNotificationLog::route('/{record}/edit'),
            'view' => Pages\ViewNotificationLog::route('/{record}'),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('sent_at', 'desc');
    }
}
