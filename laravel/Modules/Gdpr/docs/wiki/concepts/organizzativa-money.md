## Organizzativa Money

### URL
`/performance/admin/performance-fondos/{id}/organizzativa-money`

### Scopo
Pagina che esegue il calcolo e la ripartizione della quota organizzativa
("Organizzativa Money") per un fondo performance, anno 2024 (tipo 'dip').

### Pipeline di calcolo (getViewData)
1. UpdateAssenzeAction — aggiorna assenze del personale
2. UpdateQuotaTeoricaAction — calcola quota teorica
3. UpdateBudgetAssegnatoAction — calcola budget assegnato
4. UpdateQuotaEffettivaAction — calcola quota effettiva
5. UpdateRestiAction — calcola i resti
6. UpdateTotValutatoreIdAction — aggiorna totali per valutatore
7. UpdateRestiPondByValutatoreIdAction — resti ponderati per valutatore
8. UpdateImportoTotaleByValutatoreIdAction — importo totale per valutatore
9. CheckSumAction — verifica somme

### Route
Registrata in PerformanceFondoResource::getPages():
- Path: '/{record}/organizzativa-money'
- Page: OrganizzativaMoney (XotBasePage)
- View: 'performance::performance_fondo.pages.organizzativa_money'

### Trigger
Action `OrganizzativaSpreadMoneyAction` nella tabella PerformanceFondo,
collegamento via `PerformanceFondoResource::getUrl('organizzativa-money', ...)`.

### Files chiave
- Pages: Modules/Performance/app/Filament/Resources/PerformanceFondoResource/Pages/OrganizzativaMoney.php
- Action: Modules/Performance/app/Filament/Actions/Table/OrganizzativaSpreadMoneyAction.php
- Resource: Modules/Performance/app/Filament/Resources/PerformanceFondoResource.php

