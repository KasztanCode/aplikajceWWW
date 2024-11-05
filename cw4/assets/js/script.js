document.addEventListener('DOMContentLoaded', (event) => {
    const darkModeToggle = document.getElementById('darkModeToggle');

    function setDarkMode(isDark) {
        if (isDark) {
            document.body.classList.add('dark-mode');
            document.cookie = "darkMode=enabled; path=/; max-age=31536000"; // 1 year
            darkModeToggle.textContent = 'Light';
        } else {
            document.body.classList.remove('dark-mode');
            document.cookie = "darkMode=disabled; path=/; max-age=31536000";
            darkModeToggle.textContent = 'Dark';
        }
    }

    darkModeToggle.addEventListener('click', () => {
        setDarkMode(!document.body.classList.contains('dark-mode'));
    });

    function updateClock() {
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const ms = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hrs}:${ms}:${s}`;
        document.getElementById('clock').textContent = timeString;
    }

    setInterval(updateClock, 1000);
    updateClock();

    let isEnlarged = false;
    const logoText = document.getElementById('logoText');
    const fontSize = window.getComputedStyle(logoText).fontSize;
    let counter = 2;
    let fontSizeBigger = (parseInt(fontSize) * counter) + 'px';

    logoText.addEventListener('click', function() {
        if (!isEnlarged) {
            this.style.fontSize = fontSizeBigger;
            isEnlarged = true;
            counter++;
            fontSizeBigger = (parseInt(fontSize) * counter) + 'px';
        } else {
            this.style.fontSize = fontSize;
            isEnlarged = false;
        }
    });
});