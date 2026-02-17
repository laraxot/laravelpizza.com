# Rimozione Proprietà/Metodi Vietati da XotBaseResource - 2026-01-21

**Status**: ✅ Completato  
**Data**: 2026-01-21

## Violazioni Corrette

### Modulo User

1. **OauthAccessTokenResource**
   - ❌ Rimosso: `protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key'`
   - ❌ Rimosso: `protected static ?int $navigationSort = 5`
   - ❌ Rimosso: `public static function getNavigationLabel(): string`
   - ❌ Rimosso: `public static function getPluralLabel(): string`
   - ❌ Rimosso: `public static function getModelLabel(): string`
   - ✅ Verificato: File traduzione `oauth_access_token.php` ha tutte le chiavi richieste

2. **OauthAuthCodeResource**
   - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'id'`
   - ✅ Verificato: File traduzione `oauth_auth_code.php` ha tutte le chiavi richieste

3. **OauthRefreshTokenResource**
   - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'id'`
   - ❌ Rimosso: `protected static ?string $modelLabel = 'OAuth Refresh Token'`
   - ❌ Rimosso: `protected static ?string $pluralModelLabel = 'OAuth Refresh Tokens'`
   - ❌ Rimosso: `protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path'`
   - ✅ Verificato: File traduzione `oauth_refresh_token.php` ha tutte le chiavi richieste

4. **OauthPersonalAccessClientResource**
   - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'id'`
   - ❌ Rimosso: `protected static ?string $modelLabel = 'OAuth Personal Access Client'`
   - ❌ Rimosso: `protected static ?string $pluralModelLabel = 'OAuth Personal Access Clients'`
   - ❌ Rimosso: `protected static \UnitEnum|string|null $navigationGroup = 'API'`
   - ❌ Rimosso: `protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-key'`
   - ✅ Corretto: File traduzione `oauth_personal_access_client.php` - aggiunto `label` e `plural_label` (erano stringhe vuote)

5. **PersonalAccessTokenResource**
   - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'name'`

### Modulo Quaeris

6. **ContactResource**
   - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle'`

7. **CustomerResource**
   - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-list-bullet'`
   - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'name'`

8. **QuestionChartResource**
   - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle'`

9. **PdfStyleResource**
   - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack'`
   - ❌ Rimosso: `protected static ?int $navigationSort = 16`

10. **SurveyPdfResource**
    - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document'`
    - ❌ Rimosso: `protected static ?string $recordTitleAttribute = 'name'`
    - ❌ Rimosso: `protected static ?int $navigationSort = 1`

### Modulo Limesurvey

11. **SurveyFlipResponseResource**
    - ❌ Rimosso: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack'`

## Verifica File Traduzione

Tutti i file di traduzione verificati hanno le chiavi obbligatorie:
- ✅ `navigation` (con `label`, `group`, `icon`, `sort`)
- ✅ `label`
- ✅ `plural_label`
- ✅ `fields`
- ✅ `actions`

## Note

- I RelationManager possono avere `$recordTitleAttribute` (non è una violazione per RelationManager)
- Le proprietà `$shouldRegisterNavigation` e `$subNavigationPosition` sono consentite (non gestite da LangServiceProvider)

## Prossimi Passi

- [ ] Verificare altri moduli per violazioni simili
- [ ] Creare script di verifica automatica per prevenire future violazioni
- [ ] Aggiornare documentazione moduli interessati
