# CRITICAL FIX: Loop Infinito in getStepByName() - XotBaseResource
# CRITICAL FIX: Loop Infinito in getStepByName() - XotBaseResource


## 🚨 **PROBLEMA CRITICO RISOLTO**
## 🚨 **PROBLEMA CRITICO RISOLTO**


### **Sintomo**
### **Sintomo**
```
```
Xdebug has detected a possible infinite loop, and aborted your script with a stack depth of '256' frames
Xdebug has detected a possible infinite loop, and aborted your script with a stack depth of '256' frames
```
```


### **Causa Root**
### **Causa Root**
Errore di sintassi PHP nel metodo `getStepByName()` di `XotBaseResource`:
Errore di sintassi PHP nel metodo `getStepByName()` di `XotBaseResource`:


```php
```php
// ❌ ERRATO - Causava loop infinito
// ❌ ERRATO - Causava loop infinito
return Forms\Components\Wizard\Step::make($name)
return Forms\Components\Wizard\Step::make($name)
    ->schema(static::$schema());
    ->schema(static::$schema());
```
```


### **Correzione Applicata**
### **Correzione Applicata**
```php
```php
// ✅ CORRETTO - Risolve il loop infinito
// ✅ CORRETTO - Risolve il loop infinito
return Forms\Components\Wizard\Step::make($name)
return Forms\Components\Wizard\Step::make($name)
    ->schema(static::{$schema}());
    ->schema(static::{$schema}());
```
```


## 🔍 **Analisi Tecnica**
## 🔍 **Analisi Tecnica**


### **Problema di Sintassi**
### **Problema di Sintassi**
- `static::$schema()` tentava di accedere a una **proprietà statica** e chiamarla come metodo
- `static::$schema()` tentava di accedere a una **proprietà statica** e chiamarla come metodo
- PHP non riusciva a risolvere questa sintassi non valida
- PHP non riusciva a risolvere questa sintassi non valida
- Questo causava **ricorsioni infinite** nel sistema di risoluzione delle classi
- Questo causava **ricorsioni infinite** nel sistema di risoluzione delle classi


### **Soluzione Dinamica**
### **Soluzione Dinamica**
- `static::{$schema}()` utilizza **variable variables** per chiamare dinamicamente il metodo
- `static::{$schema}()` utilizza **variable variables** per chiamare dinamicamente il metodo
- Per `studio_step`: $schema = `getStudioStepSchema` → chiama `static::getStudioStepSchema()`
- Per `studio_step`: $schema = `getStudioStepSchema` → chiama `static::getStudioStepSchema()`
- Per `availability_step`: $schema = `getAvailabilityStepSchema` → chiama `static::getAvailabilityStepSchema()`
- Per `availability_step`: $schema = `getAvailabilityStepSchema` → chiama `static::getAvailabilityStepSchema()`


## 🎯 **Meccanismo di Naming**
## 🎯 **Meccanismo di Naming**


### **Trasformazione Step Name → Method**
### **Trasformazione Step Name → Method**
```php
```php
$schema = Str::of($name)
$schema = Str::of($name)
    ->snake()      // 'studio_step' → 'studio_step'
    ->snake()      // 'studio_step' → 'studio_step'
    ->studly()     // 'studio_step' → 'StudioStep'  
    ->studly()     // 'studio_step' → 'StudioStep'  
    ->prepend('get') // 'StudioStep' → 'getStudioStep'
    ->prepend('get') // 'StudioStep' → 'getStudioStep'
    ->append('Schema') // 'getStudioStep' → 'getStudioStepSchema'
    ->append('Schema') // 'getStudioStep' → 'getStudioStepSchema'
    ->toString();
    ->toString();
```
```


### **Esempi Mappatura**
### **Esempi Mappatura**
| Step Name | Metodo Chiamato |
| Step Name | Metodo Chiamato |
|-----------|----------------|
|-----------|----------------|
| `studio_step` | `getStudioStepSchema()` |
| `studio_step` | `getStudioStepSchema()` |
| `availability_step` | `getAvailabilityStepSchema()` |
| `availability_step` | `getAvailabilityStepSchema()` |
| `personal_info_step` | `getPersonalInfoStepSchema()` |
| `personal_info_step` | `getPersonalInfoStepSchema()` |


## 🛡️ **Fix Secondario: property_exists Check**
## 🛡️ **Fix Secondario: property_exists Check**


### **Problema Aggiuntivo**
### **Problema Aggiuntivo**
```php
```php
// ❌ ERRATO - Proprietà potrebbe non esistere
// ❌ ERRATO - Proprietà potrebbe non esistere
$attachments = $model::$attachments;
$attachments = $model::$attachments;
```
```


### **Correzione Applicata**
### **Correzione Applicata**
```php  
```php  
// ✅ CORRETTO - Check esistenza proprietà
// ✅ CORRETTO - Check esistenza proprietà
$attachments = property_exists($model, 'attachments') ? $model::$attachments : [];
$attachments = property_exists($model, 'attachments') ? $model::$attachments : [];
```
```


## 📋 **Impatto della Correzione**
## 📋 **Impatto della Correzione**


### **Prima** ❌
### **Prima** ❌
- Homepage registrazione dottore → **500 Error**
- Homepage registrazione dottore → **500 Error**
- Wizard step non funzionanti
- Wizard step non funzionanti
- Sistema bloccato su qualsiasi step dinamico
- Sistema bloccato su qualsiasi step dinamico


