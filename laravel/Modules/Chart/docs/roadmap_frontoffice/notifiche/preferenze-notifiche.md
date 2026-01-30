# Preferenze Notifiche - <nome progetto>

> **⚙️ Sistema di gestione personalizzata delle preferenze di notifica per utenti**

## 📊 Stato Implementazione: 30% 🔄

### Funzionalità Pianificate
- [ ] **UI gestione preferenze** (40% - in corso)
- [ ] **Backend preferences API** (30% - pianificato)
- [ ] **Granular controls** (20% - pianificato)
- [ ] **Smart defaults** (10% - pianificato)
- [ ] **Sync multi-device** (0% - futuro)

---

## 🎯 Obiettivo e Scope

### Scopo
Fornire controllo granulare sulle notifiche per migliorare UX:
- **Personalizzazione**: Ogni utente sceglie cosa ricevere
- **Canali**: Email, push, SMS per tipologia di notifica
- **Timing**: Orari preferiti per promemoria
- **Frequenza**: Controllo intensità comunicazioni
- **GDPR Compliance**: Consenso informato e revocabile

### Benefici Attesi
- **Riduzione unsubscribe**: -70% abbandoni
- **Engagement**: +35% interaction rate
- **Soddisfazione**: +50% user satisfaction
- **Compliance**: 100% GDPR conformity

---

## 🛠️ Implementazione Pianificata

### Database Schema
```php
// Migration: create_notification_preferences_table.php
Schema::create('notification_preferences', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
    // Email preferences
    $table->boolean('email_appointment_confirmations')->default(true);
    $table->boolean('email_appointment_reminders')->default(true);
    $table->boolean('email_appointment_changes')->default(true);
    $table->boolean('email_system_updates')->default(false);
    $table->boolean('email_marketing')->default(false);
    
    // Push preferences  
    $table->boolean('push_appointment_confirmations')->default(false);
    $table->boolean('push_urgent_reminders')->default(false);
    $table->boolean('push_last_minute_changes')->default(false);
    
    // SMS preferences
    $table->boolean('sms_appointment_reminders')->default(false);
    $table->boolean('sms_urgent_notifications')->default(false);
    
    // Timing preferences
    $table->time('preferred_reminder_time')->default('09:00:00');
    $table->json('quiet_hours')->nullable(); // {'start': '22:00', 'end': '08:00'}
    $table->json('blocked_days')->nullable(); // ['sunday', 'saturday']
    
    // Frequency controls
    $table->enum('reminder_frequency', ['none', 'minimal', 'standard', 'maximum'])->default('standard');
    $table->integer('max_daily_notifications')->default(5);
    
    // Consent tracking
    $table->timestamp('consented_at');
    $table->string('consent_version')->default('1.0');
    $table->json('consent_details')->nullable();
    
    $table->timestamps();
    
    $table->index('user_id');
});
```

