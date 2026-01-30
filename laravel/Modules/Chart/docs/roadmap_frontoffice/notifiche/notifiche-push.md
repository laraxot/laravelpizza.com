# Notifiche Push Browser - <nome progetto>

> **🔔 Sistema di notifiche push browser per comunicazioni immediate**

## 📊 Stato Implementazione: 40% 🔄

### Funzionalità Completate
- [x] **Service Worker base** (80%)
- [x] **Richiesta permessi utente** (90%)
- [ ] **Template notifiche** (60% - in corso)
- [ ] **Trigger automatici** (30% - pianificato)
- [ ] **Analytics tracking** (20% - pianificato)

---

## 🎯 Obiettivo e Scope

### Scopo
Implementare notifiche push browser per comunicazioni immediate:
- **Appuntamenti urgenti**: Cancellazioni, spostamenti dell'ultimo minuto
- **Promemoria finali**: 30 minuti prima dell'appuntamento
- **Aggiornamenti status**: Conferme/rifiuti da parte degli studi
- **Comunicazioni sistema**: Manutenzioni, aggiornamenti

### Vantaggi Attesi
- **Immediatezza**: Notifiche instantanee anche con app chiusa
- **Engagement**: +40% interaction rate vs email
- **Retention**: Riduzione abandono piattaforma
- **User Experience**: Comunicazione proattiva e tempestiva

---

## 🛠️ Implementazione Tecnica (In Corso)

### Service Worker Base
```javascript
// public/sw.js - Service Worker per notifiche push
self.addEventListener('push', function(event) {
    console.log('Push event received:', event);
    
    if (!event.data) {
        console.log('Push event but no data');
        return;
    }
    
    const data = event.data.json();
    console.log('Push data:', data);
    
    const options = {
        body: data.body,
        icon: '/icon-192x192.png',
        badge: '/badge-72x72.png',
        image: data.image,
        data: {
            url: data.url,
            appointment_id: data.appointment_id,
            action_type: data.action_type
        },
        actions: [
            {
                action: 'view',
                title: 'Visualizza',
                icon: '/icons/view.png'
            },
            {
                action: 'dismiss',
                title: 'Chiudi',
                icon: '/icons/close.png'
            }
        ],
        requireInteraction: data.urgent || false,
        silent: false,
        vibrate: data.urgent ? [200, 100, 200] : [100],
        timestamp: Date.now()
    };
    
    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    console.log('Notification clicked:', event);
    
    event.notification.close();
    
    const data = event.notification.data;
    
    if (event.action === 'view' || !event.action) {
        event.waitUntil(
            clients.openWindow(data.url)
        );
    }
    
    // Tracking click per analytics
    fetch('/api/notifications/track-click', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            notification_id: data.notification_id,
            action: event.action || 'click',
            timestamp: Date.now()
        })
    }).catch(console.error);
});
```