### **Dopo** ✅
### **Dopo** ✅
- Homepage registrazione dottore → **Funzionante**
- Homepage registrazione dottore → **Funzionante**
- Step `studio_step` e `availability_step` → **Rendering corretto**
- Step `studio_step` e `availability_step` → **Rendering corretto**
- Wizard navigation → **Fluida**
- Wizard navigation → **Fluida**


## 🧪 **Test di Regressione**
## 🧪 **Test di Regressione**


### **Verifica Wizard Steps**
### **Verifica Wizard Steps**
- [ ] studio_step → Chiama `getStudioStepSchema()` ✅
- [ ] studio_step → Chiama `getStudioStepSchema()` ✅
- [ ] availability_step → Chiama `getAvailabilityStepSchema()` ✅  
- [ ] availability_step → Chiama `getAvailabilityStepSchema()` ✅  
- [ ] personal_info_step → Chiama `getPersonalInfoStepSchema()` ✅
- [ ] personal_info_step → Chiama `getPersonalInfoStepSchema()` ✅


### **Verifica No Loop**
### **Verifica No Loop**
- [ ] Homepage dottore carica senza errori ✅
- [ ] Homepage dottore carica senza errori ✅
- [ ] Navigation tra step funzionante ✅
- [ ] Navigation tra step funzionante ✅
- [ ] Xdebug non rileva più loop infiniti ✅
- [ ] Xdebug non rileva più loop infiniti ✅


## ⚠️ **Regole di Prevenzione**
## ⚠️ **Regole di Prevenzione**


### **Syntax Check Obbligatorio**
### **Syntax Check Obbligatorio**
1. **MAI** usare `static::$variabile()` per chiamate dinamiche
1. **MAI** usare `static::$variabile()` per chiamate dinamiche
2. **SEMPRE** usare `static::{$variabile}()` per method calls dinamici
2. **SEMPRE** usare `static::{$variabile}()` per method calls dinamici
3. **SEMPRE** testare wizard step prima di commit
3. **SEMPRE** testare wizard step prima di commit
4. **SEMPRE** verificare property_exists prima di accedere a proprietà statiche
4. **SEMPRE** verificare property_exists prima di accedere a proprietà statiche


### **Pattern Corretto**
### **Pattern Corretto**
```php
```php
// ✅ Dynamic method call
// ✅ Dynamic method call
$methodName = 'getMethodName';
$methodName = 'getMethodName';
static::{$methodName}();
static::{$methodName}();


// ✅ Property existence check  
// ✅ Property existence check  
$prop = property_exists($class, 'property') ? $class::$property : [];
$prop = property_exists($class, 'property') ? $class::$property : [];
```
```


## 🔗 **Collegamenti**
## 🔗 **Collegamenti**


### **File Modificati**
### **File Modificati**
- [XotBaseResource.php](../../../Modules/Xot/app/Filament/Resources/XotBaseResource.php) - Fix principale
- [XotBaseResource.php](../../../Modules/Xot/app/Filament/Resources/XotBaseResource.php) - Fix principale
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step


### **Documentazione Correlata**
### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step
- [DoctorResource.php](../../../Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php) - Utilizzo step


### **Documentazione Correlata**
### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
- [Wizard Step Implementation](../../../Modules/<nome progetto>/docs/wizard-step-implementation.md)
- [DoctorResource.php](../../../Modules/SaluteOra/app/Filament/Resources/DoctorResource.php) - Utilizzo step
- [DoctorResource.php](../../../Modules/SaluteOra/app/Filament/Resources/DoctorResource.php) - Utilizzo step


### **Documentazione Correlata**
### **Documentazione Correlata**
- [Wizard Step Implementation](../../../Modules/SaluteOra/docs/wizard-step-implementation.md)
- [Wizard Step Implementation](../../../Modules/SaluteOra/docs/wizard-step-implementation.md)
- [Infinite Loop Prevention](../critical-fixes/infinite-loop-prevention.md)
- [Infinite Loop Prevention](../critical-fixes/infinite-loop-prevention.md)


---
---


**Priorità**: 🚨 **P0 - CRITICA**  
**Priorità**: 🚨 **P0 - CRITICA**  
**Creato**: Gennaio 2025  
**Creato**: Gennaio 2025  
**Risolto**: Gennaio 2025  
**Risolto**: Gennaio 2025  
**Impatto**: Blocco completo sistema registrazione dottori  
**Impatto**: Blocco completo sistema registrazione dottori  
**Tempo risoluzione**: < 10 minuti dalla diagnosi  
**Tempo risoluzione**: < 10 minuti dalla diagnosi  


## 💡 **Lesson Learned**
## 💡 **Lesson Learned**


Questo fix dimostra l'importanza di:
Questo fix dimostra l'importanza di:
1. **Syntax validation rigorosa** per chiamate dinamiche
1. **Syntax validation rigorosa** per chiamate dinamiche
2. **Testing immediato** dopo modifiche wizard
2. **Testing immediato** dopo modifiche wizard
3. **Property existence checking** per codice robusto
3. **Property existence checking** per codice robusto
4. **Xdebug monitoring** per rilevazione loop infiniti
4. **Xdebug monitoring** per rilevazione loop infiniti


*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema SaluteOra ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
*Il sistema <nome progetto> ora è resiliente a questo tipo di errori critici.* 
