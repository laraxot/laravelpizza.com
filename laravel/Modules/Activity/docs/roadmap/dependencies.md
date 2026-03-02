# Dipendenze e confini Modulo Activity

## Dipendenze in ingresso

- **Laravel**: Eloquent, eventi, queue (se logging async), cache.
- **Xot**: XotBaseMigration, convenzioni namespace e Filament (se Resource activity).
- **Moduli che emettono eventi**: Activity non dipende da moduli di dominio per la logica core; riceve eventi o chiamate da altri moduli che registrano azioni (pattern observer o dispatch).

## Dipendenze in uscita

- **Nessun modulo deve dipendere da Activity per funzionalità critiche di business**: Activity è osservabilità e audit; i flussi applicativi non devono fallire se il logging fallisce (resilienza).
- **Admin / Filament**: Cluster Observability e dashboard consumano dati da Activity.

## Rischio dipendenze circolari

- Activity non deve importare modelli di dominio (User ok per user_id; non importare Patient, Cms, ecc. per logica). Eventi e payload devono essere generici o serializzati.
