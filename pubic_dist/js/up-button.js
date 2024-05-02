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
        if ($(window).scrollTop() > 1000) {
            $('.up-button').css('box-shadow', '0 0 10px 0 #926037')
            $('.up-button').addClass('translate');
        } else {
            $('.up-button').css('box-shadow', 'none');
            $('.up-button').removeClass('translate');
        }
    });
})
