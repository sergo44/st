import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'owl-carousel/owl-carousel/owl.carousel';


$(document).ready(function () {
    $('.reviews-block__photo-slider').owlCarousel({
        items: 3,
        loop: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path d="M7.5 13.25L1.25 7L7.5 0.75" stroke="#646362" stroke-linecap="round" stroke-linejoin="round"/>\n' +
            '</svg>',
            '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path d="M0.5 0.75L6.75 7L0.5 13.25" stroke="#646362" stroke-linecap="round" stroke-linejoin="round"/>\n' +
            '</svg>'
        ],
        responsive: {
            // breakpoint from 0 up
            0: {
                margin: 4,
                items: 2.3,
                nav: true,
            },
            // breakpoint from 480 up
            480: {
                margin: 4,
                items: 2.1,
                nav: true,


            },
            // breakpoint from 768 up
            576: {
                margin: 4,
                items: 2.2,
                nav: true,
            },
            768: {
                margin: 4,
                items: 3,
                nav: true,
            },
            992: {
                nav: true,
                margin: 4,
                items: 3,
            }
        }

    });
});

$(document).ready(function() {

    $(document)
        .on('click', '[data-bs-toggle]', function () {
            $('[data-bs-toggle]').removeClass('active');
            $(this).addClass('active');
        })
        .on('click', '.mobile-menu__icon', function (e) {
            e.preventDefault();
            $('.header-menu').fadeIn(200);
        })
        .on('click', '.header-menu__wrapper-close', function (e) {
            e.preventDefault();
            $('.header-menu').fadeOut(200);
        })
        .on('click', '.sorting-variant', function () {
            $('.sorting-variant').removeClass('active');
            $(this).addClass('active');
        })
        .on('click', '.wrapper-crossed-eye', function () {
            $(this).siblings('input').attr('type', 'text');
            $(this).hide().siblings('.wrapper-not-crossed-eye').show();
        })
        .on('click', '.wrapper-not-crossed-eye', function () {
            $(this).siblings('input').attr('type', 'password');
            $(this).hide().siblings('.wrapper-crossed-eye').show();
        })
        .on('click', '.attention-block .btn-close', function () {
            $(this).closest('.attention-block').slideUp(200);
        })
        .on('click', '.section-ads__three-dots', function () {
            $(this).find('.section-ads__edit').toggle(200);
        })
        .on('click', '.unlock', function () {
            $(this).prev('.section-ads__numbers').slideDown(200)
            $(this).find('span').text('Свернуть');
            $(this).toggleClass('lock');
            $(this).toggleClass('unlock');
            $(this).find('svg').toggleClass('rotate');
        })
        .on('click', '.lock', function () {
            $(this).prev('.section-ads__numbers').slideUp(200)
            $(this).find('span').text('Развернуть');
            $(this).toggleClass('lock');
            $(this).toggleClass('unlock');
            $(this).find('svg').toggleClass('rotate');
        })
        .on('click', '.ads-remove', function (e) {
            e.preventDefault();
            $('.popup-remove-ads').show();
        })
        .on('click', '.close-ads-window', function () {
            $(this).closest('.popup-remove-ads').hide();
        })
        .on('focus', '.input-services-list', function () {
            $(this).next('.add-adv__services-list').show();
        })
        .on('click', '.add-adv__services-list li a', function (e) {
            e.preventDefault();
            const serviceItem = $(this).text();
            $(this).closest('ul').prev('input').val(serviceItem);
            $(this).closest('div').find('input[type=hidden]').val( $(this).attr("data-value") );

        })
        .on('click', '[data-toggle-country]', function() {
            let $form = $(this).closest('form');
            let $ul = $form.find("ul.j-region-ul-list");

            $.ajax({
                url: "/Api/Regions/Get/" + $form.find("input[name=country_id]").val(),
                method: "get",
                dataType: "json",
                success: function(res) {
                    $ul.html('');
                    $(res).each(function(k, v) {
                        $($ul).append("<li><a class=\"d-block\" href=\"#\" data-value=\"" + v.region_id + "\" data-toggle-region=\"1\">" + v.name + "</a></li>");
                    });
                },
                error: function() {
                    alert("Произошла непредвиденная ошибка при выполнении запроса к серверу, пожалуйста, проверьте связь с интернетом и попробуйте еще раз")
                }
            });
        })
        .on('click', '[data-toggle-region]', function() {
            let $form = $(this).closest('form');
            let $ul = $form.find("ul.j-city-ul-list");

            $.ajax({
                url: "/Api/Cities/Get/" + $form.find("input[name=region_id]").val(),
                method: "get",
                success: function(res) {
                    $ul.html('');
                    $(res).each(function(k, v) {
                        $($ul).append("<li><a class=\"d-block\" href=\"#\" data-value=\"" + v.city_id + "\" data-toggle-region=\"1\">" + v.name + "</a></li>");
                    });
                },
                error: function() {
                    alert("Произошла непредвиденная ошибка при выполнении запроса к серверу, пожалуйста, проверьте связь с интернетом и попробуйте еще раз");
                }
            });
        })
        .on('blur', '.input-services-list', function () {
            setTimeout(() => {
                $(this).next('.add-adv__services-list').hide();
            }, 200)
        })

});

$(document).ready(function(){
    $(document).on('mouseover','.up-button', function () {
        $(this).find('svg').attr('fill', '#926037');
        $(this).css('box-shadow', 'none')
    })
    $(document).on('mouseleave','.up-button', function () {
        $(this).removeClass('shadow-blue');
        $(this).find('svg').attr('fill', '#926037');
        $(this).css('box-shadow', '0 0 10px 0 #926037')
    })
    $(document).on('click','.up-button', function () {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });
    $(window).scroll(function () {
        let $appButton = $(".up-button");

        if ($(window).scrollTop() > 1000) {
            $appButton.css('box-shadow', '0 0 10px 0 #926037')
            $appButton.addClass('translate');
        } else {
            $appButton.css('box-shadow', 'none');
            $appButton.removeClass('translate');
        }
    });
})



