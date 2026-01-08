# Testing Frontend

## Introduzione

Questa sezione descrive le strategie e gli strumenti per il testing del frontend del CMS.

## Test Unitari

### Jest con Vue
```javascript
// tests/unit/ExampleComponent.spec.js
import { mount } from '@vue/test-utils'
import ExampleComponent from '@/components/ExampleComponent.vue'

describe('ExampleComponent', () => {
    it('renders correctly', () => {
        const wrapper = mount(ExampleComponent, {
            props: {
                title: 'Test Title'
            }
        })
        expect(wrapper.text()).toContain('Test Title')
    })
})
```

### Jest con React
```javascript
// tests/unit/ExampleComponent.test.js
import { render, screen } from '@testing-library/react'
import ExampleComponent from '@/components/ExampleComponent'

test('renders correctly', () => {
    render(<ExampleComponent title="Test Title" />)
    expect(screen.getByText('Test Title')).toBeInTheDocument()
})
```

## Test di Integrazione

### Cypress
```javascript
// cypress/e2e/example.cy.js
describe('Example Test', () => {
    it('visits the app', () => {
        cy.visit('/')
        cy.contains('Welcome').should('be.visible')
    })
})
```

### Laravel Dusk
```php
// tests/Browser/ExampleTest.php
public function testBasicExample()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('Welcome');
    });
}
```

## Test di Performance

### Lighthouse
```javascript
// package.json
{
    "scripts": {
        "test:performance": "lighthouse http://localhost:8000 --view"
    }
}
```

### Web Vitals
```javascript
// resources/js/web-vitals.js
import { getCLS, getFID, getLCP } from 'web-vitals';

function sendToAnalytics(metric) {
    console.log(metric);
}

getCLS(sendToAnalytics);
getFID(sendToAnalytics);
getLCP(sendToAnalytics);
```

## Test di Accessibilità

### Axe Core
```javascript
// tests/accessibility/axe.test.js
import { axe, toHaveNoViolations } from 'jest-axe'

expect.extend(toHaveNoViolations)

it('should demonstrate this matcher`s usage', async () => {
    const render = () => '<img src="#"/>'
    const html = render()
    expect(await axe(html)).toHaveNoViolations()
})
```

## Best Practices

1. **Copertura**
   - Testare tutti i componenti
   - Verificare gli edge cases
   - Mantenere alta la copertura

2. **Performance**
   - Testare il rendering
   - Verificare i tempi di risposta
   - Ottimizzare i bundle

3. **Accessibilità**
   - Testare con screen reader
   - Verificare la navigazione
   - Controllare i contrasti

## Risorse Utili

- [Jest Documentation](https://jestjs.io/)
- [Cypress Documentation](https://docs.cypress.io/)
- [Laravel Dusk Documentation](https://laravel.com/docs/12.x/dusk)

## Troubleshooting

### Errori Comuni

1. **Problemi di Configurazione**
   - Verificare le impostazioni
   - Controllare le dipendenze
   - Aggiornare i pacchetti

2. **Problemi di Performance**
   - Ottimizzare i test
   - Utilizzare test paralleli
   - Monitorare i tempi

3. **Problemi di Accessibilità**
   - Aggiornare gli strumenti
   - Verificare le regole
   - Documentare i problemi 

## Collegamenti tra versioni di testing.md
* [testing.md](laravel/Modules/Xot/docs/packages/testing.md)
* [testing.md](laravel/Modules/Xot/docs/development/testing.md)
* [testing.md](laravel/Modules/Cms/docs/frontoffice/testing.md)
* [testing.md](laravel/Themes/One/docs/testing.md)

