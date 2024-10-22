$(document).ready(function() {
    // Add hover effects to topic cards
    $(".topic-card").hover(
        function() {
            $(this).css({
                'background-color': '#e0e0e0',
                'transform': 'scale(1.5)',
                'transition': 'all 0.3s ease',
                'box-shadow': '0 5px 15px rgba(0,0,0,0.1)'
            });
        },
        function() {
            $(this).css({
                'background-color': '#f4f4f4',
                'transform': 'scale(1)',
                'transition': 'all 0.3s ease',
                'box-shadow': 'none'
            });
        }
    );

    // Add hover effect to the hero image
    $(".hero-image").hover(
        function() {
            $(this).css({
                'transform': 'scale(1.02)',
                'transition': 'transform 0.3s ease'
            });
        },
        function() {
            $(this).css({
                'transform': 'scale(1)',
                'transition': 'transform 0.3s ease'
            });
        }
    );
});