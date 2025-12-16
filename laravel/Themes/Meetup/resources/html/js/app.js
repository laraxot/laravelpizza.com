// Laravel Pizza - Main JavaScript
import './components/AppHeader.js';


// Cart management with localStorage persistence
class PizzaCart {
    constructor() {
        this.cartKey = 'laravelpizza_cart';
        this.cart = this.getCartFromStorage();
        this.updateCartDisplay();
    }

    getCartFromStorage() {
        const cartData = localStorage.getItem(this.cartKey);
        return cartData ? JSON.parse(cartData) : [];
    }

    saveCartToStorage() {
        localStorage.setItem(this.cartKey, JSON.stringify(this.cart));
    }

    addItem(pizzaId, pizzaName, price = 0) {
        // Check if item already exists in cart
        const existingItem = this.cart.find(item => item.id === pizzaId);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push({
                id: pizzaId,
                name: pizzaName,
                price: price,
                quantity: 1
            });
        }

        this.saveCartToStorage();
        this.updateCartDisplay();

        // Announce to screen readers
        this.announceToScreenReader(`${pizzaName} aggiunta al carrello`);
    }

    removeItem(pizzaId) {
        this.cart = this.cart.filter(item => item.id !== pizzaId);
        this.saveCartToStorage();
        this.updateCartDisplay();
    }

    updateQuantity(pizzaId, quantity) {
        const item = this.cart.find(item => item.id === pizzaId);
        if (item) {
            if (quantity <= 0) {
                this.removeItem(pizzaId);
            } else {
                item.quantity = quantity;
                this.saveCartToStorage();
                this.updateCartDisplay();
            }
        }
    }

    getCartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    getCartCount() {
        return this.cart.reduce((count, item) => count + item.quantity, 0);
    }

    updateCartDisplay() {
        const cartCountElements = document.querySelectorAll('#cart-count');
        const cartTotalElements = document.querySelectorAll('#cart-total');

        cartCountElements.forEach(element => {
            if (element) {
                element.textContent = this.getCartCount();
                element.setAttribute('aria-label', `Carrello, ${this.getCartCount()} elementi`);
            }
        });

        cartTotalElements.forEach(element => {
            if (element) {
                element.textContent = this.getCartTotal().toFixed(2) + '€';
            }
        });
    }

    announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;

        document.body.appendChild(announcement);

        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }

    getCartItems() {
        return this.cart;
    }

    clearCart() {
        this.cart = [];
        this.saveCartToStorage();
        this.updateCartDisplay();
    }
}

// Initialize cart
let pizzaCart;

document.addEventListener('DOMContentLoaded', function () {
    // Initialize cart
    pizzaCart = new PizzaCart();

    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            const isExpanded = mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
        });
    }

    // Cart functionality for add to cart buttons
    const cartButtons = document.querySelectorAll('.add-to-cart');
    cartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const pizzaId = this.dataset.pizzaId;
            const pizzaName = this.dataset.pizzaName;
            const pizzaPrice = parseFloat(this.dataset.pizzaPrice) || 0;

            pizzaCart.addItem(pizzaId, pizzaName, pizzaPrice);
            showNotification(`${pizzaName} aggiunta al carrello!`);
        });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Accessibility: Focus the target element
                if (target.tabIndex < 0) {
                    target.tabIndex = -1;
                }
                target.focus();
            }
        });
    });

    // Enhanced form validation with better accessibility
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!validateForm(form)) {
                e.preventDefault();
                showNotification('Per favore completa tutti i campi obbligatori', 'error');
            }
        });
    });

    // Add keyboard support for category filters
    document.querySelectorAll('.category-filter').forEach(button => {
        button.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});

// Cart Management
function addToCart(pizzaId, pizzaName, price = 0) {
    if (pizzaCart) {
        pizzaCart.addItem(pizzaId, pizzaName, price);
    } else {
        console.warn('Cart not initialized');
    }
}

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
    notification.textContent = message;
    notification.setAttribute('role', 'alert');
    notification.setAttribute('aria-live', 'assertive');

    document.body.appendChild(notification);

    // Remove after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

function updateCartCount() {
    if (pizzaCart) {
        pizzaCart.updateCartDisplay();
    }
}

// Enhanced form validation with better accessibility
function validateForm(form) {
    const requiredInputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    const invalidInputs = [];

    requiredInputs.forEach(input => {
        // Remove previous error styling
        input.classList.remove('border-red-500', 'ring-red-500');

        if (!input.value.trim()) {
            isValid = false;
            invalidInputs.push(input);
            input.classList.add('border-red-500');

            // Add error message if not already present
            const errorId = input.id + '-error';
            let errorElement = document.getElementById(errorId);

            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.id = errorId;
                errorElement.className = 'text-red-500 text-sm mt-1';
                errorElement.textContent = 'Questo campo è obbligatorio';
                errorElement.setAttribute('aria-live', 'polite');

                // Insert error message after the input
                input.parentNode.insertBefore(errorElement, input.nextSibling);
            }
        } else {
            // Remove error message if field is valid
            const errorId = input.id + '-error';
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.remove();
            }
        }
    });

    if (!isValid && invalidInputs.length > 0) {
        // Focus the first invalid input
        invalidInputs[0].focus();
    }

    return isValid;
}

// Utility function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('it-IT', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount);
}

// Accessibility utility: Add skip link for screen readers
function addSkipLink() {
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.textContent = 'Salta al contenuto principale';
    skipLink.className = 'sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:p-4 focus:rounded';
    skipLink.setAttribute('aria-label', 'Salta al contenuto principale');

    document.body.insertBefore(skipLink, document.body.firstChild);
}

// Initialize skip link when DOM is loaded
document.addEventListener('DOMContentLoaded', addSkipLink);

