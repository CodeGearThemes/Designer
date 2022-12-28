(function( $ ){

	'use strict';

    const postCarouselx = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--posts-carousel').each(function(){
                var id = $(this).data('selector');
                var selector = '#block_postscarousel_'+id;
                var loop = ( $(this).data('loop') == 'yes' ) ? true: false ;
                var autoplay = ( $(this).data('autoplay') == 'yes' )? true: false;
                var spacing = ( $(this).data('spacing') )? $(this).data('spacing') : 15;
                var slideView = ( $(this).data('perview') );
				new Swiper(selector, {
					loop: loop,
                    autoplay: autoplay,
                    slidesPerView: slideView,
                    spaceBetween: spacing,
                    breakpoints: {
                        480: {
                          slidesPerView: 1,
                        },
                        880: {
                          slidesPerView: 2,
                        },
                        1080: {
                          slidesPerView: 3,
                        }
                    },
					navigation: {
						nextEl: '.swiper-button-next-'+id,
						prevEl: '.swiper-button-prev-'+id,
					},
				});

            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/posts-carouselx.default', postCarouselx );
    });

})(jQuery);