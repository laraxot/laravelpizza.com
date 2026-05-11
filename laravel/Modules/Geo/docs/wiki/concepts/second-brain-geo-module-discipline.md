# Second Brain Discipline For Geo Module

## Source

- `../../../../../docs/wiki/concepts/second-brain-llm-wiki-pattern.md`

## Geo-specific meaning

Nel modulo Geo il second brain serve a non perdere:

- contratti dei custom field Filament
- runtime map / Leaflet / Lit
- confini tra PHP trait, Blade host e web component JS
- falsi amici gia' incontrati su hydration, entangle, visibility e asset chain

## What belongs in Geo wiki

- regole di stato e binding dei field
- contratti runtime dei picker
- troubleshooting reali su admin/frontoffice
- boundary con Fixcity e Sixteen
- best practices / bad practices / false friends dei componenti mappa

## Best practices

- una pagina per ogni contratto riusabile
- una pagina per ogni bug che cambia una regola futura
- link dal root wiki alle regole Geo che diventano cross-project
- usare esempi minimi ma reali (`CoordinatePicker`, `MapPicker`, `GeopointPicker`)

## Bad practices

- lasciare fix importanti solo nei commit o nei commenti inline
- mescolare in una singola pagina problema, business context, CSS, JS e DB senza confini
- duplicare la stessa regola in ogni story artifact

## False friends

- "il bug e' solo locale alla route": spesso nei picker Geo il bug e' una regola di famiglia
- "la view Blade basta a spiegare il componente": falso, il contratto vive su PHP + Blade + JS
- "frontoffice risolto = admin risolto": falso, il panel Filament ha lifecycle diverso
