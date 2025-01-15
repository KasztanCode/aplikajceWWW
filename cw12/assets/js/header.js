$(document).ready(function() {
    // Logo animation
    let isEnlarged = false;
    const $logoText = $('#logoText');
    const originalSize = parseInt($logoText.css('font-size'));

    $logoText.click(function() {
        if (!isEnlarged) {
            $(this).animate({ fontSize: originalSize * 1.5 }, 300);
        } else {
            $(this).animate({ fontSize: originalSize }, 300);
        }
        isEnlarged = !isEnlarged;
    });

    // Clock update
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('pl-PL', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        $('#clock').text(time);
    }

    setInterval(updateClock, 1000);
    updateClock();
});