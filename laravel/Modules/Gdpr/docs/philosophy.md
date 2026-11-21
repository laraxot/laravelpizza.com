---
title: "philosophy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "philosophy"
issues: []
discussions: []
---

# Gdpr Module: Privacy & Compliance

> **Data Protection & Cookie Consent** — GDPR, CCPA, consent tracking, data export/deletion.

---

title: "philosophy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "philosophy"
issues: []
discussions: []
## Zen

**"User owns their data. Ask permission, log the answer, enable deletion."**

---

## Quick

### Models (7)
- **Consent** — User consent record (type: analytics, marketing, essential, version, granted_at)
- **Event** — Audit log of consent changes (user, type, action: granted/withdrawn)
- **ConsentCategory** — Categories (essential, optional, marketing)

### Pattern
```
Page load
  ↓
Check Consent.latest('type')
  ↓
If missing: show banner
  ↓
User checks/unchecks
  ↓
Save Consent + Event (immutable log)
  ↓
Fire analytics/tracking only if granted
```

### Actions (2)
- `SaveGdprConsentsAction` — Batch save user choices
- `UpdateGdprConsentsAction` — Update after init

### Dependencies
- Spatie Cookie Consent (UI helpers)

---

## Integrations

- User (export, deletion)
- Notify (consent withdrawal notification)
- Activity (log all consent changes)

---

## Best/Bad

✓ Immutable consent log (never delete Event, only new Consent)
✓ Granular categories (essential vs optional)
✓ Export on demand (User download)
❌ Ignoring withdrawal (user unchecks, still track)

---

## Compliance Checklist

✓ GDPR Art. 7 (consent proof)
✓ GDPR Art. 17 (right to deletion)
✓ GDPR Art. 20 (data portability)
✓ CCPA (opt-out default in CA)
❌ Not yet: erasure timeline (30-day queue)

---

## Roadmap

- Erasure jobs (User deletion scheduled, not instant)
- Consent analytics dashboard
- Auto-banner language detection

---

```
┌──────────────────────────┐
│ Gdpr (Privacy)           │
├──────────────────────────┤
│ Models: 7                │
│ Migrations: 4            │
│ Status: Stable           │
│ Compliance: GDPR, CCPA   │
└──────────────────────────┘
```

---

- **Generated**: 2026-09-06
- **Last Verified**: 2026-09-06 (module closure merge + quality baseline established)

