# Componenti del Tema

## Logo

Il componente logo è uno degli elementi più importanti dell'interfaccia utente. Deve essere utilizzato in modo coerente in tutta l'applicazione.

### Utilizzo

```blade
<x-blocks.logo
    src="/path/to/logo.svg"
    alt="Nome Azienda"
    size="h-12 w-auto"  // Dimensione predefinita
/>
```

### Proprietà

- `src`: Percorso dell'immagine del logo
- `alt`: Testo alternativo per accessibilità
- `size`: Dimensioni del logo (default: h-12 w-auto)
- `url`: Link di destinazione (opzionale)
- `title`: Titolo da mostrare accanto al logo (opzionale)
- `description`: Descrizione da mostrare accanto al logo (opzionale)

### Best Practices

1. **Dimensioni**:
   - Header principale: h-12 w-auto
   - Footer: h-8 w-auto
   - Mobile: h-10 w-auto

2. **Accessibilità**:
   - Fornire sempre un testo alternativo significativo
   - Assicurarsi che il contrasto sia sufficiente
   - Mantenere una dimensione minima di 24x24px

3. **Consistenza**:
   - Utilizzare lo stesso logo in tutta l'applicazione
   - Mantenere proporzioni coerenti
   - Evitare distorsioni dell'immagine

4. **Responsive**:
   - Il logo deve essere scalabile
   - Utilizzare `w-auto` per mantenere le proporzioni
   - Testare su diverse dimensioni di schermo

### Esempi

```blade
{{-- Logo nell'header --}}
<x-blocks.logo
    src="/images/logo.svg"
    alt="il progetto"
    size="h-12 w-auto"
/>

{{-- Logo nel footer --}}
<x-blocks.logo
    src="/images/logo.svg"
    alt="il progetto"
    size="h-8 w-auto"
/>

{{-- Logo con titolo --}}
<x-blocks.logo
    src="/images/logo.svg"
    alt="il progetto"
    title="il progetto"
    description="La tua salute al primo posto"
/>
```

## Collegamenti tra versioni di components.md
* [components.md](../../../UI/docs/components.md)
* [components.md](../../../UI/docs/themes/components.md)
* [components.md](../../../Cms/docs/components.md)
* [components.md](../../../../Themes/One/docs/components.md)
