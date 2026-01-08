# Translation Best Practices for Geo Module

## Critical Rule: Keep Translations in Target Language

### Problem Identified
In `lang/it/address_item.php`, all translations were in English instead of Italian. This defeats the purpose of having language-specific translation files.

### The Fix
Always translate content to the target language of the file:

#### ❌ WRONG (English in Italian file):
```php
'route' => [
    'label' => 'route',
    'placeholder' => 'route',
    'helper_text' => 'route',
    'description' => 'route',
],
```

#### ✅ CORRECT (Italian in Italian file):
```php
'route' => [
    'label' => 'Via',
    'placeholder' => 'Inserisci la via',
    'helper_text' => 'Nome della via o strada',
    'description' => 'Indirizzo della via',
],
```

## Translation Structure Best Practices

### 1. Match Active Enum Fields
Only include translations for fields that are **active** in the corresponding Enum:
- Check which cases are NOT commented out in the Enum
- Remove translations for commented/deprecated fields
- Keep translation file synchronized with Enum definition

### 2. Complete Translation Fields
Each field should have all four translation keys:
- `label`: Short, human-readable name
- `placeholder`: Example text for form inputs
- `helper_text`: Brief explanation of the field
- `description`: More detailed field description

### 3. Italian-Specific Guidelines
- Use proper Italian terminology (e.g., "CAP" instead of "postal_code")
- Include articles and prepositions where appropriate
- Use formal but accessible language
- Consider Italian address conventions

### 4. Field-Specific Translations

#### Address Fields in Italian:
| English | Italian | Notes |
|---------|---------|-------|
| route | Via | Main street name |
| street_number | Numero Civico | Building number |
| locality | Località | Small area/fraction |
| administrative_area_level_3 | Comune | Municipality |
| administrative_area_level_2 | Provincia | Province (use 2-letter codes) |
| administrative_area_level_1 | Regione | Region |
| country | Paese | Country |
| postal_code | CAP | Italian postal code |
| latitude | Latitudine | Geographic coordinate |
| longitude | Longitudine | Geographic coordinate |
| notes | Note | Additional notes |

## Quality Checklist

When working with translations:

1. **Language Consistency**: Is everything in the correct language?
2. **Enum Synchronization**: Are all active enum fields translated?
3. **Completeness**: Does each field have all 4 translation keys?
4. **Cultural Appropriateness**: Are terms culturally relevant?
5. **Placeholder Quality**: Are placeholders helpful examples?
6. **Description Clarity**: Are descriptions informative but concise?

## Common Pitfalls to Avoid

1. **Copy-Paste Errors**: Don't leave English text in Italian files
2. **Outdated Translations**: Remove translations for deprecated enum fields
3. **Inconsistent Terminology**: Use the same term throughout the application
4. **Missing Fields**: Don't forget helper_text and description
5. **Literal Translations**: Consider cultural context, not just word-for-word

## Remember
Translation files are part of your codebase. Treat them with the same care as your PHP code - keep them clean, synchronized, and well-documented.