$(document).ready(function() {
    $('.xPoTryMN_0').animate(
        {
            'stroke-dashoffset': 0
        }, 2000, 'linear').animate(
        {
            'stroke-width': 0,
            'fill-opacity': 1
        }, 500);

    $('.xPoTryMN_1').delay(500).animate(
        {
            'stroke-dashoffset': 0
        }, 1500, 'linear').animate(
        {
            'stroke-width': 0,
            'fill-opacity': 1
        }, 500);

    $('.xPoTryMN_2').delay(1000).animate(
        {
            'stroke-dashoffset': 0
        }, 1000, 'linear').animate(
        {
            'stroke-width': 0,
            'fill-opacity': 1
        }, 500);

    $('.xPoTryMN_3').delay(1000).animate(
        {
            'stroke-dashoffset': 0
        }, 1000, 'linear');


    $('.xPoTryMN_4').delay(750).animate(
        {
            'stroke-dashoffset': 0
        }, 1000, 'linear');

    $(".header-text").delay(2000).animate({opacity: 1}, 1500, 'easeInSine');
    $(".header-line").delay(2000).animate({width: 340}, 1500, 'easeOutQuad');
});
