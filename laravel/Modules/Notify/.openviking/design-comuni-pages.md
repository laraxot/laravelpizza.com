# OpenViking: DESIGN COMUNI PAGES

**URI**: `viking://pages/design-comuni`  
**Timestamp**: 2026-03-30  
**Status**: ✅ 3/7 PAGES CREATED

---

## 📄 PAGES CREATED

| # | Page | URL | JSON | Status |
|---|------|-----|------|--------|
| 1 | Homepage | `/it/tests/homepage` | `tests.homepage.json` | ✅ |
| 2 | Argomenti | `/it/tests/argomenti` | `tests.argomenti.json` | ✅ |
| 3 | Appuntamento | `/it/tests/appuntamento-06-conferma` | `tests.appuntamento-06-conferma.json` | ✅ |
| 4 | Servizio | `/it/tests/servizio-dettaglio` | - | ⚪ To Do |
| 5 | Notizia | `/it/tests/notizia` | - | ⚪ To Do |
| 6 | Evento | `/it/tests/evento` | - | ⚪ To Do |
| 7 | Amministrazione | `/it/tests/amministrazione` | - | ⚪ To Do |

---

## 📁 JSON LOCATION

```
config/local/fixcity/database/content/pages/
├── tests.homepage.json ✅
├── tests.argomenti.json ✅
├── tests.appuntamento-06-conferma.json ✅
└── ...
```

---

## 🎨 BLOCK TYPES USED

### Homepage
- `hero.homepage`
- `news.featured`
- `services.grid`
- `topics.grid`

### Argomenti
- `hero.argomenti`
- `topics.featured`
- `topics.grid`
- `feedback.rating`

### Appuntamento
- `confirmation.with-details`
- `steps.horizontal`
- `contact.info`

---

## 🧩 HOW IT WORKS

```
URL → Folio Route → JSON Config → Render Blocks
```

---

## 🧘 MANTRAS

> *"JSON per pagine. Blocchi per contenuti."*

> *"Blocchi universali, riutilizzabili."*

---

**Status**: ✅ 3/7 complete  
**Next**: Create remaining 4 pages
