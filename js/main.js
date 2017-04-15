/* Header animation*/
$( document ).ready(function() {

    var text = $('.about'),
        allText = text.text().trim(),
        firstLetter = allText.charAt(0);
    text.html("<span style='font-size: 36px; font-family: OpenSans-Regular, sans-serif;'>" +
        firstLetter + "</span>" + allText.slice(1));

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

    var currentPage = $("#main").data("location");
    if (currentPage != "museum" && currentPage != "history") {
        switch (currentPage) {
            case "new":
            case "exhibition":
                currentPage += 's';
                break;
        }
        $('#' + currentPage).addClass('sub-menu').find('span').css('color', '#494952');
    }
    var museum =  ["museum", "museumabout", "news", "exhibitions", "geologic"];
    var history = ["history", "books", "book"];
    if ($.inArray(currentPage, museum) >= 0) {
        $('#museum').addClass('active');
        $('#museumnav').show();
    }
    if ($.inArray(currentPage, history) >= 0) {
        $('#history').addClass('active');
        $('#historynav').show();
    }

    $('#mouse').delay(3000).animate(
        {
            opacity: 0.5
        }, 1000, function () {
            loop()
        });

    tinymce.init({
        selector: '.tiny', plugins: 'link image autoresize',
        autoresize_bottom_margin: 20,
        content_style: "body {margin: 14px; font-family: OpenSans-Regular, sans-serif !important}",
        language: 'ru', file_browser_callback: RoxyFileBrowser,
        style_formats: [
            {title: 'Цвет текста', items: [
                {title: 'Основной', inline: 'span', styles:{'color': '#494952'}},
                {title: 'Серый светлый', inline: 'span', styles:{'color': '#989797'}},
                {title: 'Синий Сибгиу', inline: 'span', styles:{'color': '#007bc6'}}
            ]},
            {title: 'Headers', items: [
                {title: 'Header 3', block: 'h3', styles:{'color': '#ff0000', 'font-size': '32px' }},
                {title: 'Header 4', format: 'h4'},
                {title: 'Header 5', format: 'h5'}
            ]},
            {title: 'Inline', items: [
                {title: 'Bold', icon: 'bold', format: 'bold'},
                {title: 'Italic', icon: 'italic', format: 'italic'},
                {title: 'Underline', icon: 'underline', format: 'underline'},
                {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
                {title: 'Superscript', icon: 'superscript', format: 'superscript'},
                {title: 'Subscript', icon: 'subscript', format: 'subscript'},
                {title: 'Code', icon: 'code', format: 'code'}
            ]},
            {title: 'Blocks', items: [
                {title: 'Paragraph', format: 'p', styles:{'color': '#007bc6'}},
                {title: 'Blockquote', format: 'blockquote'},
                {title: 'Div', format: 'div'},
                {title: 'Pre', format: 'pre'}
            ]},
            {title: 'Alignment', items: [
                {title: 'Left', icon: 'alignleft', format: 'alignleft'},
                {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
                {title: 'Right', icon: 'alignright', format: 'alignright'},
                {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
            ]}
        ]
    });

    imageTransfiguration();
    $(window).resize(function () {
        var mainPosition = $("#main").offset();
        var width = $(window).width();
        if (width >= 1840) {
            $(".mynav").css({marginLeft: mainPosition.left - 320});
        }
        else {
            $(".mynav").css({marginLeft: 0});
        }
    }).resize();
    $(window).scroll(function () {
        changePosition();
    });

    $(window).resize(function () {
        changePosition();
        imageTransfiguration();
        tinyImgSize();
    });
});

function tinyImgSize() {
    $('.post-tiny img').each(function () {
        if ($(this).width() >= $('.post-tiny').width()) {
            $(this).css({'max-width': '100%', height: 'auto'});
        }
    });
}

function imageTransfiguration() {
    $('.image-proportional-resizing img').one('load', function() { // вызываем один раз после загрузки картинки
        var imgBox = $('.image-proportional-resizing'),
            maxWidth = imgBox.width(),
            maxHeight = imgBox.height(),
            ratio = 0,
            width = $(this).width(),
            height = $(this).height();
        if (width / maxWidth <= height / maxHeight) {
            ratio = maxWidth / width;
            $(this).css("width", maxWidth);
            $(this).css("height", height * ratio);
            height = height * ratio;
        }
        width = $(this).width();
        if (width / maxWidth > height / maxHeight) {
            ratio = maxHeight / height;
            $(this).css("height", maxHeight);
            $(this).css("width", width * ratio);
            width = width * ratio;
        }
        var imgPos = $(this, imgBox);
        imgPos.css({
            marginLeft: (imgBox.width() - imgPos.width()) / 2,
            marginTop: (imgBox.height() - imgPos.height()) / 2
        })
    }).each(function () { // так как подписка на событие загрузки картинки могла быть уже после самой загрузки
        if (this.complete) { // проверяем для каждого элемента, не был ли он уже загружен
            $(this).trigger('load'); // если был, искусственно вызываем событие загрузки
        }
    });
}

function changePosition() {
    var target = $('#openNav'),
        burger = target.css('display');
    if (burger == 'none') {
        target = $('.mynav');
    }
    var hHeight = $('header').outerHeight(),
        scroll_top = $(this).scrollTop(), // get scroll position top
        height_element_parent = $("main").outerHeight(), //get high parent element
        position_fixed_max = height_element_parent; //- height_element; // get the maximum position of the elemen
    if (scroll_top < hHeight) {
        $(target).css("position", "absolute");
        var position_fixed = hHeight;
    }
    else {
        if (position_fixed_max > scroll_top) {
            $(target).css("position", "fixed");
            $('.mynav').css('height', $(window).height());
            position_fixed = 0;
        }
        else {
            $(target).css("position", "absolute");

            if ($('main').height() <= $(window).height()) {
                position_fixed = hHeight;
                $('.mynav').css('height', height_element_parent);
            }
            else {
                position_fixed = position_fixed_max;
                $('.mynav').css('height', $(window).height());
            }
        }
    }
    $(target).css("top", position_fixed);
}



function w3_open() {
    $(".mynav").css({display: 'block', left: -300}).animate({left: 0}, 350, 'easeOutCubic');
    $('#openNav').css({display: 'none'});
}

function w3_close() {
    $('#openNav').css({display: 'inline-block'});
    $('#main').css({marginLeft: '0%'});
    $('.mynav').animate({left: -300}, 350, 'easeInCubic',
        function () {
            $(this).css({display: "none", left: 0});
        });
    changePosition();
}

function scrollToTitle() {
    jQuery('body,html').animate({scrollTop: $("header").height()}, 750, 'easeOutQuart');
}

function loop() {
    var pst = $("p:first");
    var scrollPosition = pst.position();
    var spTop = scrollPosition.top - 285;

    $('#scroll_btn').css(
        {
            opacity: 0.5,
            top: spTop
        }).animate(
            {
                opacity: 0.0,
                top: spTop + 15
            }, 1000, 'easeOutQuad', function () {
                loop();
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
