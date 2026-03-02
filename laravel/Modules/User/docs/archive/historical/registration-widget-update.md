# Aggiornamento relativo a DoctorResource.php

## Nota del [DATE]
In relazione al widget di registrazione, ho aggiornato la documentazione per riflettere la modifica apportata a `DoctorResource.php` nel modulo Patient. Il metodo `getPersonalInfoStep` ora include i campi `first_name`, `last_name` ed `email`, essenziali per la raccolta dati durante la registrazione dei dottori.
### Impatto sul Widget di Registrazione
- **Coerenza Dati**: Assicurarsi che il widget di registrazione sia compatibile con i nuovi campi separati per nome e cognome.
- **Email**: L'aggiunta del campo email è cruciale per garantire che il widget possa inviare comunicazioni post-registrazione.
## Aggiornamento del [DATE] (Ultimo)
Ho aggiornato ulteriormente la documentazione per riflettere un cambiamento nella gestione delle traduzioni in `DoctorResource.php`. La proprietà `$translationPrefix` è stata reintrodotta per supportare le traduzioni personalizzate, ma nei metodi del wizard i riferimenti diretti a questa proprietà sono stati sostituiti con namespace di traduzione diretti (`patient::doctor-resource`).
- **Coerenza Traduzioni**: Questo cambiamento garantisce che le traduzioni siano applicate correttamente nel widget di registrazione, mantenendo la coerenza con il resto del sistema.
**Collegamenti correlati**:
- [Documentazione DoctorResource](../modules/patient/project_docs/doctor-resource-update.md)
- [Documentazione principale](../project_docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/project_docs/doctor-model-update.md)
- [Documentazione DoctorResource](../modules/patient/docs/doctor-resource-update.md)
- [Documentazione principale](../../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/docs/doctor-model-update.md)
# Aggiornamento relativo a DoctorResource.php

## Nota del [DATE]

In relazione al widget di registrazione, ho aggiornato la documentazione per riflettere la modifica apportata a `DoctorResource.php` nel modulo Patient. Il metodo `getPersonalInfoStep` ora include i campi `first_name`, `last_name` ed `email`, essenziali per la raccolta dati durante la registrazione dei dottori.

### Impatto sul Widget di Registrazione
- **Coerenza Dati**: Assicurarsi che il widget di registrazione sia compatibile con i nuovi campi separati per nome e cognome.
- **Email**: L'aggiunta del campo email è cruciale per garantire che il widget possa inviare comunicazioni post-registrazione.

## Aggiornamento del [DATE] (Ultimo)

Ho aggiornato ulteriormente la documentazione per riflettere un cambiamento nella gestione delle traduzioni in `DoctorResource.php`. La proprietà `$translationPrefix` è stata reintrodotta per supportare le traduzioni personalizzate, ma nei metodi del wizard i riferimenti diretti a questa proprietà sono stati sostituiti con namespace di traduzione diretti (`patient::doctor-resource`).

### Impatto sul Widget di Registrazione
- **Coerenza Traduzioni**: Questo cambiamento garantisce che le traduzioni siano applicate correttamente nel widget di registrazione, mantenendo la coerenza con il resto del sistema.

**Collegamenti correlati**:
- [Documentazione DoctorResource](../modules/patient/docs/doctor-resource-update.md)
- [Documentazione principale](../../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/docs/doctor-model-update.md)
