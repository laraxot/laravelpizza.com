Sto aprendo questa discussione per fissare una convenzione architetturale importante del modulo `User`.

## Convenzione

Ogni classe del vendor `Laravel\Passport` che estende Eloquent `Model` deve avere un wrapper locale con prefisso `Oauth` dentro `Modules/User/app/Models`.

Esempi:

- `Laravel\Passport\Client` -> `Modules\User\Models\OauthClient`
- `Laravel\Passport\Token` -> `Modules\User\Models\OauthToken`
- `Laravel\Passport\DeviceCode` -> `Modules\User\Models\OauthDeviceCode`

## Perche questa regola serve

- evitiamo dipendenza diretta dal vendor nel codice applicativo
- manteniamo un punto unico per `connection`, policy e personalizzazioni future
- possiamo esporre questi model in Filament/admin senza hack sul vendor
- se Passport aggiunge un nuovo model Eloquent, un test deve segnalarci il buco subito

## Audit iniziale

Nel vendor Passport attuale i model Eloquent principali risultano gia coperti dai wrapper `Oauth*` del modulo `User`.

Il lavoro da fare quindi non e “creare classi mancanti a caso”, ma:

1. blindare la convenzione con test
2. documentarla nelle regole operative locali
3. ricordare che la sorgente canonica del model resta il vendor Passport, mentre il codice applicativo usa il wrapper `Modules\User\Models\Oauth*`

Procedo in questa direzione e aggiorno qui con i progressi verificati.