### Frontend Integration
```javascript
// resources/js/push-notifications.js
class PushNotificationManager {
    constructor() {
        this.registration = null;
        this.subscription = null;
        this.publicKey = document.querySelector('meta[name="vapid-public-key"]')?.content;
    }

    async init() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.warn('Push notifications not supported');
            return false;
        }

        try {
            // Register service worker
            this.registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered:', this.registration);

            // Check existing subscription
            this.subscription = await this.registration.pushManager.getSubscription();
            
            if (this.subscription) {
                console.log('Existing subscription found');
                await this.updateSubscription();
            }

            return true;
        } catch (error) {
            console.error('Service Worker registration failed:', error);
            return false;
        }
    }

    async requestPermission() {
        if (Notification.permission === 'granted') {
            return await this.subscribe();
        }

        if (Notification.permission === 'denied') {
            console.warn('Notification permission denied');
            return false;
        }

        // Show custom modal for permission request
        const permission = await this.showPermissionModal();
        
        if (permission === 'granted') {
            return await this.subscribe();
        }

        return false;
    }

    async showPermissionModal() {
        return new Promise((resolve) => {
            // Custom modal implementation
            const modal = document.createElement('div');
            modal.className = 'notification-permission-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>🔔 Notifiche Push</h3>
                    </div>
                    <div class="modal-body">
                        <p>Vuoi ricevere notifiche immediate per:</p>
                        <ul>
                            <li>✅ Conferme appuntamenti</li>
                            <li>⏰ Promemoria urgenti</li>
                            <li>📅 Modifiche dell'ultimo minuto</li>
                        </ul>
                        <p>Puoi disattivarle in qualsiasi momento.</p>
                    </div>
                    <div class="modal-actions">
                        <button id="allow-notifications" class="btn-primary">
                            Attiva Notifiche
                        </button>
                        <button id="deny-notifications" class="btn-secondary">
                            Non Ora
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            document.getElementById('allow-notifications').onclick = async () => {
                const permission = await Notification.requestPermission();
                document.body.removeChild(modal);
                resolve(permission);
            };

            document.getElementById('deny-notifications').onclick = () => {
                document.body.removeChild(modal);
                resolve('denied');
            };
        });
    }

    async subscribe() {
        try {
            this.subscription = await this.registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array(this.publicKey)
            });

            console.log('Push subscription created:', this.subscription);
            await this.sendSubscriptionToServer();
            return true;
        } catch (error) {
            console.error('Failed to subscribe:', error);
            return false;
        }
    }

    async sendSubscriptionToServer() {
        try {
            const response = await fetch('/api/notifications/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    subscription: this.subscription,
                    user_agent: navigator.userAgent,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
                })
            });

            if (!response.ok) {
                throw new Error('Failed to save subscription');
            }

            console.log('Subscription saved to server');
        } catch (error) {
            console.error('Error saving subscription:', error);
        }
    }

    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
}

// Initialize quando il DOM è pronto
document.addEventListener('DOMContentLoaded', async () => {
    const pushManager = new PushNotificationManager();
    const initialized = await pushManager.init();
    
    if (initialized) {
        // Auto-request per utenti loggati dopo 30 secondi
        setTimeout(() => {
            if (document.querySelector('#user-authenticated')) {
                pushManager.requestPermission();
            }
        }, 30000);
    }
});
```

### Backend Controller (Pianificato)
```php
// Modules/<nome progetto>/Http/Controllers/PushNotificationController.php
class PushNotificationController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'subscription' => 'required|array',
            'subscription.endpoint' => 'required|url',
            'subscription.keys' => 'required|array',
            'subscription.keys.p256dh' => 'required|string',
            'subscription.keys.auth' => 'required|string',
        ]);

        $user = auth()->user();
        
        // Salva o aggiorna subscription
        PushSubscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'endpoint' => $request->input('subscription.endpoint'),
            ],
            [
                'p256dh_key' => $request->input('subscription.keys.p256dh'),
                'auth_key' => $request->input('subscription.keys.auth'),
                'user_agent' => $request->input('user_agent'),
                'timezone' => $request->input('timezone'),
                'subscribed_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        PushSubscription::where('user_id', $user->id)
            ->where('endpoint', $request->input('endpoint'))
            ->delete();

        return response()->json(['success' => true]);
    }

    public function trackClick(Request $request): JsonResponse
    {
        // Analytics tracking
        PushNotificationTracking::create([
            'notification_id' => $request->input('notification_id'),
            'action' => $request->input('action'),
            'clicked_at' => now(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true]);
    }
}
```

---

## 📊 Modelli Database (Da Implementare)

