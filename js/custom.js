$(document).ready(function() {
    $(".answer").slideToggle(0);
    $(".question").click(function () {
        $(this).next().siblings('.answer').slideUp();
        $(this).next().slideToggle("slow");
    });
});