(function( $ ){

	'use strict';

    const postSliderx = ($scope, $) => {
        if( $scope.length > 0 ){
            $('.block--posts-slider').each(function(){
                var id = $(this).data('selector');
                var selector = '#block_postslider_'+id;
                var loop = ( $(this).data('loop') == 'yes' ) ? true: false ;
                var autoplay = ( $(this).data('autoplay') == 'yes' )? true: false;
				new Swiper(selector, {
					loop: loop,
                    autoplay: autoplay,
					navigation: {
						nextEl: '.swiper-button-next-'+id,
						prevEl: '.swiper-button-prev-'+id,
					},
				});

            })
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/posts-sliderx.default', postSliderx );
    });

})(jQuery);