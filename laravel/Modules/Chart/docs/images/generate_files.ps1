# Script to generate HTML and MD files for each PNG image
$pngFiles = Get-ChildItem -Path "." -Filter "*.png"

foreach ($file in $pngFiles) {
    $baseName = $file.BaseName
    $htmlFileName = "$baseName.html"
    $mdFileName = "$baseName.md"
    
    # Create HTML file with Tailwind CSS
    $htmlContent = @"
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immagine $baseName</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Mobile Version (Default) -->
    <div class="block md:hidden">
        <div class="max-w-full mx-auto p-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-4 bg-blue-900 text-white text-center">
                    <h1 class="text-xl font-semibold">Visualizzazione Mobile</h1>
                </div>
                <div class="p-4">
                    <img src="$baseName.png" alt="Immagine $baseName" class="w-full h-auto object-contain rounded">
                    <div class="mt-4 p-3 bg-gray-50 rounded">
                        <h2 class="text-lg font-medium text-gray-800 mb-2">Dettagli Immagine $baseName</h2>
                        <p class="text-sm text-gray-600">
                            Questa è la visualizzazione mobile ottimizzata dell'immagine $baseName.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Version (Hidden on mobile) -->
    <div class="hidden md:block">
        <div class="max-w-6xl mx-auto p-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="flex items-center justify-between bg-blue-800 text-white p-5">
                    <h1 class="text-2xl font-semibold">Visualizzazione Desktop</h1>
                    <div class="text-sm">Immagine $baseName</div>
                </div>
                <div class="p-6 flex flex-wrap">
                    <div class="w-2/3 pr-6">
                        <img src="$baseName.png" alt="Immagine $baseName" class="w-full h-auto object-contain rounded">
                    </div>
                    <div class="w-1/3">
                        <div class="sticky top-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-3 border-b pb-2">Informazioni</h2>
                            <div class="prose prose-sm text-gray-600">
                                <p>Questa è la visualizzazione desktop dell'immagine $baseName, con layout ottimizzato per schermi più grandi.</p>
                                <p class="mt-3">Sulla sinistra è possibile vedere l'immagine completa, mentre questa sezione fornisce dettagli e descrizioni aggiuntive.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
"@

    # Create MD file with description
    $mdContent = @"
# Immagine $baseName

![Immagine $baseName]($baseName.png)

## Descrizione
Questa è l'immagine $baseName dalla collezione di immagini. Quest'immagine potrebbe rappresentare contenuti relativi al progetto exabroker.

## Differenze tra versione Mobile e Desktop

### Versione Mobile
- Layout a singola colonna per ottimizzare lo spazio su schermi piccoli
- Immagine a piena larghezza per massimizzare la visibilità
- Elementi dell'interfaccia compatti e impilati verticalmente
- Font size ottimizzati per la lettura su dispositivi mobili

### Versione Desktop
- Layout a due colonne che sfrutta lo spazio orizzontale disponibile
- Immagine posizionata a sinistra (occupa 2/3 dello spazio)
- Pannello informativo a destra (occupa 1/3 dello spazio)
- Interfaccia più spaziosa con maggiori dettagli visibili contemporaneamente
- Navigazione più intuitiva grazie al maggiore spazio disponibile

## Note Tecniche
- L'immagine viene ridimensionata in modo responsivo per adattarsi alle diverse dimensioni dello schermo
- Vengono utilizzate media query CSS per alternare tra layout mobile e desktop
- Tailwind CSS è utilizzato per lo styling dell'interfaccia
"@

    # Only write the files if they don't already exist (to avoid overwriting existing custom files)
    if (-not (Test-Path $htmlFileName)) {
        $htmlContent | Out-File -FilePath $htmlFileName -Encoding utf8
        Write-Host "Created $htmlFileName"
    } else {
        Write-Host "$htmlFileName already exists, skipping"
    }
    
    if (-not (Test-Path $mdFileName)) {
        $mdContent | Out-File -FilePath $mdFileName -Encoding utf8
        Write-Host "Created $mdFileName"
    } else {
        Write-Host "$mdFileName already exists, skipping"
    }
}

Write-Host "Generation complete!"
