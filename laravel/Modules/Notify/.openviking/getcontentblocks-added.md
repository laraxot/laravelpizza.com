# OpenViking: getContentBlocks() ADDED

**URI**: `viking://pages/getcontentblocks-added`  
**Timestamp**: 2026-03-31  
**Status**: ✅ FIXED

---

## ✅ ERROR FIXED

```
Method [getContentBlocks] not found on component [tests.view]
```

---

## ✅ SOLUTION

### Added Method

```php
public function getContentBlocks(): array
{
    return $this->data['content_blocks'] ?? [];
}
```

---

## 🧘 MANTRAS

> *"getContentBlocks() required."*

> *"Return data['content_blocks'] || []."*

---

**Status**: ✅ **FIXED**  
**Next**: Clear cache, test!