### Push Subscription Model
```php
// Modules/<nome progetto>/Models/PushSubscription.php
class PushSubscription extends BaseModel
{
    protected $fillable = [
        'user_id', 'endpoint', 'p256dh_key', 'auth_key',
        'user_agent', 'timezone', 'subscribed_at', 'last_used_at'
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### Migration Schema
```php
// database/migrations/create_push_subscriptions_table.php
Schema::create('push_subscriptions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->text('endpoint');
    $table->string('p256dh_key');
    $table->string('auth_key');
    $table->text('user_agent')->nullable();
    $table->string('timezone')->nullable();
    $table->timestamp('subscribed_at');
    $table->timestamp('last_used_at')->nullable();
    $table->timestamps();
    
    $table->unique(['user_id', 'endpoint']);
    $table->index('user_id');
});
```

---

## 🎯 Template Notifiche (In Sviluppo)

### Tipi di Notifica
```php
// Configurazione template notifiche
class PushNotificationTemplates
{
    public static function getTemplate(string $type, array $data): array
    {
        return match($type) {
            'appointment_confirmed' => [
                'title' => '✅ Appuntamento Confermato',
                'body' => "Il tuo appuntamento del {$data['date']} è stato confermato",
                'icon' => '/icons/confirmed.png',
                'url' => route('appointments.show', $data['appointment_id']),
                'urgent' => false,
            ],
            
            'appointment_cancelled' => [
                'title' => '❌ Appuntamento Cancellato',
                'body' => "Il tuo appuntamento del {$data['date']} è stato cancellato",
                'icon' => '/icons/cancelled.png',
                'url' => route('appointments.reschedule', $data['appointment_id']),
                'urgent' => true,
            ],
            
            'final_reminder' => [
                'title' => '⏰ Appuntamento tra 30 minuti',
                'body' => "Non dimenticare il tuo appuntamento alle {$data['time']}",
                'icon' => '/icons/reminder.png',
                'url' => route('appointments.directions', $data['appointment_id']),
                'urgent' => true,
            ],
            
            'documents_required' => [
                'title' => '📄 Documenti Richiesti',
                'body' => 'Carica i documenti mancanti per completare la prenotazione',
                'icon' => '/icons/documents.png',
                'url' => route('profile.documents'),
                'urgent' => false,
            ],
            
            default => [
                'title' => '<nome progetto>',
                'body' => $data['message'] ?? 'Hai una nuova notifica',
                'icon' => '/icon-192x192.png',
                'url' => route('dashboard'),
                'urgent' => false,
            ],
        };
    }
}
```

---

## 🚀 Roadmap Implementazione

### Fase 1 (Q3 2025) - In Corso
- [x] Service Worker base ✅
- [ ] **Backend API subscription** (70%)
- [ ] **Template system** (40%)
- [ ] **Permission management UI** (30%)

### Fase 2 (Q4 2025) - Pianificato
- [ ] **Trigger automatici** da eventi sistema
- [ ] **Analytics e tracking**
- [ ] **Personalizzazione preferenze**
- [ ] **A/B testing** template

### Fase 3 (2026) - Futuro
- [ ] **Rich notifications** con azioni inline
- [ ] **Geofencing alerts**
- [ ] **Integration** con calendar apps nativi

---

## 🎨 UI/UX Considerations

### Permission Request Flow
1. **Onboarding subtlety**: Non richiedere immediatamente
2. **Value proposition**: Spiegare benefici specifici
3. **Timing ottimale**: Dopo prima azione significativa
4. **Graceful degradation**: Funzionamento senza push

### Notification Design
- **Branding consistency**: Logo e colori <nome progetto>
- **Action-oriented**: CTA chiari e specifici
- **Contextual**: Informazioni rilevanti immediate
- **Non-intrusive**: Rispetto per attenzione utente

---

## 📊 Metriche Target

### KPI Obiettivo
- **Subscription rate**: 60% utenti attivi
- **Open rate**: 70% notifiche
- **Action rate**: 40% click-through
- **Retention impact**: +25% engagement

### Analytics Tracking
- **Permission request**: Ask rate, grant rate
- **Subscription lifecycle**: Subscribe, unsubscribe, expire
- **Engagement**: Open, click, dismiss rates
- **Business impact**: Appointment no-show reduction

---

## 🔗 Collegamenti

### Documentazione Correlata
- [📄 Sistema Notifiche](./README.md) ← Torna alla panoramica
- [📄 Email Conferma Registrazione](./email_conferma_registrazione.md)
- [📄 Promemoria Appuntamento](./promemoria_appuntamento.md)
- [📄 Preferenze Notifiche](./preferenze_notifiche.md)

### Documentazione Principale
- [📄 Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
- [📄 Area Personale Paziente](../02_area_personale_paziente.md)

### Risorse Tecniche
- [📋 Web Push API](https://developer.mozilla.org/en-US/docs/Web/API/Push_API)
- [📋 Service Workers](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)
- [📋 VAPID Keys](https://tools.ietf.org/html/draft-thomson-webpush-vapid)

---

*Ultimo aggiornamento: 5 Giugno 2025*  
*Stato: Implementazione base in corso - 40% completato* 🔄