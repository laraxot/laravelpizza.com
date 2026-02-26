---
title: SushiToJsons/Orbit
description: Salvataggio su File invece che in tabella
---

# Invece di usare Orbit {#invece-di-usare-orbit}

Pacchetto di riferimento [[Jigsaw documentation](https://github.com/ryangjchandler/orbit)](https://github.com/ryangjchandler/orbit)

Il suo problema che non funzionava con le traduzioni

# Trait SushiToJsons {#trait-sushi-to-jsons }

Come Orbit, permette di salvare le istanze di un modello dentro dei file json, all'interno della configurazione locale che si sta utilizzando.

Esempio: se si vuole utilizzare dentro il modello Page, il singolo json di ogni istanza salvata verrà memorizzato dentro laravel\config\estensione_dominio\dominio\database\content\pages  

Per il modello Menu, il json verrà salvato dentro laravel\config\estensione_dominio\dominio\database\content\menus  

Aggiungere al modello su cui si vuole utilizzare

```
    use Modules\Tenant\Models\Traits\SushiToJsons;
    ...
    ...
    use \Sushi\Sushi;
    use SushiToJsons;
```

Aggiungere la funzione

```
public function getRows(): array
{
    return $this->getSushiRows();
}
```