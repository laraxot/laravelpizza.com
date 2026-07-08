# PHPStan Refactor Notes

## GetHaDirittoMotivoAction (2025-11-12)
- **Contesto**: l’azione accumulava stringhe concatenando valori `mixed` provenienti da criteri dinamici, con chiamate dinamiche a metodi `check*` e date calcolate tramite `Carbon::parse` su input non tipizzati. PHPStan segnalava errori di concatenazione, parse e mancanza di metodi.
- **Intervento**: normalizzazione dei criteri (`array<string, mixed>`), controllo dell’esistenza dei metodi dinamici e raccolta dei motivi in array (`implode(', ', $motivi)`). Gestione delle date con cast espliciti a `Carbon` e fallback sicuro sull’anno. I messaggi di errore vengono prodotti solo quando effettivamente presenti.
- **Risultato**: eliminati i warning `binaryOp.invalid`/`argument.type` sull’azione; la logica risulta più leggibile e pronta per successivi refactor delle verifiche specifiche.

## UpdateHaDirittoAction (2025-11-12)
- **Contesto**: il ciclo sulle schede usava oggetti `mixed` derivati da `::query()->get()` e invocava `GetHaDirittoMotivoAction` senza garanzie di tipo, provocando errori `method.nonObject`, `property.nonObject` e `argument.type`.
- **Intervento**: introdotto un vincolo esplicito sul parametro di classe (`class-string<BaseIndividualeModel>`), validazione dell’input, annotazione della collection con il tipo generico corretto e riuso dell’azione `GetHaDirittoMotivoAction` ora tipizzata su `BaseIndividualeModel`. Aggiornata anche l’assegnazione attributi con proprietà native.
- **Risultato**: PHPStan riconosce che il loop tratta modelli Eloquent concreti e non segnala più accessi su `mixed`.

Collegamenti: [README del modulo](./README.md) e documentazione dei criteri valutativi in `Modules/Ptv/docs/`.

## BaseIndividualeModel – conflitto criteriOptionsArr

- **Contesto**: durante l’esecuzione di `phpstan analyse Modules/Performance` PHPStan andava in fatal error per conflitto di trait:
  `SchedaTrait::criteriOptionsArr` vs `Modules\Performance\Models\Traits\FunctionTrait::criteriOptionsArr` in `BaseIndividualeModel`.
- **Analisi**: nel dominio Performance l’implementazione di riferimento per i criteri è quella di `FunctionTrait`, che lavora sulle relazioni `criteriOptions` del modulo Performance, mentre `SchedaTrait` fornisce una versione generica a livello Sigma.
- **Intervento**: nel blocco `use` di `BaseIndividualeModel` è stato aggiunto l’alias esplicito:
  `FunctionTrait::criteriOptionsArr insteadof SchedaTrait;`
  in modo da usare sempre la versione specializzata Performance e risolvere il conflitto a runtime e per PHPStan.
- **Risultato**: il fatal scompare, `phpstan analyse Modules/Performance --memory-limit=-1` torna a 0 errori, mantenendo coerente il comportamento del calcolo dei criteri rispetto alla logica descritta in questo modulo.

## Pattern PHPStan riusabili

- Tipizzare sempre gli array pubblici con chiavi e valori: `array<string, mixed>`, `array<int, string>` o array shape dedicate.
- Per action/servizi che accettano una scheda Performance generica usare `BaseIndividualeModel<object>` quando il modello concreto non cambia la logica.
- Per trait generic applicati a modelli Eloquent dichiarare il bind vicino al `use`: `@use TraitName<static>`.
- Nelle relazioni Eloquent usare `$this` come secondo parametro generic quando il builder appartiene al record corrente: `HasMany<RelatedModel, $this>`.
- In `getTableActions()` e `getTableBulkActions()` mantenere `array<int|string, ...>` se si estende `parent::...`, perché le azioni standard possono avere chiavi stringa.
- Nei PHPDoc Filament importare `Action`, `ActionGroup` e `BulkAction` oppure usare FQCN assoluti; i namespace relativi producono falsi `class.notFound`.
