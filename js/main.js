$(document).ready(function() {

    var text = $('.about'),
        allText = text.text().trim(),
        firstLetter = allText.charAt(0);
    text.html("<span style='font-size: 36px; font-family: OpenSans-Regular, sans-serif;'>" +
        firstLetter + "</span>" + allText.slice(1));

    var currentPage = $("#main").data("location");
    if (currentPage != "museum" && currentPage != "history" && currentPage != "projects" && currentPage != "student-groups") {
        switch (currentPage) {
            case 'exposition-scientists':
            case 'exposition-graduates':
                currentPage = 'exposition';
                break;
            case 'papers1':
            case 'papers2':
                currentPage = 'papers';
                break;
        }
        $('#' + currentPage).addClass('sub-menu').find('span:not(.second-line-margin)').css('color', '#494952');
    }
    var museum =  ["museum", "museumabout", "news", "exposition", "exhibitions", "calendar", "presents", "geologic"];
    var history = ["history", "history-about", "periods", "books", "papers", "leaders", "memories", "history-of-institute", "history-of-success"];
    if ($.inArray(currentPage, museum) >= 0) {
        $('#museum').addClass('active');
        $('#museumnav').show();
    }
    if ($.inArray(currentPage, history) >= 0) {
        $('#history').addClass('active');
        $('#historynav').show();
    }
    if (currentPage == "projects") {
        $('#projects').addClass('active');
    }
    if (currentPage == "student-groups") {
        $('#student-groups').addClass('active');
    }

    tinymce.init({
        selector: '.tiny', plugins: 'link image autoresize',
        autoresize_bottom_margin: 20,
        content_style: "body {margin: 14px; font-family: OpenSans-Regular, sans-serif !important;}",
        language: 'ru', file_browser_callback: RoxyFileBrowser,
        relative_urls : false,
        remove_script_host :false,
        convert_urls : true,
        style_formats: [
            {title: 'Цвет текста', items: [
                {title: 'Основной', inline: 'span', styles:{'color': '#494952'}},
                {title: 'Серый светлый', inline: 'span', styles:{'color': '#989797'}},
                {title: 'Синий СибГИУ', inline: 'span', styles:{'color': '#007bc6'}}
            ]},
            {title: 'Заголовки', items: [
                {title: 'Заголовок 1', block: 'h3', styles:{'font-size': '24px','font-family': 'OpenSans-Bold, sans-serif !important', 'color': '#494952' }},
                {title: 'Заглоовок 2', block: 'h4', styles:{'font-size': '20px','font-family': 'OpenSans-Bold, sans-serif !important', 'color': '#494952' }},
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
            {title: 'Блоки текста', items: [
                {title: 'Параграф', block: 'p', styles:{
                    'color': '#494952',
                    'font-size': '16px',
                    'font-family': 'OpenSans-Regular, sans-serif !important'
                    }},
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
        ],
        setup: function(editor) {
            editor.on('init', function(e) {
                changePosition();
            });
        }
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
        miniFooter();
    }).resize();

    var clicks = 0;
    $("#hello").on("click", function(){
        clicks++;
        var o = $("#hello");
        if(clicks == 4) {
            o.attr("src", o.attr("src").replace("/siu.png", "/siu1.png"));
            setTimeout(function() { o.attr("src", o.attr("src").replace("/siu1.png", "/siu2.png")); }, 1000);
            setTimeout(function() { o.attr("src", o.attr("src").replace("/siu2.png", "/siu3.png")); }, 2000);
            setTimeout(function() { o.attr("src", o.attr("src").replace("/siu3.png", "/siu4.png")); }, 3000);
            setTimeout(function() { o.attr("src", o.attr("src").replace("/siu4.png", "/siu.png")); clicks = 0; }, 4000);
        }
    });

    $('.input-file').each(function() {
        var $file = $(this),
            $label = $file.next('.forJsLabelFile'),
            labelVal = $label.html();
        $file.on('change', function(e) { //при изменении значения input
            var fileName = '';
            if (e.target.value)
                fileName = e.target.value.split('\\').pop(); // вырезаем имя из пути
            $label.find('.forJsFileName').html(fileName);
        });
    });

    $(window).scroll(function () {
        changePosition();
    });

    $(window).resize(function () {
        changePosition();
        imageTransfiguration();
        tinyImgSize();
        miniFooter();
    });

    snackBarFunction();
    changePosition();
    miniFooter();
});

function miniFooter() {
    var x = $(window).height();
    $("main").css({'min-height': $("body").height() > x ?
        '700px' :
        x-$('footer').height()
    });
}

function snackBarFunction() {
    var displaySnack = -20;
    $($('.login-snack-bar').get().reverse()).each(function(i) {
        displaySnack += 55;
        $(this).css({ bottom: 0, visibility: "visible", opacity: 0})
            .animate({ opacity: 1, bottom: displaySnack}, 500)
            .delay(4000)
            .animate({ bottom: 0, opacity: 0}, 500);
        setTimeout(function(){$('.login-snack-bar').css({ opacity: 0 })},5000);    //removeClass("show")},3000);

    });
}

function tinyImgSize() {
    $('.post-tiny img').each(function () {
        if ($(this).width() >= $('.post-tiny').width()) {
            $(this).css({'max-width': '100%', height: 'auto'});
        }
    });
}

function imageTransfiguration() {
    $('.image-proportional-resizing img').one('load', function() { // вызываем один раз после загрузки картинки
        var /*imgBox = $('.image-proportional-resizing'),*/
            maxWidth = $(this).closest('.image-proportional-resizing').width(),
            maxHeight = $(this).closest('.image-proportional-resizing').height(),
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
        var imgPos = $(this, $(this).closest('.image-proportional-resizing'));
        imgPos.css({
            marginLeft: ($(this).parent().width() - imgPos.width()) / 2,
            marginTop: ($(this).parent().height() - imgPos.height()) / 2
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
        scroll_top = $(this).scrollTop(),
        height_element_parent = $("main").outerHeight(),
        position_fixed_max = height_element_parent;

    /*если значение отступа прокрутки сверху меньше высоты шапки*/
    if (scroll_top < hHeight) {
        // $(target).css("position", "absolute");
        // var position_fixed = hHeight;
    }
    /*если значение отступа прокрутки сверху больше высоты шапки*/
    else {

        /*если значение отступа прокрутки сверху меньше высоты main ВСЕГДА*/
        if (position_fixed_max-$(window).height() > scroll_top) {
            $(target).css("position", "fixed");
            $(".mynav").css('height', $("main").height());
            position_fixed = 0;
        }
        else {
            $(target).css("position", "absolute");

            if ($('main').height() <= $(window).height()) {
                position_fixed = hHeight;
                $(".mynav").css('height', height_element_parent);
            }
            else {
                position_fixed = position_fixed_max-$(window).height();
                $(".mynav").css('height', $(window).height());
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


