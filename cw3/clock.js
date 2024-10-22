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