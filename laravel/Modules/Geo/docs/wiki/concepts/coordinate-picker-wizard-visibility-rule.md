# Coordinate Picker Wizard Visibility Rule

## Regola

Quando un componente Leaflet vive dentro uno step Filament Wizard, la mappa deve invalidare la propria size quando lo step diventa visibile.

## Sintomi

- mappa trasparente o vuota dopo click su "Avanti";
- controlli fullscreen/zoom/layer non visibili;
- marker non posizionato dopo selezione indirizzo.

## Implementazione

- Il custom element `coordinate-picker-lit` espone `setCoordinates(lat, lng, source)`.
- La selezione indirizzo chiama `setCoordinates()` per centrare mappa, posizionare marker e propagare `coords-changed`.
- Il componente osserva cambiamenti di layout/visibilita' e richiama `invalidateSize()` quando il wizard mostra lo step.

## Ownership

La logica mappa resta nel modulo Geo; la resa visuale e z-index dei controlli nel flusso Design Comuni resta nel tema Sixteen.