### Model Implementation
```php
// Modules/<nome progetto>/Models/NotificationPreference.php
class NotificationPreference extends BaseModel
{
    protected $fillable = [
        'user_id',
        'email_appointment_confirmations',
        'email_appointment_reminders',
        'email_appointment_changes',
        'email_system_updates',
        'email_marketing',
        'push_appointment_confirmations',
        'push_urgent_reminders',
        'push_last_minute_changes',
        'sms_appointment_reminders',
        'sms_urgent_notifications',
        'preferred_reminder_time',
        'quiet_hours',
        'blocked_days',
        'reminder_frequency',
        'max_daily_notifications',
        'consented_at',
        'consent_version',
        'consent_details',
    ];

    protected function casts(): array
    {
        return [
            'email_appointment_confirmations' => 'boolean',
            'email_appointment_reminders' => 'boolean',
            'email_appointment_changes' => 'boolean',
            'email_system_updates' => 'boolean',
            'email_marketing' => 'boolean',
            'push_appointment_confirmations' => 'boolean',
            'push_urgent_reminders' => 'boolean',
            'push_last_minute_changes' => 'boolean',
            'sms_appointment_reminders' => 'boolean',
            'sms_urgent_notifications' => 'boolean',
            'preferred_reminder_time' => 'datetime:H:i',
            'quiet_hours' => 'array',
            'blocked_days' => 'array',
            'max_daily_notifications' => 'integer',
            'consented_at' => 'datetime',
            'consent_details' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isNotificationAllowed(string $type, string $channel = 'email'): bool
    {
        // Check quiet hours
        if ($this->isInQuietHours()) {
            return false;
        }

        // Check blocked days
        if ($this->isTodayBlocked()) {
            return false;
        }

        // Check daily limit
        if ($this->hasReachedDailyLimit()) {
            return false;
        }

        // Check specific preference
        $preference_key = "{$channel}_{$type}";
        return $this->{$preference_key} ?? false;
    }

    private function isInQuietHours(): bool
    {
        if (!$this->quiet_hours) {
            return false;
        }

        $now = now()->format('H:i');
        $start = $this->quiet_hours['start'] ?? '22:00';
        $end = $this->quiet_hours['end'] ?? '08:00';

        if ($start < $end) {
            return $now >= $start && $now <= $end;
        } else {
            return $now >= $start || $now <= $end;
        }
    }

    private function isTodayBlocked(): bool
    {
        if (!$this->blocked_days) {
            return false;
        }

        $today = strtolower(now()->format('l'));
        return in_array($today, $this->blocked_days);
    }

    private function hasReachedDailyLimit(): bool
    {
        $today_count = NotificationLog::where('user_id', $this->user_id)
            ->whereDate('sent_at', today())
            ->count();

        return $today_count >= $this->max_daily_notifications;
    }

    public static function getDefaultPreferences(): array
    {
        return [
            'email_appointment_confirmations' => true,
            'email_appointment_reminders' => true,
            'email_appointment_changes' => true,
            'email_system_updates' => false,
            'email_marketing' => false,
            'push_appointment_confirmations' => false,
            'push_urgent_reminders' => false,
            'push_last_minute_changes' => false,
            'sms_appointment_reminders' => false,
            'sms_urgent_notifications' => false,
            'preferred_reminder_time' => '09:00:00',
            'reminder_frequency' => 'standard',
            'max_daily_notifications' => 5,
        ];
    }
}
```

---

## 🎨 UI/UX Design (Wireframe)

