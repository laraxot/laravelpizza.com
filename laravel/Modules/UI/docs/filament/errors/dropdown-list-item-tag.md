# Errore: Tag Mancante nei Dropdown List Items

## Problema

Un errore comune nell'utilizzo dei componenti Filament è dimenticare di specificare il tag HTML corretto per gli elementi del menu dropdown. Questo porta a elementi non cliccabili e comportamenti inaspettati.

## Esempio di Errore

```blade
{{-- ERRATO --}}
<x-filament::dropdown.list.item
    :href="$item['url']"
    :active="request()->routeIs($item['route'])"
    class="cursor-pointer"
>
    {{ $item['label'] }}
</x-filament::dropdown.list.item>
```

## Soluzione

```blade
{{-- CORRETTO --}}
<x-filament::dropdown.list.item
    tag="a"
    :href="$item['url']"
    :active="request()->routeIs($item['route'])"
    class="cursor-pointer"
>
    {{ $item['label'] }}
</x-filament::dropdown.list.item>
```

## Spiegazione

- Il componente `x-filament::dropdown.list.item` di default non ha un tag HTML specifico
- Per renderlo cliccabile, è necessario specificare `tag="a"`
- Senza il tag corretto, l'elemento non avrà il comportamento di un link

## Best Practices

1. **Sempre specificare il tag**: Quando si usa `dropdown.list.item` per link, sempre aggiungere `tag="a"`
2. **Verificare il comportamento**: Testare sempre che gli elementi siano effettivamente cliccabili
3. **Documentare**: Aggiungere commenti per spiegare perché è necessario il tag
4. **Consistenza**: Mantenere lo stesso approccio in tutti i dropdown del progetto

## File da Controllare

- Tutti i file che utilizzano `x-filament::dropdown.list.item`
- In particolare:
  - Componenti di navigazione
  - Menu dropdown
  - Lista di azioni

## Collegamenti Correlati

- [Documentazione Filament Dropdown](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Best Practices UI](../best-practices.md)
- [Component Methods Compatibility](../component-methods-compatibility.md)
