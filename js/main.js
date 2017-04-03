/* Header animation*/
$(function () {

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

    // $("._1text").animate({opacity: 1},4000, 'easeInOutSine');

    $("._1text").delay(2000).animate({opacity: 1}, 1500, 'easeInSine');
    $("._1line").delay(2000).animate({width: 340}, 1500, 'easeOutQuad');


    var currentPage = $("#main").attr("class");

    if (currentPage != "museum" && currentPage != "history") {
        if (currentPage == "book") {
            currentPage = "books";
        }
        if (currentPage == "new") {
            currentPage = "news";
        }
        if (currentPage == "museumabout") {
            currentPage = "museumabout";
        }
        $('#' + currentPage).addClass('sub-menu').find('span').css('color', '#494952');
    }


    if (currentPage == "museum" || currentPage == "news" || currentPage == "new" || currentPage == "museumabout") {
        $('#museum').addClass('active');
        $('#museumnav').css({display: 'block'});
    }
    else if (currentPage == "history" || currentPage == "books" || currentPage == "book") {
        $('#history').addClass('active');
        $('#historynav').css({display: 'block'});
    }

    $('#mouse').delay(3000).animate(
        {
            opacity: 0.5,
        }, 1000, function () {
            loop()
        });

    //jQuery.scrollSpeed(100, 1500, 'easeOutQuint');


    imageTransfiguration();

    tinymce.init({
        selector: '.tiny', plugins: 'link image',
        language: 'ru', file_browser_callback: RoxyFileBrowser
    });

});


function imageTransfiguration() {
    $('main .imgBox2 img').each(function () {
        var maxWidth = $('.imgBox2').width();
        var maxHeight = $('.imgBox2').height();
        var ratio = 0;
        var width = $(this).width();
        var height = $(this).height();

        if (width / maxWidth <= height / maxHeight) {
            ratio = maxWidth / width;
            $(this).css("width", maxWidth);
            $(this).css("height", height * ratio);
            height = height * ratio;
        }
        var width = $(this).width();
        var height = $(this).height();
        if (width / maxWidth > height / maxHeight) {
            ratio = maxHeight / height;
            $(this).css("height", maxHeight);
            $(this).css("width", width * ratio);
            width = width * ratio;
        }

        var center = $('.imgBox2'),
            imgPos = $(this, center),
            imgW = imgPos.width();
        imgH = imgPos.height();
        imgPos.css({
            marginLeft: (center.width() - imgW) / 2,
            marginTop: (center.height() - imgH) / 2
        });

    });
}


function ChangePosition() {

    var burger = $('#openNav').css('display');
    var id = 0;

    if (burger == 'none') {
        id = 1;
        var target = $('.mynav');
    }
    else {
        id = 2;
        var target = $('#openNav');
    }

    var hHeight = $('header').outerHeight();

    var scroll_top = $(this).scrollTop(); // get scroll position top

    var height_element_parent = $("main").outerHeight(); //get high parent element

    var height_element = $(target).outerHeight(); //get high of elemeneto

    var position_fixed_max = height_element_parent; //- height_element; // get the maximum position of the elemen

    if (scroll_top < hHeight) {
        $(target).css("position", "absolute");
        var position_fixed = hHeight;

    }
    else {
        if (position_fixed_max > scroll_top) {
            $(target).css("position", "fixed");
            $('.mynav').css('height', $(window).height());
            var position_fixed = 0;
        }
        else {
            $(target).css("position", "absolute");

            if ($('main').height() <= $(window).height()) {
                var position_fixed = hHeight;
                $('.mynav').css('height', height_element_parent);
            }
            else {
                var position_fixed = position_fixed_max;
                $('.mynav').css('height', $(window).height());
            }
        }
    }


    $(target).css("top", position_fixed);
}

$(window).scroll(function () {
    ChangePosition();
});

$(window).resize(function (event) {
    ChangePosition();
    imageTransfiguration();
    tinyImgSize();

});

function w3_open() {
    $(".mynav").css({display: 'block', left: -300}).animate({left: 0}, 350, 'easeOutCubic');
    $('#openNav').css({display: 'none'});
}

function w3_close() {
    $('#openNav').css({display: 'inline-block'});
    $('#main').css({marginLeft: '0%'});
    $('.mynav').animate({left: -300,}, 350, 'easeInCubic',
        function () {
            $(this).css({display: "none", left: 0});
        });
    ChangePosition();
}

function scrollToTitle() {
    jQuery('body,html').animate({scrollTop: $("header").height()}, 750, 'easeOutQuart');
}


$(window).resize(function () {
    var mainPosition = $("#main").offset();
    width = $(window).width();
    if (width >= 1840) {
        $(".mynav").css({marginLeft: mainPosition.left - 320});
    }
    else {
        $(".mynav").css({marginLeft: 0});
    }

}).resize();


function loop() {
    var pst = $("p:first");
    var scrollPosition = pst.position();
    var spTop = scrollPosition.top - 285;

    $('#scroll_btn').css(
        {
            opacity: 0.5,
            top: spTop
        });

    $('#scroll_btn')
        .animate(
            {
                opacity: 0.0,
                top: spTop + 15
            }, 1000, 'easeOutQuad', function () {
                loop();
            });
}


// для отображение, но в редакторе не так выглядит маленько, поправить
function tinyImgSize() {
    $('.post-tiny img').each(function () {
        if ($(this).width() >= $('.post-tiny').width()) {
            $(this).css({'max-width': '100%', height: 'auto'});
        }
        else {

        }
    });
}

function RoxyFileBrowser(field_name, url, type, win) {
    var roxyFileman = '../fileman/index.html';
    if (roxyFileman.indexOf("?") < 0) {
        roxyFileman += "?type=" + type;
    }
    else {
        roxyFileman += "&type=" + type;
    }
    roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
    if (tinymce.activeEditor.settings.language) {
        roxyFileman += '&langCode=' + tinymce.activeEditor.settings.language;
    }
    tinymce.activeEditor.windowManager.open({
        file: roxyFileman,
        title: 'Файловый менеджер',
        width: 850,
        height: 650,
        resizable: "yes",
        plugins: "media",
        inline: "yes",
        close_previous: "no"
    }, {window: win, input: field_name});
    return false;
}
