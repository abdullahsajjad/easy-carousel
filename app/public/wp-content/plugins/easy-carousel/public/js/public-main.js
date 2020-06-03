jQuery(document).ready(function ($) {

    var $owl = $('.owl-carousel.home-owl-slider');
    $owl.children().each(function (index) {
        jQuery(this).attr('data-position', index);
    });

    $owl.owlCarousel({
        center: true,
        nav: true,
        loop: true,
        items: 1,
        margin: 0,
        navText: ["", ""],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    $(document).on('click', '.item', function () {
        $owl.trigger('to.owl.carousel', $(this).data('position'));
    });
});