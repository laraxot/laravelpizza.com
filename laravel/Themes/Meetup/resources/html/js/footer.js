document.addEventListener('DOMContentLoaded', function() {
    fetch('/components/footer.html')
        .then(response => response.text())
        .then(html => {
            const container = document.getElementById('footer-container');
            if (container) {
                container.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error fetching footer:', error);
        });
});
