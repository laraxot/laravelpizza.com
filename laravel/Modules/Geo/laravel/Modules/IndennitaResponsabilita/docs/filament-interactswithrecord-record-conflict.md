# Filament `InteractsWithRecord` - Conflitto su proprieta `$record`

## Sintomo

Errore fatale in runtime (PHP 8.3) su pagina Filament:

`CompilaIndennitaResponsabilita and InteractsWithRecord define the same property ($record) ... definition differs and is considered incompatible`

## Causa

La trait `Filament\Resources\Pages\Concerns\InteractsWithRecord` dichiara gia:

- `public Model|int|string|null $record`

La pagina `CompilaIndennitaResponsabilita` ridefiniva `$record` con tipo piu specifico
`IndennitaResponsabilita|null`, generando conflitto di composizione trait in PHP 8.3.

## Fix applicato

1. Rimossa la proprieta `$record` ridefinita nella pagina.
2. Mantenuto un getter tipizzato `getSpecificRecord(): IndennitaResponsabilita` con check runtime.
3. Allineati gli accessi al record tramite `getRecord()`/`getSpecificRecord()`.

## Regola operativa

Nelle pagine Filament che usano `InteractsWithRecord`:

- non ridefinire mai la proprieta `$record`;
- usare un metodo getter tipizzato per il narrowing del modello specifico.
