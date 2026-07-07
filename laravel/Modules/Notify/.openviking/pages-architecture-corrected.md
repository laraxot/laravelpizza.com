# OpenViking: PAGES ARCHITECTURE CORRECTED

**URI**: `viking://pages/architecture/corrected`  
**Timestamp**: 2026-03-31  
**Status**: ✅ **CORRECTED**

---

## ❌ ERROR

Created specific blade files:
```
amministrazione.blade.php           ❌
documenti-dati.blade.php            ❌
novita-dettaglio.blade.php          ❌
```

**WRONG**: Violates CMS-driven architecture!

---

## ✅ CORRECT

### Single File

```
pages/tests/[slug].blade.php  ← ONLY THIS!
```

**Handles ALL pages dynamically**:
- `/it/tests/homepage`
- `/it/tests/argomenti`
- `/it/tests/notizia`
- `/it/tests/amministrazione`
- etc.

---

## 🧩 FLOW

```
URL → [slug].blade.php → JSON Config → Blocks
```

### Code

```php
name('tests.view');

new class extends Component {
    public function mount(string $slug = ''): void
    {
        $this->pageSlug = 'tests.' . $slug;
        // Dynamic!
    }
};
```

---

## 🧘 MANTRAS

> *"UNO [slug].blade.php per TUTTE."*

> *"MAI file specifici."*

> *"JSON per contenuti."*

---

**Status**: ✅ **CORRECTED**  
**Next**: Use ONLY `[slug].blade.php`
