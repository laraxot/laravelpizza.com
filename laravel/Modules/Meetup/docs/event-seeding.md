# Event Seeding & Schema.org Documentation

## 🚀 Il Passaggio al Database (SEO First)

Originariamente, gli eventi erano gestiti come blocchi di contenuto statico dentro i file `.json` della directory `content/pages/`. Per un sistema professionale e "intelligente", abbiamo migrato questi dati nel database reale del modulo `Meetup`.

### Benefici Architetturali:
1. **Dinamismo**: Gli eventi possono ora essere gestiti via Filament Admin Panel.
2. **SEO Automatica**: Utilizzando il modello `Event`, generiamo automaticamente markup JSON-LD conforme a `schema.org/Event`.
3. **Performance**: Ricerca e filtraggio degli eventi ora avvengono lato Database (SQL), molto più veloce del parsing di file JSON giganti.

---

## 🛠️ Processo di Seeding

Abbiamo implementato l'azione `Modules\Meetup\Actions\Event\SeedEventsFromJsonAction` per automatizzare il caricamento.

### Mappatura Dati JSON -> Schema.org
| Campo JSON | Colonna DB | Schema.org Property | Note |
| :--- | :--- | :--- | :--- |
| `title` | `title` | `name` | Obbligatorio |
| `date` + `time` | `start_date` / `end_date` | `startDate` / `endDate` | Parsing tramite Carbon in ISO 8601 |
| `location` | `location` | `location.name` | Mappato come `Place` |
| `status` | `status` | `eventStatus` | Mappato tramite `EventStatus` Enum |
| `attendees_max` | `max_attendees` | `maximumAttendeeCapacity` | |

### Comando di Esecuzione
L'azione può essere chiamata programmaticamente o via tinker:
```bash
php artisan tinker --execute="app(Modules\Meetup\Actions\Event\SeedEventsFromJsonAction::class)->execute()"
```

---

## 🏗️ Implementazione Schema.org (Senior Pattern)

Il modello `Event` implementa il metodo `toSchemaOrg()`. Questo metodo trasforma le proprietà Eloquent (spesso frammentate) in un oggetto strutturato pronto per essere iniettato nel `<head>` del layout `app`.

```php
/** @see Modules/Meetup/app/Models/Event.php */
public function toSchemaOrg(): array {
    // Genera JSON-LD validato da Google Event Rich Results
}
```

> [!IMPORTANT]
> **SEO Rule**: Tutte le date devono includere il fuso orario (ISO 8601) per evitare errori nel Google Search Console. Laraxot gestisce questo automaticamente tramite i cast di Carbon.
