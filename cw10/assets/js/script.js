document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');

    darkModeToggle.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('dark-mode');
        darkModeToggle.textContent = isDark ? 'Light' : 'Dark';
    });

    function updateClock() {
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const ms = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = `${hrs}:${ms}:${s}`;
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