# MCQ — Contract Inheritance Sigma (2026-06-15)

## Domanda 1

Cosa c'è di sbagliato in `class Qua00f extends BaseDateRangeModel implements Contracts\DateRangeFieldsContract`?

A) `BaseDateRangeModel` non esiste come classe  
B) `Contracts\DateRangeFieldsContract` è già implementato da `BaseDateRangeModel`, la ridichiarazione è ridondante  
C) PHP non permette `implements` su classi che estendono classi astratte  
D) `BaseDateRangeModel` non può implementare interfacce  

**Risposta corretta: B**

---

## Domanda 2

Quale modello Sigma estende `BaseDateRangeModel` ed ERA già corretto (senza `implements` ridondante)?

A) `Qua00f`  
B) `Rep00f`  
C) `Sto00f`  
D) Nessuno dei precedenti  

**Risposta corretta: C**

---

## Domanda 3

Dove vive la regola "contract-inheritance-no-redeclare" in formato canonico?

A) `docs/wiki/rules/class-inheritance-principles.md`  
B) `laravel/Modules/Sigma/docs/wiki/rules/contract-inheritance-no-redeclare.md`  
C) `docs/chat/handoff-contract-inheritance-no-redeclare.md`  
D) Tutte le precedenti sono fonti valide  

**Risposta corretta: D** (la regola è documentata in tutti e tre i posti, con la versione canonica locale in B)

---

## Domanda 4

Perché `implements Contracts\DateRangeFieldsContract` non va ripetuto sui figli di `BaseDateRangeModel`?

A) Perché PHP lo vieta esplicitamente  
B) Perché l'interfaccia si eredita per OOP — il figlio automaticamente implementa tutto ciò che implementa il padre  
C) Perché `BaseDateRangeModel` usa `CommonScope` che già implementa l'interfaccia  
D) Perché `DateRangeFieldsContract` è deprecato  

**Risposta corretta: B**

---

## Domanda 5

Quanti modelli Sigma estendono `BaseDateRangeModel`? E quanti di questi avevano `implements` ridondante?

A) 7 modelli, 2 con ridondanza (Qua00f, Rep00f)  
B) 5 modelli, 3 con ridondanza  
C) 7 modelli, 5 con ridondanza  
D) 3 modelli, 0 con ridondanza  

**Risposta corretta: A** (7: Asz00k1, Asz00f, Qua00f, Qua03f, Rep00f, Sto00f, Dipt00f. Solo Qua00f e Rep00f avevano `implements` ridondante)
