// Laravel Pizza - Main JavaScript
import Alpine from 'alpinejs'

// Initialize Alpine.js
window.Alpine = Alpine
Alpine.start()

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function () {
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault()
            const target = document.querySelector(this.getAttribute('href'))
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                })

                // Accessibility: Focus the target element
                if (target.tabIndex < 0) {
                    target.tabIndex = -1
                }
                target.focus()
            }
        })
    })

    // Add skip link for accessibility
    addSkipLink()
})

// Accessibility utility: Add skip link for screen readers
function addSkipLink() {
    const skipLink = document.createElement('a')
    skipLink.href = '#main-content'
    skipLink.textContent = 'Salta al contenuto principale'
    skipLink.className = 'sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:p-4 focus:rounded'
    skipLink.setAttribute('aria-label', 'Salta al contenuto principale')

    document.body.insertBefore(skipLink, document.body.firstChild)
}
