# Piano di completamento — Media

## Scopo
Gestire upload, storage, trasformazione e distribuzione di immagini e video localmente o su storage esterni.

## Piano BMAD

1. Mappare upload, validazione, MIME, storage, trasformazioni, FFmpeg e cleanup.
2. Verificare limiti, sicurezza dei file, fallback Imagick/HEIC e consistenza dei metadati.
3. Separare Actions, contratti e componenti Filament; evitare duplicazione tra driver.
4. Verificare `SettingPage`, configurazione tenant e test con filesystem finto.
5. Eseguire gate statici, Pest, coverage e controlli di performance.

## Criteri di accettazione
Un media valido è persistito una volta, trasformato in modo sicuro e recuperabile; errori e limiti sono osservabili.

