// Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('modal', () => ({
        open: false,
        init() {
            // Initialize modal
        }
    }));
});

// Dropdown
document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        init() {
            // Initialize dropdown
        }
    }));
});

// Tabs
document.addEventListener('alpine:init', () => {
    Alpine.data('tabs', () => ({
        active: 0,
        init() {
            // Initialize tabs
        }
    }));
});

// Accordion
document.addEventListener('alpine:init', () => {
    Alpine.data('accordion', () => ({
        open: false,
        init() {
            // Initialize accordion
        }
    }));
}); 