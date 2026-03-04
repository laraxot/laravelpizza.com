# 🧘 Zen Seasonal Strategy - Notify & Xot

## 🕉️ Philosophy
The "Zen" approach to seasonality prioritized **Genericity**, **Context-Awareness**, and **Single Source of Truth**. We avoid hardcoded classes for specific holidays (e.g., `ChristmasGreetingMailable` is a "cagata").

## 🛠️ Architecture

### 1. The Context Engine (`Modules\Xot\Actions\Theme\GetThemeContextAction`)
- **Responsibility**: Determine the current thematic period (e.g., `christmas`, `easter`, `summer`).
- **Logic**: Uses dates and algorithms (like Computus for Easter).
- **Benefit**: Centralized logic for "What time of year is it?".

### 2. The Layout Resolver (`Modules\Notify\Actions\Mail\GetMailLayoutAction`)
- **Responsibility**: Find the appropriate HTML layout file in the current theme.
- **Priority Order**:
    1. `{baseName}_{context}.html` (e.g., `base_christmas.html`)
    2. `{context}.html` (e.g., `christmas.html`)
    3. `{baseName}.html` (e.g., `base.html` - Default)
- **Benefit**: Decouples visual theme from business logic.

### 3. The Unified Mailable (`Modules\Notify\app\Emails\SpatieEmail.php`)
- **Responsibility**: Render content using `MailTemplate` records and the Resolved Layout.
- **KISS**: Does not know about dates or holiday logic. It simply delegates to the Resolver.
- **Usage**:
    ```php
    public function getHtmlLayout(): string {
        return app(GetMailLayoutAction::class)->execute();
    }
    ```

## 🚫 Avoid ("Le Cagate")
- **Don't** create separate Mailable classes for holidays.
- **Don't** hardcode date logic inside Mailable classes.
- **Don't** duplicate layout resolution logic.

## 📈 Benefits
- **DRY**: Logic exists in exactly one place.
- **KISS**: Implementation is straightforward and delegated.
- **Robustness**: Fallbacks ensure emails are never broken.
- **Zen**: The system adapts harmoniously to the passage of time without manual intervention.
