import Alpine from 'alpinejs'

window.Alpine = Alpine


document.addEventListener('alpine:init', () => {
    document.querySelectorAll('.dropdown').forEach((dropdown, index) => {
        dropdown.setAttribute('x-data', '{ open: false }');
        
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (toggle) {
            toggle.removeAttribute('data-bs-toggle');
            toggle.setAttribute('x-on:click', 'open = !open');
        }
        
        const menu = dropdown.querySelector('.dropdown-menu');
        if (menu) {
            menu.classList.remove('show');
            menu.setAttribute(':class', "{ 'show': open }");
        }
        
        dropdown.querySelectorAll('.dropdown-item').forEach(item => {
            item.setAttribute('x-on:click', 'open = false');
        });
        
        
    });
});


Alpine.start()