### Preference Center Layout
```html
<!-- Mockup HTML della UI preferenze -->
<div class="notification-preferences">
    <header class="preferences-header">
        <h2>⚙️ Preferenze Notifiche</h2>
        <p>Personalizza come e quando ricevere le comunicazioni</p>
    </header>

    <!-- Email Preferences -->
    <section class="preference-section">
        <h3>📧 Notifiche Email</h3>
        <div class="preference-grid">
            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="email_confirmations" checked>
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Conferme Appuntamenti</strong>
                        <p>Ricevi email quando prenoti o modifichi un appuntamento</p>
                    </div>
                </label>
            </div>

            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="email_reminders" checked>
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Promemoria Appuntamenti</strong>
                        <p>Email di promemoria 24h e 1h prima dell'appuntamento</p>
                    </div>
                </label>
            </div>

            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="email_changes" checked>
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Modifiche e Cancellazioni</strong>
                        <p>Aggiornamenti sui cambi di orario o cancellazioni</p>
                    </div>
                </label>
            </div>

            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="email_marketing">
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Newsletter e Consigli</strong>
                        <p>Consigli di salute orale e aggiornamenti sul programma</p>
                    </div>
                </label>
            </div>
        </div>
    </section>

    <!-- Push Preferences -->
    <section class="preference-section">
        <h3>🔔 Notifiche Push</h3>
        <div class="push-intro">
            <p>Le notifiche push ti avvisano istantaneamente anche quando il browser è chiuso</p>
            <button class="enable-push-btn" id="request-push-permission">
                🔔 Attiva Notifiche Push
            </button>
        </div>
        
        <div class="preference-grid" id="push-preferences" style="display: none;">
            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="push_urgent">
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Promemoria Urgenti</strong>
                        <p>Notifiche 30 minuti prima dell'appuntamento</p>
                    </div>
                </label>
            </div>

            <div class="preference-item">
                <label class="preference-label">
                    <input type="checkbox" id="push_changes">
                    <span class="checkmark"></span>
                    <div class="preference-info">
                        <strong>Modifiche Last-Minute</strong>
                        <p>Avvisi immediati per cancellazioni o spostamenti</p>
                    </div>
                </label>
            </div>
        </div>
    </section>

    <!-- Timing Preferences -->
    <section class="preference-section">
        <h3>⏰ Orari e Frequenza</h3>
        
        <div class="timing-controls">
            <div class="timing-item">
                <label for="preferred_time">Orario Preferito Promemoria</label>
                <input type="time" id="preferred_time" value="09:00">
                <p class="help-text">I promemoria verranno inviati preferibilmente a quest'ora</p>
            </div>

            <div class="timing-item">
                <label>Ore di Silenzio</label>
                <div class="quiet-hours">
                    <input type="time" id="quiet_start" value="22:00" placeholder="Inizio">
                    <span>fino a</span>
                    <input type="time" id="quiet_end" value="08:00" placeholder="Fine">
                </div>
                <p class="help-text">Nessuna notifica in questo intervallo (eccetto urgenze)</p>
            </div>

            <div class="timing-item">
                <label>Frequenza Notifiche</label>
                <select id="frequency">
                    <option value="minimal">Minimale (solo essenziali)</option>
                    <option value="standard" selected>Standard (raccomandato)</option>
                    <option value="maximum">Massima (tutte le comunicazioni)</option>
                </select>
            </div>

            <div class="timing-item">
                <label for="daily_limit">Limite Giornaliero</label>
                <input type="range" id="daily_limit" min="1" max="20" value="5">
                <span class="limit-display">5 notifiche/giorno</span>
                <p class="help-text">Numero massimo di notifiche non urgenti al giorno</p>
            </div>
        </div>
    </section>

    <!-- Save Button -->
    <div class="preferences-actions">
        <button class="save-preferences-btn" id="save-preferences">
            💾 Salva Preferenze
        </button>
        <button class="reset-preferences-btn" id="reset-preferences">
            🔄 Ripristina Default
        </button>
    </div>

    <!-- GDPR Compliance -->
    <div class="gdpr-section">
        <h4>🔒 Privacy e Consensi</h4>
        <p>
            Le tue preferenze sono protette secondo il GDPR. 
            Puoi modificarle in qualsiasi momento o richiedere 
            la cancellazione completa dei tuoi dati.
        </p>
        <div class="gdpr-actions">
            <a href="#" class="gdpr-link">📄 Privacy Policy</a>
            <a href="#" class="gdpr-link">🗑️ Richiedi Cancellazione Dati</a>
            <a href="#" class="gdpr-link">📊 Scarica i Tuoi Dati</a>
        </div>
    </div>
</div>
```

### CSS Styling (Base)
```css
.notification-preferences {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.preferences-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e5e7eb;
}

.preference-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preference-section h3 {
    color: #1f2937;
    margin-bottom: 20px;
    font-size: 20px;
}

.preference-grid {
    display: grid;
    gap: 20px;
}

.preference-item {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.2s ease;
}

.preference-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
}

.preference-label {
    display: flex;
    align-items: flex-start;
    cursor: pointer;
    gap: 15px;
}

.preference-info strong {
    color: #1f2937;
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
}

.preference-info p {
    color: #6b7280;
    font-size: 14px;
    margin: 0;
    line-height: 1.5;
}

.checkmark {
    width: 24px;
    height: 24px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    position: relative;
    transition: all 0.2s ease;
}

input[type="checkbox"]:checked + .checkmark {
    background: #3b82f6;
    border-color: #3b82f6;
}

input[type="checkbox"]:checked + .checkmark::after {
    content: "✓";
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
}

.timing-controls {
    display: grid;
    gap: 25px;
}

.timing-item label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.timing-item input, .timing-item select {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 14px;
}

.quiet-hours {
    display: flex;
    align-items: center;
    gap: 10px;
}

.help-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 5px;
    margin-bottom: 0;
}

.preferences-actions {
    text-align: center;
    margin: 30px 0;
}

.save-preferences-btn {
    background: #059669;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    margin-right: 15px;
}

.reset-preferences-btn {
    background: #6b7280;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.gdpr-section {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-top: 30px;
}

.gdpr-actions {
    display: flex;
    gap: 20px;
    margin-top: 15px;
}

.gdpr-link {
    color: #3b82f6;
    text-decoration: none;
    font-size: 14px;
}

@media (max-width: 768px) {
    .preference-grid { grid-template-columns: 1fr; }
    .quiet-hours { flex-direction: column; align-items: flex-start; }
    .gdpr-actions { flex-direction: column; }
}
```

