---
title: "Regole per la Struttura dei DTO"
type: rule
tags: [dto, structure, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "dto-structure-rules-1 regole per la struttura dei dto"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Regole per la Struttura dei DTO

## Directory e Namespace

1. **Directory**
   - Usare SEMPRE `app/Datas` (plurale)
   - NON usare mai `Data` (singolare)
   - NON usare mai `DTOs`
   - Mantenere la directory minuscola

2. **Namespace**
   - Usare `Modules\Notify\Datas`
   - NON usare `App\Datas`
   - NON usare `Modules\Notify\App\Datas`
   - Mantenere coerenza con la struttura delle directory

## Naming e Struttura

1. **Naming dei File**
   - Usare il suffisso `Data` per i DTO
   - Esempio: `NetfunSmsRequestData.php`
   - NON usare `DTO` o altri suffissi

2. **Naming delle Classi**
   - Coincidere con il nome del file
   - Usare PascalCase
   - Esempio: `class NetfunSmsRequestData`

3. **Struttura delle Classi**
   - Estendere `Spatie\LaravelData\Data`
   - Usare type hints per tutte le proprietà
   - Usare constructor property promotion
   - Documentare con PHPDoc

## Best Practices

1. **Tipizzazione**
   - Usare type hints per tutte le proprietà
   - Usare tipi nullable quando appropriato
   - Documentare i tipi con PHPDoc

2. **Validazione**
   - Implementare regole di validazione
   - Usare spatie/laravel-data per la validazione
   - Validare i dati in ingresso

3. **Documentazione**
   - Documentare ogni DTO
   - Documentare le proprietà
   - Documentare i metodi
   - Mantenere la documentazione aggiornata

## Checklist di Verifica

1. **Directory**
   - [ ] La directory è `app/Datas` (plurale)
   - [ ] La directory è minuscola
   - [ ] Non ci sono directory `Data` o `DTOs`

2. **Namespace**
   - [ ] Il namespace è `Modules\Notify\Datas`
   - [ ] Non ci sono namespace errati

3. **Naming**
   - [ ] Il file usa il suffisso `Data`
   - [ ] La classe usa PascalCase
   - [ ] Il nome della classe coincide con il file

4. **Struttura**
   - [ ] La classe estende `Spatie\LaravelData\Data`
   - [ ] Usa type hints
   - [ ] Usa constructor property promotion
   - [ ] Ha PHPDoc

5. **Validazione**
   - [ ] Implementa regole di validazione
   - [ ] Usa spatie/laravel-data
   - [ ] Valida i dati in ingresso

## Esempi di Errori Comuni

1. **Directory Errate**
   ```php
   // ERRATO
   app/Data/NetfunSmsRequestData.php
   app/DTOs/NetfunSmsRequestData.php
   
   // CORRETTO
   app/Datas/NetfunSmsRequestData.php
   ```

2. **Namespace Errati**
   ```php
   // ERRATO
   namespace App\Datas;
   namespace Modules\Notify\App\Datas;
   
   // CORRETTO
   namespace Modules\Notify\Datas;
   ```

3. **Naming Errato**
   ```php
   // ERRATO
   class NetfunSmsRequestDTO
   class NetfunSmsRequest
   
   // CORRETTO
   class NetfunSmsRequestData
   ```

## Riferimenti

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [spatie/laravel-data](https://github.com/spatie/laravel-data)
- [Laravel Best Practices](https://laravel.com/docs/best-practices) 
