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
})
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
  })
  .on('blur', '.input-services-list', function () {
    setTimeout(() => {
      $(this).next('.add-adv__services-list').hide();
    }, 200)
  })
  .on('change', '#adv-photos', function (e) {
    $('.add-new-adv__photo-description').html('');
    $('.upload-file-title').hide();
    for (let i = this.files.length - 1; i >= 0; i--) {
      const reader = new FileReader();
      const files = e.target.files;
      const file = files[i];
      reader.readAsDataURL(file);

      reader.addEventListener('load', (event) => {
        $('.add-new-adv__photo-description')
          .append(`<div class="loaded-photo d-flex flex-column gap-2"><div class="wrapper-upload-image"><img src="${event.target.result}" alt="${file.name}"></div><p class="mt-1">Главное фото</p></div>`)
      });
    }

  })