---

## 🚀 Roadmap Implementazione

### Fase 1 (Q3 2025) - In Corso
- [ ] **Database schema e modelli** (50%)
- [ ] **UI base preferences center** (40%)
- [ ] **CRUD API endpoints** (30%)
- [ ] **GDPR compliance basics** (20%)

### Fase 2 (Q4 2025) - Pianificato
- [ ] **Smart defaults** basati su comportamento
- [ ] **A/B testing** sui default
- [ ] **Integration** con notification system
- [ ] **Analytics** preferences usage

### Fase 3 (2026) - Futuro
- [ ] **AI-powered recommendations**
- [ ] **Behavioral triggers** per opt-in
- [ ] **Multi-device sync**
- [ ] **Granular geolocation** preferences

---

## 📊 Metriche Success

### KPI Target
- **Preference completion**: 80% users set preferences
- **Opt-in rate**: 70% maintain notifications enabled
- **Satisfaction**: +60% su notifiche personalizzate
- **Compliance**: 100% GDPR conformity

### Analytics Tracking
```php
class PreferenceAnalytics
{
    public function getUsageStats(): array
    {
        return [
            'total_users_with_preferences' => User::whereHas('notificationPreferences')->count(),
            'avg_preferences_per_user' => $this->getAveragePreferencesEnabled(),
            'most_popular_preferences' => $this->getMostPopularPreferences(),
            'least_popular_preferences' => $this->getLeastPopularPreferences(),
            'daily_preference_changes' => $this->getDailyChanges(),
        ];
    }

    private function getMostPopularPreferences(): array
    {
        return [
            'email_appointment_confirmations' => 95,  // %
            'email_appointment_reminders' => 89,      // %
            'email_appointment_changes' => 87,        // %
            'push_urgent_reminders' => 34,            // %
            'sms_appointment_reminders' => 12,        // %
        ];
    }
}
```

---

## 🔒 Privacy e GDPR

### Consent Management
```php
class ConsentManager
{
    public function recordConsent(User $user, array $preferences, string $version = '1.0'): void
    {
        $consentDetails = [
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'preferences_set' => $preferences,
            'consent_method' => 'preferences_center',
            'version' => $version,
        ];

        NotificationPreference::updateOrCreate(
            ['user_id' => $user->id],
            array_merge($preferences, [
                'consented_at' => now(),
                'consent_version' => $version,
                'consent_details' => $consentDetails,
            ])
        );
    }

    public function revokeConsent(User $user): void
    {
        $user->notificationPreferences()->delete();
        $user->pushSubscriptions()->delete();
        
        // Log revocation for audit
        ConsentLog::create([
            'user_id' => $user->id,
            'action' => 'revoked',
            'timestamp' => now(),
            'ip_address' => request()->ip(),
        ]);
    }
}
```

---

## 🔗 Collegamenti

### Documentazione Correlata
- [📄 Sistema Notifiche](./README.md) ← Torna alla panoramica
- [📄 Email Conferma Registrazione](./email_conferma_registrazione.md)
- [📄 Notifiche Push](./notifiche_push.md)
- [📄 Promemoria Appuntamento](./promemoria_appuntamento.md)

### Documentazione Principale
- [📄 Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
- [📄 Area Personale Paziente](../02_area_personale_paziente.md)

### Risorse Legali e Tecniche
- [📋 GDPR Compliance Guide](https://gdpr.eu/)
- [📋 Web Notifications Best Practices](https://developers.google.com/web/fundamentals/push-notifications)

---

*Ultimo aggiornamento: 5 Giugno 2025*  
*Stato: Pianificazione e design UI in corso - 30% completato* 📋