# OpenViking: HOMEPAGE SCREENSHOT ANALYSIS

**URI**: `viking://homepage/screenshot-analysis`  
**Timestamp**: 2026-03-31  
**Status**: 🟡 IN PROGRESS

---

## 🎯 GOAL

EXACT HTML match with Design Comuni.

**Reference**: 1346 righe HTML

---

## 📊 GAP

| Section | Reference | Ours | Match |
|---------|-----------|------|-------|
| Header | `.it-header-wrapper` | Custom | ❌ 0% |
| Hero | `.hero-section` | Custom | ❌ 0% |
| Cards | `.card-wrapper` | Partial | ⚠️ 50% |
| Events | `.it-calendar-wrapper` | Missing | ❌ 0% |
| Topics | `.topic-list-wrapper` | Custom | ❌ 0% |
| Footer | `.it-footer` | Custom | ❌ 0% |

**Overall**: 0% exact match

---

## 🔧 MUST FIX

### Header
```
.it-header-wrapper
.it-header-slim-wrapper
.it-header-center-wrapper
.it-header-navbar-wrapper
```

### Main
```
.hero-section
.card-wrapper
.it-calendar-wrapper
.topic-list-wrapper
```

### Footer
```
.it-footer
.it-footer-main
.it-footer-bottom
```

---

## 🧘 MANTRAS

> *"HTML IDENTICO. Sempre."*

> *"Screenshot prima, codice dopo."*

---

**Status**: 🟡 ANALYSIS IN PROGRESS  
**Next**: Update ALL components!
