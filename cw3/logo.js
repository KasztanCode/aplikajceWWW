$(document).ready(function() {
    let isEnlarged = false;
    const fontSize = $("#logoText").css('fontSize');
    let counter = 2
    let fontSizeBigger = (parseInt(fontSize) * counter) + 'px';

    $("#logoText").click(function() {
        if (!isEnlarged) {
            $(this).animate({
                fontSize: fontSizeBigger,
            }, 300);
            isEnlarged = true;
            counter++;
            fontSizeBigger = (parseInt(fontSize) * counter) + 'px';

        } else {
            $(this).animate({
                fontSize: fontSize,
            }, 300);
            isEnlarged = false;
        }
    });
});


