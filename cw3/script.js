document.addEventListener('DOMContentLoaded', (event) => {
    const darkModeToggle = document.getElementById('darkModeToggle');

    function setDarkMode(isDark) {
        if (isDark) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
            darkModeToggle.textContent = 'Light';
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
            darkModeToggle.textContent = 'Dark';
        }
    }

    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        setDarkMode(true);
    }

    darkModeToggle.addEventListener('click', () => {
        setDarkMode(!document.body.classList.contains('dark-mode'));
    });
});