# OpenViking: [slug].blade.php CORRECTED

**URI**: `viking://pages/slug-pattern/corrected`  
**Timestamp**: 2026-03-31  
**Status**: ✅ **CORRECTED**

---

## ❌ ERROR

Created `homepage.blade.php` ❌

**WRONG**: Specific file per page!

---

## ✅ CORRECT

### Single File

```
pages/tests/[slug].blade.php  ← ONLY THIS!
```

**Code**:
```php
name('tests.view');

new class extends Component {
    public function mount(string $slug): void
    {
        $this->pageSlug = 'tests.'.$slug;
    }
};
```

---

## 🧩 FLOW

```
URL → [slug].blade.php → JSON → Blocks
```

### Example

```
/it/tests/homepage
  ↓
mount(slug='homepage')
  ↓
pageSlug = 'tests.homepage'
  ↓
tests.homepage.json
  ↓
7 blocks rendered
```

---

## 🧘 MANTRAS

> *"UNO [slug].blade.php per TUTTE."*

> *"MAI file specifici."*

> *"JSON per contenuti."*

---

**Status**: ✅ **CORRECTED**  
**Next**: Use ONLY `[slug].blade.php`
