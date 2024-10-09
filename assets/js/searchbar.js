document.addEventListener('keydown', function(event) {
    if (event.ctrlKey && event.key === 'k' || event.ctrlKey && event.key === 'K') {
        event.preventDefault();
        document.getElementById('search').focus();
    }
});