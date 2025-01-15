// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Ensure jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }

    // Dark mode functionality
    const $darkModeToggle = $('#darkModeToggle');
    const $body = $('body');

    // Check initial dark mode state
    const isDarkMode = localStorage.getItem('darkMode');
    if (isDarkMode === 'true') {
        $body.addClass('dark-mode');
        $darkModeToggle.text('Light');
    }

    // Dark mode toggle handler
    $darkModeToggle.on('click', function() {
        $body.toggleClass('dark-mode');
        const isDark = $body.hasClass('dark-mode');
        $(this).text(isDark ? 'Light' : 'Dark');
        localStorage.setItem('darkMode', isDark);
    });

    // Form submission handling (keeping this from original script)
    $('form').submit(function(e) {
        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        const originalText = $button.text();

        $button.prop('disabled', true).text('Sending...');

        setTimeout(() => {
            $button.prop('disabled', false).text(originalText);
        }, 1000);
    });
});