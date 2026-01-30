# Script per creare file HTML e MD dettagliati per ogni immagine PNG
# Questo script crea template che dovranno essere personalizzati manualmente per ogni immagine

function Create-HtmlFile {
    param (
        [string]$filename,
        [int]$index,
        [bool]$overwrite = $false
    )
    
    $outputPath = $filename.Replace(".png", ".html")
    
    # Se il file esiste e overwrite è false, salta
    if ((Test-Path $outputPath) -and (-not $overwrite)) {
        Write-Host "Il file $outputPath esiste già. Viene mantenuto."
        return
    }
    
    # Contenuto di base per file HTML (da personalizzare manualmente per ogni immagine)
    $htmlContent = @"
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricostruzione Immagine $index</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 flex items-center justify-center">
    <!-- 
    NOTA: Questo è un template. 
    Per ogni immagine dovresti:
    1. Sostituire questa sezione con una ricostruzione HTML+Tailwind dell'immagine
    2. Adattare il design all'immagine specifica ($index.png) 
    -->
    
    <!-- Versione Mobile (default) -->
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-blue-900 h-64 relative flex items-center justify-center">
            <!-- Sostituisci con elementi adatti all'immagine $index.png -->
            <h1 class="text-white text-4xl font-light tracking-widest z-10">
                Immagine $index
            </h1>
            <div class="absolute inset-0 opacity-20 bg-gradient-to-r from-blue-700 to-blue-900"></div>
        </div>
        <div class="p-4">
            <p class="text-sm text-gray-600">Ricostruzione dell'immagine $index.png usando HTML+Tailwind</p>
            <p class="mt-2 text-xs text-gray-500">Per vedere l'immagine originale: <a href="$index.png" class="text-blue-600 underline">$index.png</a></p>
        </div>
    </div>
    
    <!-- Per la versione desktop, regola i media query e il layout come necessario -->
</body>
</html>
"@

    # Scrivi il contenuto nel file HTML
    $htmlContent | Out-File -FilePath $outputPath -Encoding utf8
    Write-Host "Creato file HTML: $outputPath"
}

function Create-MdFile {
    param (
        [string]$filename,
        [int]$index,
        [bool]$overwrite = $false
    )
    
    $outputPath = $filename.Replace(".png", ".md")
    
    # Se il file esiste e overwrite è false, salta
    if ((Test-Path $outputPath) -and (-not $overwrite)) {
        Write-Host "Il file $outputPath esiste già. Viene mantenuto."
        return
    }
    
    # Contenuto di base per file MD (da personalizzare manualmente per ogni immagine)
    $mdContent = @"
# Descrizione dettagliata dell'immagine $index.png

![Immagine $index]($index.png)

## Descrizione per un non vedente che conosce i colori

### Descrizione generale
<!-- 
NOTA: Questo è un template. 
Sostituisci questo testo con una descrizione dettagliata dell'immagine,
come se la stessi spiegando a una persona non vedente che conosce i colori.
Descrivi:
1. Cosa rappresenta l'immagine
2. Quali colori vengono utilizzati
3. Come sono disposti gli elementi
4. Sensazioni ed emozioni che trasmette l'immagine
-->

L'immagine mostra [descrizione dettagliata]. Lo sfondo è [colore] e presenta [elementi principali].
I colori predominanti sono [elenco colori], che insieme creano un'atmosfera [descrizione atmosfera].
Al centro dell'immagine si trova [elemento centrale], mentre [altri elementi] sono disposti [descrizione posizione].

### Elementi principali
- **Elemento 1**: [Descrizione dettagliata]
- **Elemento 2**: [Descrizione dettagliata]
- **Elemento 3**: [Descrizione dettagliata]

### Testo e tipografia
<!-- Descrivi qualsiasi testo presente nell'immagine, font, dimensioni, colori -->

### Sensazioni ed atmosfera
L'immagine trasmette una sensazione di [emozioni/sensazioni], attraverso l'uso di [elementi che creano queste sensazioni].

## Differenze tra versione mobile e desktop (immaginata)

### Versione mobile (originale)
<!-- Descrivi come appare l'immagine nella versione mobile -->

### Versione desktop (immaginata)
<!-- Descrivi come potrebbe apparire in versione desktop, mantenendo coerenza con la versione mobile -->

"@

    # Scrivi il contenuto nel file MD
    $mdContent | Out-File -FilePath $outputPath -Encoding utf8
    Write-Host "Creato file MD: $outputPath"
}

# Funzione principale
function Process-PngFiles {
    $pngFiles = Get-ChildItem -Path "." -Filter "*.png"
    $count = 0
    
    foreach ($file in $pngFiles) {
        $index = [int]($file.BaseName)
        $count++
        
        # Crea i file
        Create-HtmlFile -filename $file.Name -index $index
        Create-MdFile -filename $file.Name -index $index
    }
    
    Write-Host "Elaborazione completata. Processati $count file PNG."
    Write-Host "IMPORTANTE: I file creati sono solo template e devono essere personalizzati manualmente per ogni immagine."
}

# Esecuzione principale
Write-Host "Inizio creazione dei file HTML e MD per le immagini PNG..."
Process-PngFiles
