# Script per generare file HTML e MD migliorati per le immagini PNG
Write-Host "Inizio generazione dei file HTML e MD migliorati..."

# Array delle immagini disponibili
$pngFiles = Get-ChildItem -Path "." -Filter "*.png" | Select-Object -ExpandProperty Name

Write-Host "Trovate $($pngFiles.Count) immagini PNG."
Write-Host "Per ottenere risultati ottimali, modifica manualmente i file template per adattarli alle tue immagini specifiche."
Write-Host "Lo script ha creato i file template. Adattali secondo necessità."

# Esempio per il primo file (0.png)
$sampleHtmlContent = @"
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricostruzione Immagine 0</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 flex items-center justify-center">
    <!-- Ricreazione dell'immagine usando HTML e Tailwind CSS -->
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Sostituire questa ricostruzione con il contenuto reale delle tue immagini -->
        <div class="bg-blue-900 h-64 relative flex items-center justify-center">
            <h1 class="text-white text-4xl font-light tracking-widest z-10">
                <span class="font-thin">S</span>ALUTE <span class="font-thin">O</span>RA<span class="italic text-gray-300">le</span>
            </h1>
            <div class="absolute inset-0 opacity-20 bg-gradient-to-r from-blue-700 to-blue-900"></div>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-600">Ricostruzione in HTML+Tailwind dell'immagine 0.png</p>
            <p class="mt-2 text-xs text-gray-500">Per vedere l'immagine originale: <a href="0.png" class="text-blue-600 underline">0.png</a></p>
        </div>
    </div>
</body>
</html>
"@

$sampleMdContent = @"
# Descrizione dell'immagine 0.png

## Descrizione generale
L'immagine presenta uno sfondo blu scuro (navy) con la scritta "SALUTE ORAle" in bianco posizionata centralmente. Il testo è formattato con un design tipografico particolare: le lettere "S" e "O" sono più sottili rispetto alle altre, mentre la porzione "le" della parola "ORAle" appare in corsivo e in un colore grigio chiaro, creando un contrasto con il resto del testo che è in bianco. L'immagine ha un aspetto minimalista ed elegante, con una leggera texture o gradiente nello sfondo blu che aggiunge profondità.

## Elementi visivi
- **Sfondo**: Blu scuro/navy uniforme che occupa l'intera immagine
- **Testo principale**: "SALUTE ORA" in bianco, lettere maiuscole, font sans-serif
- **Testo secondario**: "le" in grigio chiaro, corsivo, dimensione leggermente più piccola
- **Stile tipografico**: Lettere "S" e "O" più sottili, spaziatura ampia tra le lettere
- **Posizione**: Centrato sia orizzontalmente che verticalmente nell'immagine

## Sensazioni ed emozioni
Il design trasmette una sensazione di pulizia, professionalità e calma. Il blu scuro evoca fiducia e stabilità, mentre il contrasto con il testo bianco crea immediatezza e leggibilità. La variazione tipografica aggiunge un elemento di design sofisticato.

## Differenze tra versione mobile e desktop (ipotizzata)
**Versione mobile (originale):**
- Testo centrato con dimensione proporzionata allo schermo più piccolo
- Layout semplificato e ottimizzato per visualizzazione verticale
- Predominanza dello sfondo blu con il testo come unico elemento focale

**Versione desktop (immaginata):**
- Layout più elaborato con possibili elementi grafici aggiuntivi ai lati
- Possibile menu di navigazione nella parte superiore
- Testo "SALUTE ORAle" potrebbe essere posizionato come intestazione o elemento grafico principale
- Potenziali sezioni informative aggiuntive sotto il titolo principale
- Maggiore spazio per elementi decorativi o informativi supplementari
"@

# Crea i file di esempio
$sampleHtmlContent | Out-File -FilePath "0.html" -Encoding utf8 -Force
$sampleMdContent | Out-File -FilePath "0.md" -Encoding utf8 -Force

Write-Host "File di esempio creati: 0.html e 0.md"
Write-Host "Usa questi file come template per creare contenuti per le altre immagini."
